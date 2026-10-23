document.addEventListener('invalid', (event: Event) => {
    const target = event.target;
    if (!(target instanceof HTMLElement) || !target.closest('.blog-admin form')) return;
    let ancestor = target.parentElement;
    while (ancestor) {
        if (ancestor instanceof HTMLDetailsElement) ancestor.open = true;
        ancestor = ancestor.parentElement;
    }
}, true);

const adminMenu = document.querySelector<HTMLDetailsElement>('[data-admin-menu]');
if (adminMenu) {
    const desktop = window.matchMedia('(min-width: 64rem)');
    adminMenu.open = desktop.matches;
    desktop.addEventListener('change', () => { adminMenu.open = desktop.matches; });
}
