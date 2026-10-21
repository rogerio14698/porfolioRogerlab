<section class="blog blog-admin">
    <header class="blog-header">
        <h1>{{ __('portfolio.projects') }}</h1>
        <a class="blog-button" href="{{ route('admin.projects.create', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.new_project') }}</a>
    </header>
    @include('blog.toolbar')
    @include('blog.messages')
    <p>{{ __('portfolio.order_help') }}</p>
    <div class="blog-admin-list">
        @forelse ($projects as $project)
            <article class="blog-admin-row">
                <div>
                    <h2>{{ $project->localized('title') }}</h2>
                    <p>{{ __('portfolio.position') }}: {{ $project->position }} · {{ $project->is_published ? __('blog.published') : __('blog.draft') }}</p>
                </div>
                <a class="blog-button" href="{{ route('admin.projects.edit', ['project' => $project, 'lang' => app()->getLocale()]) }}">{{ __('portfolio.edit_project') }}</a>
                <a class="blog-link" href="{{ route('admin.projects.preview', ['project' => $project, 'lang' => app()->getLocale()]) }}">{{ __('blog.preview') }}</a>
            </article>
        @empty
            <p>{{ __('portfolio.empty') }}</p>
        @endforelse
    </div>
    @include('blog.pagination', ['paginator' => $projects])
</section>
