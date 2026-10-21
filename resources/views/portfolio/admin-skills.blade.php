<section class="blog blog-admin">
    <header class="blog-header">
        <h1>{{ __('portfolio.skills') }}</h1>
        <a class="blog-button" href="{{ route('admin.skills.create', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.new_skill') }}</a>
    </header>
    @include('blog.toolbar')
    @include('blog.messages')
    <p>{{ __('portfolio.order_help') }}</p>
    <div class="blog-admin-list">
        @forelse ($skills as $skill)
            <article class="blog-admin-row">
                <div>
                    <h2>{{ $skill->label() }}</h2>
                    <p>{{ __('portfolio.position') }}: {{ $skill->position }} · {{ $skill->is_published ? __('blog.published') : __('blog.draft') }}</p>
                </div>
                <a class="blog-button" href="{{ route('admin.skills.edit', ['skill' => $skill, 'lang' => app()->getLocale()]) }}">{{ __('portfolio.edit_skill') }}</a>
            </article>
        @empty
            <p>{{ __('portfolio.no_skills') }}</p>
        @endforelse
    </div>
    @include('blog.pagination', ['paginator' => $skills])
</section>
