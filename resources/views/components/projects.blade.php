<section class="seccionProjects">
    <header class="portfolio-heading">
        <h1 class="pageTitle">{{ __('portfolio.projects') }}</h1>
        <p>{{ __('portfolio.intro') }}</p>
        @if (auth()->check() && strcasecmp(auth()->user()->email, config('blog.owner_email')) === 0)
            <a class="blog-link" rel="nofollow" href="{{ route('admin.projects.index', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.edit_project') }}</a>
        @endif
    </header>
    @forelse ($projects as $project)
        @include('portfolio.project-card', ['detail' => false])
    @empty
        <p>{{ __('portfolio.empty') }}</p>
    @endforelse
    <div class="blog">
        @include('blog.pagination', ['paginator' => $projects])
    </div>
</section>
