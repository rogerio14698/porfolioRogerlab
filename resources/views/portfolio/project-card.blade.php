<article class="cardProject project-card">
    @if ($detail)
        <header class="project-detail__heading">
            <h1>{{ $project->localized('title') }}</h1>
            <p>{{ $project->localized('period') }} · {{ $project->localized('category') }}</p>
        </header>
    @endif
    <div class="project-card__media project-card__media--capture">
        <img src="{{ $project->coverUrl() }}" alt="{{ $project->imageAlt($project->cover_index ?? 0) }}"
            width="960" height="600" loading="{{ $detail ? 'eager' : 'lazy' }}" decoding="async">
    </div>
    <div class="project-card__body">
        @unless ($detail)
            <div class="titleProject">
                <h2><a href="{{ route('projects.show', ['project' => $project->slug, 'lang' => app()->getLocale()]) }}">{{ $project->localized('title') }}</a></h2>
                <div class="project-card__meta">
                    <span>{{ $project->localized('period') }}</span>
                    <span>{{ $project->localized('category') }}</span>
                </div>
            </div>
        @endunless
        @if ($project->technologyList())
            <ul class="project-card__stack">
                @foreach ($project->technologyList() as $technology)<li>{{ $technology }}</li>@endforeach
            </ul>
        @endif
        <div class="description">
            @foreach (preg_split('/\R\s*\R/u', $detail ? $project->localized('content') : ($project->localized('summary') ?: $project->localized('content'))) as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
        <div class="project-card__actions">
            @unless ($detail)
                <a href="{{ route('projects.show', ['project' => $project->slug, 'lang' => app()->getLocale()]) }}">{{ __('portfolio.read') }}</a>
            @endunless
            @if ($project->repository_url)
                <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer">{{ __('portfolio.repository') }}</a>
            @endif
            @if ($project->website_url)
                <a href="{{ $project->website_url }}" target="_blank" rel="noopener noreferrer">{{ __('portfolio.website') }}</a>
            @endif
            @if ($project->download_path)
                <a href="{{ asset($project->download_path) }}" download>{{ __('portfolio.download') }}</a>
            @endif
        </div>
    </div>
    @if ($project->galleryIndexes())
        <div class="galeria" data-project-gallery data-gallery="{{ $project->slug }}" data-count="{{ count($project->galleryIndexes()) }}" aria-label="{{ __('portfolio.gallery') }}">
            @foreach ($project->galleryIndexes() as $index)
                <a class="galeria__item" href="{{ $project->mediaUrl($index) }}" data-project-image @if (!$detail && $loop->iteration > 3) hidden @endif>
                    <img src="{{ $project->mediaUrl($index) }}" alt="{{ $project->imageAlt($index) }}" width="480" height="360" loading="lazy" decoding="async">
                </a>
            @endforeach
        </div>
    @endif
</article>
