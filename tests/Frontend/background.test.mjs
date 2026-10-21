import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { stripTypeScriptTypes } from 'node:module';
import { runInNewContext } from 'node:vm';

const source = stripTypeScriptTypes(readFileSync(new URL('../../resources/js/main.ts', import.meta.url), 'utf8'));

function setup({ width = 1440, height = 900, paused = false, reduced = false, idleSupport = true, siteKey = null, parallel = true, pendingChecks = 0 } = {}) {
    class Element extends EventTarget {
        hidden = true;
        disabled = false;
        attributes = {};
        querySelector() { return null; }
        querySelectorAll() { return []; }
        setAttribute(name, value) { this.attributes[name] = value; }
    }
    const document = new Element();
    document.readyState = 'loading';
    document.hidden = false;
    const motion = new Element();
    motion.matches = reduced;
    const toggle = new Element();
    const widget = new Element();
    widget.dataset = { sitekey: siteKey };
    const scripts = [];
    document.querySelectorAll = (selector) => selector.startsWith('[data-turnstile-widget]') && siteKey ? [widget] : [];
    document.createElement = () => new Element();
    document.head = { appendChild: (script) => scripts.push(script) };
    const idle = [];
    const draws = [];
    const frames = new Map();
    const shaderChecks = [];
    const settings = new Map([['rogerlab-background-paused', String(paused)]]);
    let contextRequests = 0;
    let nextFrame = 0;
    let contextOptions;
    const gl = new Proxy({}, {
        get(_, key) {
            if (key === 'getExtension') return () => parallel ? { COMPLETION_STATUS_KHR: 1 } : null;
            if (key === 'isContextLost') return () => false;
            if (key === 'getParameter') return () => [1, 256];
            if (key === 'getProgramParameter') return (_program, parameter) => {
                shaderChecks.push(parameter);
                return parameter !== 1 || pendingChecks-- <= 0;
            };
            if (key === 'drawArrays') return (_mode, _first, count) => draws.push(count);
            if (/^[A-Z_]+$/.test(key)) return 0;
            return () => ({});
        },
    });
    class Canvas extends Element {
        width = 0;
        height = 0;
        style = {};
        getContext(_type, options) { contextRequests++; contextOptions = options; return gl; }
    }
    const canvas = new Canvas();
    document.getElementById = (id) => id === 'mainShaderBg' ? canvas : toggle;
    const window = new Element();
    Object.assign(window, {
        innerWidth: width, innerHeight: height, devicePixelRatio: 3,
        matchMedia: () => motion,
        localStorage: { getItem: (key) => settings.get(key), setItem: (key, value) => settings.set(key, value) },
        setTimeout: (callback) => idle.push(callback),
    });
    if (idleSupport) window.requestIdleCallback = (callback) => idle.push(callback);
    const runFrame = (time) => {
        const pending = [...frames.values()];
        frames.clear();
        pending.forEach((callback) => callback(time));
    };
    runInNewContext(source, {
        document, window, console, Float32Array, HTMLCanvasElement: Canvas, HTMLButtonElement: Element,
        requestAnimationFrame: (callback) => { const id = ++nextFrame; frames.set(id, callback); return id; },
        cancelAnimationFrame: (id) => frames.delete(id),
    });
    document.dispatchEvent(new Event('DOMContentLoaded'));
    return { window, document, canvas, toggle, motion, idle, draws, frames, runFrame, settings, scripts, widget, shaderChecks,
        get contextRequests() { return contextRequests; },
        get contextOptions() { return contextOptions; },
    };
}

test('initializes the decorative GPU work only after load and an idle opportunity', async () => {
    const app = setup();
    assert.equal(app.contextRequests, 0);
    app.window.dispatchEvent(new Event('load'));
    assert.equal(app.contextRequests, 0);
    assert.equal(app.idle.length, 1);
    await app.idle[0]();
    assert.equal(app.contextRequests, 1);
    assert.equal(app.contextOptions.powerPreference, 'low-power');
    assert.equal(app.contextOptions.antialias, false);
    assert.deepEqual(app.draws, [6, 21025]);
});

