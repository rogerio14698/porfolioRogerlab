const discoveryMotion = matchMedia('(prefers-reduced-motion: reduce)');
let disposeDiscovery: (() => void) | undefined;

function initDiscovery(): void {
    disposeDiscovery?.();
    disposeDiscovery = undefined;
    const carousel = document.querySelector<HTMLElement>('[data-discovery]');
    if (!carousel) return;
    const track = carousel.querySelector<HTMLElement>('.discovery__track');
    const slides = Array.from(carousel.querySelectorAll<HTMLElement>('.discovery__slide'));
    const playback = carousel.querySelector<HTMLButtonElement>('[data-discovery-playback]');
    if (!track || !playback || !slides.length) return;

    const controller = new AbortController();
    const { signal } = controller;
    let timer: ReturnType<typeof setTimeout> | undefined;
    let frame = 0;
    let active = 0;
    let requested: number | null = null;
    let paused = false;
    let hovered = false;
    let touching = false;
    let visible = false;
    carousel.dataset.ready = 'true';
    playback.hidden = slides.length < 2;

    const stop = (): void => {
        clearTimeout(timer);
        timer = undefined;
    };
    const canPlay = (): boolean => slides.length > 1 && !paused && !hovered && !touching &&
        visible && !document.hidden && !discoveryMotion.matches && !carousel.contains(document.activeElement);

    const syncPlayback = (): void => {
        const enabled = !paused && !discoveryMotion.matches;
        carousel.dataset.playing = String(enabled);
        playback.disabled = discoveryMotion.matches;
        playback.setAttribute('aria-label', discoveryMotion.matches ? playback.dataset.reducedLabel! :
            enabled ? playback.dataset.pauseLabel! : playback.dataset.playLabel!);
        playback.title = playback.getAttribute('aria-label')!;
        track.setAttribute('aria-live', enabled ? 'off' : 'polite');
    };
    const schedule = (): void => {
        stop();
        syncPlayback();
        if (canPlay()) {
            timer = setTimeout(() => {
                move(1);
                schedule();
            }, 8000);
        }
    };
    const move = (step: number): void => {
        requested = ((requested ?? active) + step + slides.length) % slides.length;
        track.scrollTo({
            left: slides[requested].offsetLeft - slides[0].offsetLeft,
            behavior: discoveryMotion.matches ? 'instant' : 'smooth',
        });
    };
    const update = (): void => {
        const left = track.getBoundingClientRect().left;
        active = slides.reduce((nearest, slide, index) =>
            Math.abs(slide.getBoundingClientRect().left - left) <
            Math.abs(slides[nearest].getBoundingClientRect().left - left) ? index : nearest, 0);
        carousel.dataset.activeSlide = String(active);
        frame = 0;
    };

    playback.addEventListener('click', () => {
        paused = !paused;
        if (!paused) playback.blur();
        schedule();
    }, { signal });
    carousel.addEventListener('pointerenter', (event) => {
        if (event.pointerType === 'mouse') {
            hovered = true;
            schedule();
        }
    }, { signal });
    carousel.addEventListener('pointerleave', (event) => {
        if (event.pointerType === 'mouse') {
            hovered = false;
            schedule();
        }
    }, { signal });
    carousel.addEventListener('focusin', (event) => {
        // Keyboard reading stops rotation until the visitor explicitly starts it again.
        if (event.target !== playback) paused = true;
        schedule();
    }, { signal });
    carousel.addEventListener('focusout', () => {
        queueMicrotask(() => { if (!signal.aborted) schedule(); });
    }, { signal });
    track.addEventListener('pointerdown', () => {
        touching = true;
        requested = null;
        schedule();
    }, { signal });
    const release = (): void => {
        if (!touching) return;
        touching = false;
        schedule();
    };
    document.addEventListener('pointerup', release, { signal });
    document.addEventListener('pointercancel', release, { signal });
    track.addEventListener('keydown', (event) => {
        if (event.target !== track || !['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
        event.preventDefault();
        move(event.key === 'ArrowLeft' ? -1 : 1);
    }, { signal });
    track.addEventListener('scroll', () => {
        if (!frame) frame = requestAnimationFrame(update);
    }, { passive: true, signal });
    track.addEventListener('scrollend', () => {
        cancelAnimationFrame(frame);
        update();
        requested = null;
        schedule();
    }, { signal });
    document.addEventListener('visibilitychange', schedule, { signal });
    discoveryMotion.addEventListener('change', schedule, { signal });

    const observer = new IntersectionObserver((entries) => {
        visible = entries[0].isIntersecting && entries[0].intersectionRatio >= 0.35;
        schedule();
    }, { threshold: [0, 0.35] });
    observer.observe(carousel);
    update();
    schedule();
    disposeDiscovery = () => {
        stop();
        cancelAnimationFrame(frame);
        controller.abort();
        observer.disconnect();
    };
}

document.addEventListener('DOMContentLoaded', initDiscovery);
document.addEventListener('partial:navigation:loaded', initDiscovery);
