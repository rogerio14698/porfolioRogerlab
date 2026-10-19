<section class="blog">
    @if (isset($article))
        <article class="blog-detail">
            @if ($preview ?? false)
                <p class="blog-notice">{{ __('blog.preview_note') }}</p>
                <a class="blog-link" href="{{ route('admin.blog.edit', ['blog' => $article, 'lang' => app()->getLocale()]) }}">{{ __('blog.edit') }}</a>
            @endif
            <header class="blog-header">
                <h1>{{ $article->localized('title') }}</h1>
                @if ($article->published_at)
                    <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->format('d/m/Y') }}</time>
                @endif
            </header>
            @include('blog.gallery', ['post' => $article])
            <div class="blog-content">{{ $article->localized('content') }}</div>
            <a class="blog-link" href="{{ route('blog', ['lang' => app()->getLocale()]) }}">{{ __('blog.back') }}</a>
        </article>
    @else
        <header class="blog-header">
            <h1>{{ __('blog.heading') }}</h1>
            <p>{{ __('blog.intro') }}</p>
            @if (auth()->check() && strcasecmp(auth()->user()->email, config('blog.owner_email')) === 0)
                <a class="blog-link" href="{{ route('admin.blog.index', ['lang' => app()->getLocale()]) }}">{{ __('blog.dashboard') }}</a>
            @else
                <a class="blog-link" href="{{ route('login', ['lang' => app()->getLocale()]) }}">{{ __('blog.login') }}</a>
            @endif
        </header>
        @forelse ($articles as $article)
            <article class="blog-card blog-card-with-image">
                @include('blog.gallery', ['post' => $article])
                <div class="blog-card-content">
                    <h2><a href="{{ route('blog.show', ['blog' => $article->link, 'lang' => app()->getLocale()]) }}">{{ $article->localized('title') }}</a></h2>
                    <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->format('d/m/Y') }}</time>
                    <p>{{ Str::limit($article->localized('content'), 180) }}</p>
                    <a class="blog-link" href="{{ route('blog.show', ['blog' => $article->link, 'lang' => app()->getLocale()]) }}">{{ __('blog.read') }}</a>
                </div>
            </article>
        @empty
            <p class="blog-notice">{{ __('blog.empty') }}</p>
        @endforelse
        @include('blog.pagination', ['paginator' => $articles])
    @endif
</section>