test('preserves the original fullscreen resolution and particle density', async () => {
    for (const [width, height, maxParticles] of [[3840, 2160, 21025], [390, 844, 1225]]) {
        const app = setup({ width, height });
        app.window.dispatchEvent(new Event('load'));
        await app.idle[0]();
        assert.equal(app.canvas.width * app.canvas.height, width * height);
        assert.equal(app.draws[1], maxParticles);
    }
});

test('preserves thirty frames per second and pause/resume', async () => {
    const app = setup();
    app.window.dispatchEvent(new Event('load'));
    await app.idle[0]();
    app.runFrame(0);
    const initial = app.draws.length;
    app.runFrame(33);
    assert.equal(app.draws.length, initial);
    app.runFrame(34);
    assert.equal(app.draws.length, initial + 2);
    app.toggle.dispatchEvent(new Event('click'));
    assert.equal(app.frames.size, 0);
    assert.equal(app.settings.get('rogerlab-background-paused'), 'true');
    assert.equal(app.toggle.attributes['aria-pressed'], 'false');
    app.toggle.dispatchEvent(new Event('click'));
    assert.equal(app.frames.size, 1);
    assert.equal(app.settings.get('rogerlab-background-paused'), 'false');
});

test('honors saved pause, reduced motion, tab visibility and context loss', async () => {
    for (const options of [{ paused: true }, { reduced: true }]) {
        const app = setup(options);
        app.window.dispatchEvent(new Event('load'));
        await app.idle[0]();
        assert.equal(app.frames.size, 0);
        assert.equal(app.toggle.attributes['aria-pressed'], 'false');
    }
    const app = setup();
    app.window.dispatchEvent(new Event('load'));
    await app.idle[0]();
    app.document.hidden = true;
    app.document.dispatchEvent(new Event('visibilitychange'));
    assert.equal(app.frames.size, 0);
    app.document.hidden = false;
    app.document.dispatchEvent(new Event('visibilitychange'));
    assert.equal(app.frames.size, 1);
    app.motion.dispatchEvent(Object.assign(new Event('change'), { matches: true }));
    assert.equal(app.frames.size, 0);
    assert.equal(app.toggle.disabled, true);
    app.canvas.dispatchEvent(new Event('webglcontextlost'));
    assert.equal(app.canvas.hidden, true);
    assert.equal(app.toggle.disabled, true);
});

test('uses a deferred fallback without idle callbacks or parallel shader support', async () => {
    const app = setup({ idleSupport: false, parallel: false });
    app.window.dispatchEvent(new Event('load'));
    assert.equal(app.contextRequests, 0);
    await app.idle[0]();
    assert.equal(app.contextRequests, 1);
});

test('yields during parallel compilation before checking link status or drawing', async () => {
    const app = setup({ pendingChecks: 1 });
    app.window.dispatchEvent(new Event('load'));
    const initializing = app.idle[0]();
    assert.deepEqual(app.shaderChecks, [1]);
    assert.deepEqual(app.draws, []);
    assert.equal(app.idle.length, 2);
    app.idle[1]();
    await initializing;
    assert.deepEqual(app.shaderChecks, [1, 1, 0, 1, 0]);
    assert.deepEqual(app.draws, [6, 21025]);
});

test('loads Turnstile only for a configured widget and still renders it after loading', () => {
    assert.equal(setup({ siteKey: '' }).scripts.length, 0);
    const app = setup({ siteKey: 'configured-site-key' });
    assert.equal(app.scripts.length, 1);
    assert.ok(app.scripts[0].src.startsWith('https://challenges.cloudflare.com/turnstile/'));
    let rendered = 0;
    app.window.turnstile = { render: (_widget, options) => {
        assert.equal(options.sitekey, 'configured-site-key');
        rendered++;
    } };
    app.scripts[0].dispatchEvent(new Event('load'));
    assert.equal(rendered, 1);
    assert.equal(app.widget.dataset.turnstileRendered, 'true');
});
