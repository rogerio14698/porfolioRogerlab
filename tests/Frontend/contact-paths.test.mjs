import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { stripTypeScriptTypes } from 'node:module';
import { runInNewContext } from 'node:vm';

const source = stripTypeScriptTypes(readFileSync(new URL('../../resources/js/contact-paths.ts', import.meta.url), 'utf8'));

function setup(value = '') {
    class Element extends EventTarget {
        hidden = true;
        closest() { return this; }
    }
    const document = new Element();
    const paths = new Element();
    const subject = new Element();
    subject.value = value;
    subject.focus = () => { subject.focused = true; };
    document.querySelector = selector => selector === '[data-contact-paths]' ? paths : subject;
    runInNewContext(source, { document, Element, Event });
    const click = text => {
        const button = new Element();
        button.textContent = text;
        const event = new Event('click');
        Object.defineProperty(event, 'target', { value: button });
        document.dispatchEvent(event);
    };
    return { document, paths, subject, click };
}

test('reveals contact shortcuts on full and partial navigation', () => {
    const app = setup();
    app.document.dispatchEvent(new Event('DOMContentLoaded'));
    assert.equal(app.paths.hidden, false);
    app.paths.hidden = true;
    app.document.dispatchEvent(new Event('partial:navigation:loaded'));
    assert.equal(app.paths.hidden, false);
});

test('fills an empty subject with the localized shortcut and focuses it', () => {
    for (const label of ['Una oportunidad laboral', 'A project for my business', 'Uma oportunidade de emprego']) {
        const app = setup();
        let inputs = 0;
        app.subject.addEventListener('input', () => inputs++);
        app.click(label);
        assert.equal(app.subject.value, label);
        assert.equal(app.subject.focused, true);
        assert.equal(inputs, 1);
    }
});

test('does not overwrite a subject written or restored after validation', () => {
    const app = setup('Mi consulta específica');
    app.click('Una oportunidad laboral');
    assert.equal(app.subject.value, 'Mi consulta específica');
    assert.equal(app.subject.focused, true);
});
