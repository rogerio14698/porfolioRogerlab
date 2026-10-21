<section class="seccionProjects project-detail">
    @if ($preview ?? false)
        <div class="blog">
            <p class="blog-notice">{{ __('portfolio.preview_note') }}</p>
            <a class="blog-link" href="{{ route('admin.projects.edit', ['project' => $project, 'lang' => app()->getLocale()]) }}">{{ __('portfolio.edit_project') }}</a>
        </div>
    @endif
    @include('portfolio.project-card', ['detail' => true])
    <a class="blog-link" href="{{ route('projects', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.back') }}</a>
</section>
