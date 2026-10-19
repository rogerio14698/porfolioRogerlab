const BLOG_IMAGE_SELECTOR = '.blog-image img';

function useFallbackImage(image: HTMLImageElement): void {
	if (image.dataset.fallbackUsed === 'true') {
		return;
	}

	const fallbackSource = image.dataset.fallbackSrc;

	if (!fallbackSource || image.src === fallbackSource) {
		return;
	}

	image.dataset.fallbackUsed = 'true';
	image.src = fallbackSource;
}

function markImageAsLoaded(image: HTMLImageElement): void {
	image.dataset.imageLoaded = 'true';
}

function checkAlreadyBrokenImages(root: ParentNode): void {
	root.querySelectorAll<HTMLImageElement>(BLOG_IMAGE_SELECTOR).forEach((image) => {
		if (image.complete && image.naturalWidth === 0) {
			useFallbackImage(image);
		}
	});
}

document.addEventListener('error', (event: Event) => {
	const target = event.target;

	if (target instanceof HTMLImageElement && target.matches(BLOG_IMAGE_SELECTOR)) {
		useFallbackImage(target);
	}
}, true);

document.addEventListener('load', (event: Event) => {
	const target = event.target;

	if (target instanceof HTMLImageElement && target.matches(BLOG_IMAGE_SELECTOR)) {
		markImageAsLoaded(target);
	}
}, true);

function checkBlogImages(root: ParentNode = document): void {
	checkAlreadyBrokenImages(root);
	root.querySelectorAll<HTMLElement>('[data-blog-gallery]').forEach((gallery) => {
		if (gallery.dataset.ready) return;
		gallery.dataset.ready = 'true';
		const slides = Array.from(gallery.querySelectorAll<HTMLElement>('.blog-image'));
		const controls = gallery.querySelector<HTMLElement>('.blog-gallery__controls');
		if (slides.length < 2 || !controls) return;
		let active = 0;
		const counter = gallery.querySelector<HTMLElement>('[data-gallery-count]');
		const previous = gallery.querySelector<HTMLButtonElement>('[data-gallery-prev]');
		const next = gallery.querySelector<HTMLButtonElement>('[data-gallery-next]');
		const show = (index: number) => {
			active = (index + slides.length) % slides.length;
			slides.forEach((slide, position) => { slide.hidden = position !== active; });
			if (counter) counter.textContent = (gallery.dataset.countLabel || '')
				.replace(':current', String(active + 1)).replace(':total', String(slides.length));
		};
		controls.hidden = false;
		previous?.addEventListener('click', () => show(active - 1));
		next?.addEventListener('click', () => show(active + 1));
		gallery.tabIndex = 0;
		gallery.addEventListener('keydown', (event) => {
			if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
			event.preventDefault();
			show(active + (event.key === 'ArrowLeft' ? -1 : 1));
		});
		show(0);
	});
	const uploads = root.querySelector<HTMLElement>('[data-blog-uploads]');
	const add = root.querySelector<HTMLButtonElement>('[data-add-upload]');
	const template = root.querySelector<HTMLTemplateElement>('#blog-upload-template');
	if (uploads && add && template && !uploads.dataset.ready) {
		uploads.dataset.ready = 'true';
		let index = Math.max(-1, ...Array.from(uploads.querySelectorAll<HTMLElement>('[data-upload-index]'))
			.map(row => Number(row.dataset.uploadIndex)).filter(Number.isFinite)) + 1;
		const update = () => { add.disabled = uploads.children.length >= 10; };
		const wire = (row: HTMLElement) => {
			const remove = row.querySelector<HTMLButtonElement>('[data-remove-upload]');
			if (remove) {
				remove.hidden = false;
				remove.addEventListener('click', () => { row.remove(); update(); add.focus(); });
			}
		};
		uploads.querySelectorAll<HTMLElement>('[data-upload-row]').forEach(wire);
		add.hidden = false;
		add.addEventListener('click', () => {
			if (uploads.children.length >= 10) return;
			const fragment = template.content.cloneNode(true) as DocumentFragment;
			fragment.querySelectorAll<HTMLElement>('[id], [name], [for], [data-upload-index]').forEach((element) => {
				['id', 'name', 'for', 'data-upload-index'].forEach((attribute) => {
					const value = element.getAttribute(attribute);
					if (value) element.setAttribute(attribute, value.replaceAll('__INDEX__', String(index)));
				});
			});
			index++;
			const row = fragment.querySelector<HTMLElement>('[data-upload-row]');
			if (row) wire(row);
			uploads.append(fragment);
			update();
			row?.querySelector<HTMLInputElement>('input')?.focus();
		});
	}
	root.querySelector<HTMLElement>('#blog-errors')?.focus();
	const editor = root.querySelector<HTMLFormElement>('.blog-editor');
	if (editor && !editor.dataset.ready) {
		editor.dataset.ready = 'true';
		let dirty = false;
		editor.addEventListener('input', () => { dirty = true; });
		editor.addEventListener('change', () => { dirty = true; });
		editor.addEventListener('submit', () => { dirty = false; });
		window.addEventListener('beforeunload', (event) => {
			if (!dirty) return;
			event.preventDefault();
			event.returnValue = '';
		});
	}
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', () => checkBlogImages());
} else {
	checkBlogImages();
}

document.addEventListener('partial:navigation:loaded', (event: Event) => {
	const customEvent = event as CustomEvent<{ container?: ParentNode }>;
	checkBlogImages(customEvent.detail?.container || document);
});
