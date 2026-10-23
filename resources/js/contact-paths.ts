function initContactPaths(): void {
    const paths = document.querySelector<HTMLElement>('[data-contact-paths]');
    if (paths) paths.hidden = false;
}

document.addEventListener('click', (event: MouseEvent) => {
    if (!(event.target instanceof Element)) return;
    const button = event.target.closest<HTMLButtonElement>('[data-contact-subject]');
    if (!button) return;
    const subject = document.querySelector<HTMLInputElement>('.contactForm input[name="subject"]');
    if (!subject) return;
    if (!subject.value.trim()) {
        subject.value = button.textContent?.trim() ?? '';
        subject.dispatchEvent(new Event('input', { bubbles: true }));
    }
    subject.focus();
});

document.addEventListener('DOMContentLoaded', initContactPaths);
document.addEventListener('partial:navigation:loaded', initContactPaths);
