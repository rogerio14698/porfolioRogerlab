import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { stripTypeScriptTypes } from 'node:module';
import { runInNewContext } from 'node:vm';

const source = stripTypeScriptTypes(readFileSync(new URL('../../resources/js/admin-editor.ts', import.meta.url), 'utf8'));

function setup(inAdmin = true) {
    class HTMLElement {
        constructor(parent = null) { this.parentElement = parent; }
        closest() { return inAdmin ? this : null; }
    }
    class HTMLDetailsElement extends HTMLElement { open = false; }
    let listener;
    runInNewContext(source, {
        HTMLElement, HTMLDetailsElement,
        document: { querySelector: () => null, addEventListener(type, callback, capture) {
            assert.equal(type, 'invalid');
            assert.equal(capture, true);
            listener = callback;
        } },
    });
    const outer = new HTMLDetailsElement();
    const inner = new HTMLDetailsElement(outer);
    const target = new HTMLElement(inner);
    return { outer, inner, invalidate: () => listener({ target }) };
}

test('opens every enclosing section when an admin input fails native validation', () => {
    const app = setup();
    app.invalidate();
    assert.equal(app.outer.open, true);
    assert.equal(app.inner.open, true);
});

test('does not change details on public forms', () => {
    const app = setup(false);
    app.invalidate();
    assert.equal(app.outer.open, false);
    assert.equal(app.inner.open, false);
});

test('folds the admin menu on mobile and synchronizes it across the desktop breakpoint', () => {
    const menu = { open: true };
    let onChange;
    const media = {
        matches: false,
        addEventListener(type, callback) {
            assert.equal(type, 'change');
            onChange = callback;
        },
    };
    runInNewContext(source, {
        document: { addEventListener() {}, querySelector: () => menu },
        window: { matchMedia(query) {
            assert.equal(query, '(min-width: 64rem)');
            return media;
        } },
    });
    assert.equal(menu.open, false);
    media.matches = true;
    onChange();
    assert.equal(menu.open, true);
    media.matches = false;
    onChange();
    assert.equal(menu.open, false);
});
