<section class="blog blog-admin">
    <header class="blog-header">
        <h1>{{ __('blog.dashboard') }}</h1>
        <a class="blog-button" href="{{ route('admin.blog.create', ['lang' => app()->getLocale()]) }}">{{ __('blog.new') }}</a>
    </header>
    @include('blog.toolbar')
    @include('blog.messages')
    <article class="blog-admin-row carousel-summary" aria-labelledby="carousel-summary-title">
        <div>
            <h2 id="carousel-summary-title">{{ __('portfolio.carousel_admin') }}</h2>
            <p>{{ __('portfolio.carousel_summary', [
                'mode' => __('portfolio.carousel_mode_'.$carouselSettings->mode),
                'count' => $carouselCount,
                'interval' => $carouselSettings->interval_seconds,
            ]) }}
            · {{ $carouselSettings->autoplay ? __('portfolio.carousel_autoplay_on') : __('portfolio.carousel_autoplay_off') }}</p>
        </div>
        <a class="blog-button" href="{{ route('admin.carousel.edit', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.carousel_organize') }}</a>
    </article>
    <div class="blog-admin-list">
        @forelse ($articles as $article)
            <article class="blog-admin-row">
                <div>
                    <p>{{ $article->is_published ? __('blog.published') : __('blog.draft') }}</p>
                    <h2>{{ $article->localized('title') }}</h2>
                </div>
                <a class="blog-button blog-button--secondary" href="{{ route('admin.blog.edit', ['blog' => $article, 'lang' => app()->getLocale()]) }}">{{ __('blog.edit') }}</a>
                <a class="blog-link" href="{{ route('admin.blog.preview', ['blog' => $article, 'lang' => app()->getLocale()]) }}">{{ __('blog.preview') }}</a>
            </article>
        @empty
            <p class="blog-notice">{{ __('blog.no_drafts') }}</p>
        @endforelse
    </div>
    @include('blog.pagination', ['paginator' => $articles])
</section>
