import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { stripTypeScriptTypes } from 'node:module';
import { runInNewContext } from 'node:vm';

const source = stripTypeScriptTypes(readFileSync(new URL('../../resources/js/portfolio.ts', import.meta.url), 'utf8'));

function setup({ count = 3, reduced = false } = {}) {
    let now = 0;
    let nextId = 0;
    const timers = new Map();
    const moves = [];
    const observers = [];
    const event = (type, props = {}) => Object.assign(new Event(type), props);
    const timeout = (callback, delay) => {
        const id = ++nextId;
        timers.set(id, { callback, at: now + delay });
        return id;
    };
    class Element extends EventTarget {
        dataset = {};
        attributes = {};
        setAttribute(name, value) { this.attributes[name] = value; }
        getAttribute(name) { return this.attributes[name]; }
        getBoundingClientRect() { return { left: 0 }; }
    }
    const document = new Element();
    document.hidden = false;
    document.activeElement = null;
    const carousel = new Element();
    const track = new Element();
    track.scrollLeft = 0;
    const playback = new Element();
    const navigation = new Element();
    const indicators = Array.from({ length: count }, () => new Element());
    playback.dataset = { pauseLabel: 'Pause', playLabel: 'Play', reducedLabel: 'Reduced motion' };
    playback.blur = () => { document.activeElement = null; };
    const slides = Array.from({ length: count }, (_, index) => ({
        offsetLeft: index * 100,
        getBoundingClientRect: () => ({ left: index * 100 - track.scrollLeft }),
    }));
    carousel.contains = (element) => [track, playback, ...slides, ...indicators].includes(element);
    carousel.querySelector = (selector) => selector === '.discovery__track' ? track :
        selector === '[data-discovery-navigation]' ? navigation : playback;
    carousel.querySelectorAll = (selector) => selector === '[data-discovery-index]' ? indicators : slides;
    document.querySelector = () => carousel;
    track.scrollTo = (options) => {
        moves.push({ ...options, at: now });
        track.scrollLeft = options.left;
        track.dispatchEvent(event('scroll'));
        track.dispatchEvent(event('scrollend'));
    };
    const motion = new Element();
    motion.matches = reduced;
    class IntersectionObserver {
        constructor(callback) { this.callback = callback; observers.push(this); }
        observe() { this.callback([{ isIntersecting: true, intersectionRatio: 1 }]); }
        disconnect() { this.disconnected = true; }
    }
    runInNewContext(source, {
        document, matchMedia: () => motion, AbortController, IntersectionObserver,
        setTimeout: timeout, clearTimeout: (id) => timers.delete(id),
        requestAnimationFrame: (callback) => timeout(callback, 16),
        cancelAnimationFrame: (id) => timers.delete(id), queueMicrotask,
    });
    document.dispatchEvent(event('DOMContentLoaded'));
    const advance = (duration) => {
        const end = now + duration;
        while (true) {
            const entry = [...timers].filter(([, timer]) => timer.at <= end).sort((a, b) => a[1].at - b[1].at)[0];
            if (!entry) break;
            const [id, timer] = entry;
            now = timer.at;
            timers.delete(id);
            timer.callback();
        }
        now = end;
    };
    return { document, carousel, track, playback, navigation, indicators, motion, moves, observers, event, advance };
}

test('advances at exactly eight seconds, wraps, and keeps automatic changes silent', () => {
    const app = setup();
    app.advance(7999);
    assert.equal(app.moves.length, 0);
    app.advance(1);
    assert.equal(app.moves[0].at, 8000);
    assert.equal(app.moves[0].left, 100);
    app.advance(16000);
    assert.deepEqual(app.moves.map((move) => move.left), [100, 200, 0]);
    assert.equal(app.track.getAttribute('aria-live'), 'off');
});

test('explicit pause persists and resume gives a complete reading interval', () => {
    const app = setup();
    app.playback.dispatchEvent(app.event('click'));
    app.advance(24000);
    assert.equal(app.moves.length, 0);
    assert.equal(app.playback.getAttribute('aria-label'), 'Play');
    app.playback.dispatchEvent(app.event('click'));
    app.advance(7999);
    assert.equal(app.moves.length, 0);
    app.advance(1);
    assert.equal(app.moves.length, 1);
});

test('indicators jump forward and backward, track the active slide and pause autoplay', () => {
    const app = setup();
    assert.equal(app.indicators[0].getAttribute('aria-current'), 'true');
    app.indicators[2].dispatchEvent(app.event('click'));
    assert.equal(app.moves.at(-1).left, 200);
    assert.equal(app.indicators[2].getAttribute('aria-current'), 'true');
    assert.equal(app.indicators[0].getAttribute('aria-current'), 'false');
    app.indicators[0].dispatchEvent(app.event('click'));
    assert.equal(app.moves.at(-1).left, 0);
    app.advance(16000);
    assert.equal(app.moves.length, 2);
    app.playback.dispatchEvent(app.event('click'));
    app.advance(8000);
    assert.equal(app.indicators[1].getAttribute('aria-current'), 'true');
});

