<div class="blog-gallery" data-blog-gallery aria-label="{{ __('blog.gallery') }}"
    data-count-label="{{ __('blog.image_count') }}">
    <div class="blog-gallery__track">
        @forelse ($post->images as $image)
            <figure class="blog-image">
                <img src="{{ route('blog.image', $image) }}" alt="{{ $image->localizedAlt() }}"
                    loading="lazy" decoding="async" data-fallback-src="{{ asset(config('blog.fallback_image')) }}">
            </figure>
        @empty
            <figure class="blog-image blog-image--logo">
                <img src="{{ asset($post->image ?: config('blog.fallback_image')) }}"
                    alt="{{ $post->image ? $post->localized('title') : __('blog.logo_alt') }}"
                    loading="lazy" decoding="async" data-fallback-src="{{ asset(config('blog.fallback_image')) }}">
            </figure>
        @endforelse
    </div>
    @if ($post->images->count() > 1)
        <div class="blog-gallery__controls" hidden>
            <button type="button" class="blog-button blog-button--secondary" data-gallery-prev>{{ __('blog.previous') }}</button>
            <span data-gallery-count aria-live="polite" aria-atomic="true">{{ __('blog.image_count', ['current' => 1, 'total' => $post->images->count()]) }}</span>
            <button type="button" class="blog-button blog-button--secondary" data-gallery-next>{{ __('blog.next') }}</button>
        </div>
    @endif
</div>
