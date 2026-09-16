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