test('indicators work with reduced motion and synchronize with native scrolling', () => {
    const app = setup({ reduced: true });
    app.indicators[2].dispatchEvent(app.event('click'));
    assert.equal(app.moves.at(-1).behavior, 'instant');
    app.track.scrollLeft = 100;
    app.track.dispatchEvent(app.event('scroll'));
    app.advance(16);
    assert.equal(app.indicators[1].getAttribute('aria-current'), 'true');
    assert.equal(app.indicators[2].getAttribute('aria-current'), 'false');
});

test('hover, touch, hidden tabs and offscreen content suspend playback', () => {
    const app = setup();
    const pauses = [
        [() => app.carousel.dispatchEvent(app.event('pointerenter', { pointerType: 'mouse' })),
            () => app.carousel.dispatchEvent(app.event('pointerleave', { pointerType: 'mouse' }))],
        [() => app.track.dispatchEvent(app.event('pointerdown')),
            () => app.document.dispatchEvent(app.event('pointerup'))],
        [() => { app.document.hidden = true; app.document.dispatchEvent(app.event('visibilitychange')); },
            () => { app.document.hidden = false; app.document.dispatchEvent(app.event('visibilitychange')); }],
        [() => app.observers[0].callback([{ isIntersecting: false, intersectionRatio: 0 }]),
            () => app.observers[0].callback([{ isIntersecting: true, intersectionRatio: 1 }])],
    ];
    for (const [pause, resume] of pauses) {
        const before = app.moves.length;
        pause();
        app.advance(16000);
        assert.equal(app.moves.length, before);
        resume();
        app.advance(7999);
        assert.equal(app.moves.length, before);
        app.advance(1);
        assert.equal(app.moves.length, before + 1);
    }
});

test('keyboard reading stops rotation until explicit resume; arrows remain available', () => {
    const app = setup();
    app.document.activeElement = app.track;
    app.carousel.dispatchEvent(app.event('focusin'));
    app.advance(16000);
    assert.equal(app.moves.length, 0);
    app.track.dispatchEvent(app.event('keydown', { key: 'ArrowRight' }));
    assert.equal(app.moves[0].left, 100);
    app.track.dispatchEvent(app.event('keydown', { key: 'ArrowLeft' }));
    assert.equal(app.moves[1].left, 0);
    app.document.activeElement = null;
    app.advance(16000);
    assert.equal(app.moves.length, 2);
    app.playback.dispatchEvent(app.event('click'));
    app.advance(8000);
    assert.equal(app.moves.length, 3);
});

test('reduced motion stops playback immediately and uses instant manual scrolling', () => {
    const app = setup({ reduced: true });
    assert.equal(app.playback.disabled, true);
    assert.equal(app.playback.getAttribute('aria-label'), 'Reduced motion');
    app.advance(24000);
    assert.equal(app.moves.length, 0);
    app.track.dispatchEvent(app.event('keydown', { key: 'ArrowRight' }));
    assert.equal(app.moves[0].behavior, 'instant');
    app.motion.matches = false;
    app.motion.dispatchEvent(app.event('change'));
    app.advance(8000);
    assert.equal(app.moves.length, 2);
    app.motion.matches = true;
    app.motion.dispatchEvent(app.event('change'));
    app.advance(24000);
    assert.equal(app.moves.length, 2);
});

test('zero or one item never rotates or exposes a playback control', () => {
    for (const count of [0, 1]) {
        const app = setup({ count });
        app.advance(32000);
        assert.equal(app.moves.length, 0);
        if (count === 1) {
            assert.equal(app.playback.hidden, true);
            assert.equal(app.navigation.hidden, true);
        }
    }
});

test('partial navigation disposes observers, timers and handlers before initializing again', () => {
    const app = setup();
    app.advance(4000);
    app.document.dispatchEvent(app.event('partial:navigation:loaded'));
    assert.equal(app.observers[0].disconnected, true);
    app.advance(7999);
    assert.equal(app.moves.length, 0);
    app.advance(1);
    assert.equal(app.moves.length, 1);
    app.playback.dispatchEvent(app.event('click'));
    app.advance(16000);
    assert.equal(app.moves.length, 1);
});

test('leaving the homepage removes all carousel playback work', () => {
    const app = setup();
    app.advance(4000);
    app.document.querySelector = () => null;
    app.document.dispatchEvent(app.event('partial:navigation:loaded'));
    assert.equal(app.observers[0].disconnected, true);
    app.advance(24000);
    assert.equal(app.moves.length, 0);
});
