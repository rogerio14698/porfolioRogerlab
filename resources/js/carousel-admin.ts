function initCarouselAdmin(root: ParentNode = document): void {
    const form = root.querySelector<HTMLFormElement>('[data-carousel-admin]');
    if (!form || form.dataset.carouselReady) return;
    form.dataset.carouselReady = 'true';

    form.querySelectorAll<HTMLInputElement>('[data-carousel-mode]').forEach((radio) => {
        radio.addEventListener('change', () => { if (radio.checked) form.dataset.mode = radio.value; });
    });

    const list = form.querySelector<HTMLOListElement>('[data-carousel-list]');
    if (!list) return;
    const announce = form.querySelector<HTMLElement>('[data-carousel-announce]');
    const items = (): HTMLLIElement[] => Array.from(list.querySelectorAll<HTMLLIElement>('[data-carousel-item]'));
    const title = (item: HTMLElement): string => item.querySelector('h2')?.textContent?.trim() ?? '';
    const changed = (): void => { form.dispatchEvent(new Event('change', { bubbles: true })); };

    const renumber = (): void => {
        const all = items();
        all.forEach((item, index) => {
            const position = item.querySelector<HTMLInputElement>('[data-carousel-position]');
            if (position) position.value = String(index + 1);
            item.querySelector<HTMLButtonElement>('[data-carousel-move="-1"]')!.disabled = index === 0;
            item.querySelector<HTMLButtonElement>('[data-carousel-move="1"]')!.disabled = index === all.length - 1;
        });
    };
    const say = (item: HTMLElement): void => {
        if (announce) announce.textContent = `${title(item)}: ${items().indexOf(item as HTMLLIElement) + 1} / ${items().length}`;
    };

    // Typing a position moves the row there, so the list always mirrors the saved order.
    list.addEventListener('change', (event) => {
        const input = event.target as HTMLElement;
        if (!input.matches('[data-carousel-position]')) return;
        const item = input.closest<HTMLLIElement>('[data-carousel-item]')!;
        const all = items().filter((other) => other !== item);
        const target = Math.min(Math.max(Number((input as HTMLInputElement).value) || 1, 1), all.length + 1) - 1;
        list.insertBefore(item, all[target] ?? null);
        renumber();
        say(item);
    });

    list.addEventListener('click', (event) => {
        const button = (event.target as HTMLElement).closest<HTMLButtonElement>('[data-carousel-move]');
        if (!button) return;
        const item = button.closest<HTMLLIElement>('[data-carousel-item]')!;
        if (button.dataset.carouselMove === '-1' && item.previousElementSibling) list.insertBefore(item, item.previousElementSibling);
        if (button.dataset.carouselMove === '1' && item.nextElementSibling) list.insertBefore(item.nextElementSibling, item);
        renumber();
        changed();
        say(item);
        (button.disabled ? item.querySelector<HTMLButtonElement>('[data-carousel-move]:not(:disabled)') : button)?.focus();
    });

    let dragged: HTMLLIElement | null = null;
    const clearTargets = (): void => items().forEach((item) => { delete item.dataset.dropTarget; });
    items().forEach((item) => {
        item.draggable = true;
        item.addEventListener('dragstart', (event) => {
            if ((event.target as HTMLElement).closest('input, button, a, label')) {
                event.preventDefault();
                return;
            }
            dragged = item;
            item.dataset.dragging = 'true';
            event.dataTransfer?.setData('text/plain', title(item));
            if (event.dataTransfer) event.dataTransfer.effectAllowed = 'move';
        });
        item.addEventListener('dragend', () => {
            delete item.dataset.dragging;
            clearTargets();
            dragged = null;
        });
        item.addEventListener('dragover', (event) => {
            if (!dragged || dragged === item) return;
            event.preventDefault();
            clearTargets();
            item.dataset.dropTarget = 'true';
        });
        item.addEventListener('drop', (event) => {
            if (!dragged || dragged === item) return;
            event.preventDefault();
            const before = items().indexOf(dragged) > items().indexOf(item) ? item : item.nextElementSibling;
            list.insertBefore(dragged, before);
            clearTargets();
            renumber();
            changed();
            say(dragged);
        });
    });

    form.querySelectorAll<HTMLButtonElement>('[data-carousel-all]').forEach((button) => {
        button.addEventListener('click', () => {
            list.querySelectorAll<HTMLInputElement>('.carousel-admin__visible input[type="checkbox"]').forEach((checkbox) => {
                checkbox.checked = button.dataset.carouselAll === '1';
            });
            changed();
        });
    });

    form.querySelectorAll<HTMLElement>('[data-carousel-move], [data-carousel-handle], [data-carousel-bulk]')
        .forEach((element) => { element.hidden = false; });
    renumber();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => initCarouselAdmin());
} else {
    initCarouselAdmin();
}

document.addEventListener('partial:navigation:loaded', (event: Event) => {
    initCarouselAdmin((event as CustomEvent<{ container?: ParentNode }>).detail?.container || document);
});
