@if ($discoveries->isNotEmpty())
    @php
        $carouselSettings ??= \App\Models\CarouselSetting::current();
    @endphp
    <section class="discovery" aria-label="{{ __('portfolio.carousel') }}" data-discovery
        data-interval="{{ $carouselSettings->interval_seconds * 1000 }}"
        data-autoplay="{{ $carouselSettings->autoplay ? 'true' : 'false' }}"
        data-pause-hover="{{ $carouselSettings->pause_on_hover ? 'true' : 'false' }}">
        <div class="discovery__track" id="discovery-track" tabindex="0" aria-label="{{ __('portfolio.carousel') }}" aria-live="off">
            @foreach ($discoveries as $item)
                @php
                    $isProject = $item instanceof \App\Models\Project;
                    $href = $isProject
                        ? route('projects.show', ['project' => $item->slug, 'lang' => app()->getLocale()])
                        : route('blog.show', ['blog' => $item->link, 'lang' => app()->getLocale()]);
                @endphp
                <article class="discovery__slide" aria-label="{{ __('portfolio.slide', ['current' => $loop->iteration, 'total' => $discoveries->count()]) }}">
                    <a class="discovery__image" href="{{ $href }}" tabindex="-1" aria-hidden="true">
                        <img src="{{ $item->coverUrl() }}" alt="" width="960" height="600" loading="lazy" decoding="async">
                    </a>
                    <div class="discovery__copy">
                        <h2><a href="{{ $href }}">{{ $item->localized('title') }}</a></h2>
                        <p class="discovery__type">
                            {{ $isProject ? __('portfolio.project_type') : __('portfolio.blog_type') }}
                            @if (!$isProject)
                                · <time datetime="{{ $item->published_at->toDateString() }}">{{ $item->published_at->format('d/m/Y') }}</time>
                            @endif
                        </p>
                        <p>{{ Str::limit($item->localized($isProject ? 'summary' : 'content'), 230) }}</p>
                        @if ($isProject)
                            <p class="discovery__stack">{{ implode(' / ', $item->technologyList()) }}</p>
                        @endif
                        <a class="discovery__link" href="{{ $href }}">{{ $isProject ? __('portfolio.read') : __('blog.read') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="discovery__navigation" data-discovery-navigation hidden>
            @if ($carouselSettings->show_indicators)
            <div class="discovery__indicators" role="group" aria-label="{{ __('portfolio.carousel') }}">
                @foreach ($discoveries as $item)
                    <button class="discovery__indicator" type="button" data-discovery-index="{{ $loop->index }}"
                        aria-controls="discovery-track" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                        aria-label="{{ __('portfolio.slide', ['current' => $loop->iteration, 'total' => $discoveries->count()]) }}: {{ $item->localized('title') }}">
                        <span aria-hidden="true"></span>
                    </button>
                @endforeach
            </div>
            @endif
        <button class="discovery__playback" type="button" data-discovery-playback hidden
            aria-controls="discovery-track" aria-label="{{ __('portfolio.pause') }}"
            data-pause-label="{{ __('portfolio.pause') }}" data-play-label="{{ __('portfolio.play') }}"
            data-reduced-label="{{ __('portfolio.reduced') }}">
            <svg class="discovery__pause-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true"><path d="M8 5v14M16 5v14"/></svg>
            <svg class="discovery__play-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linejoin="round" aria-hidden="true"><path d="m8 5 11 7-11 7Z"/></svg>
        </button>
        </div>
    </section>
@endif
