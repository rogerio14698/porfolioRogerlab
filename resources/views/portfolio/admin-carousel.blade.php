@php
    $old = fn (string $key, $value) => old($key, $value);
    $mode = $old('mode', $settings->mode);
@endphp
<section class="blog blog-admin carousel-admin">
    <header class="blog-header">
        <h1>{{ __('portfolio.carousel_admin') }}</h1>
        <p>{{ __('portfolio.carousel_intro') }}</p>
    </header>
    @include('blog.toolbar')
    @include('blog.messages')
    <p class="blog-notice" role="status">
        {{ __('portfolio.carousel_live', ['count' => $visibleCount]) }}
        <a class="blog-link" href="{{ route('home', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.carousel_view_home') }}</a>
    </p>
    <form class="blog-form blog-editor" method="POST" action="{{ route('admin.carousel.update', ['lang' => app()->getLocale()]) }}"
        data-carousel-admin data-mode="{{ $mode }}">
        @csrf
        @method('PUT')
        <fieldset class="blog-language">
            <legend>{{ __('portfolio.carousel_behaviour') }}</legend>
            <div class="carousel-admin__modes" role="radiogroup" aria-labelledby="carousel-mode-label">
                <p id="carousel-mode-label"><strong>{{ __('portfolio.carousel_mode') }}</strong></p>
                @foreach (['automatic', 'manual'] as $option)
                    <label class="blog-check carousel-admin__mode">
                        <input type="radio" name="mode" value="{{ $option }}" @checked($mode === $option) data-carousel-mode>
                        <span><strong>{{ __('portfolio.carousel_mode_'.$option) }}</strong><br>{{ __('portfolio.carousel_mode_'.$option.'_help') }}</span>
                    </label>
                @endforeach
            </div>
            <div class="carousel-admin__grid">
                <div class="blog-field">
                    <label for="interval_seconds">{{ __('portfolio.carousel_interval') }}</label>
                    <input id="interval_seconds" type="number" name="interval_seconds" min="2" max="60" step="1" required
                        value="{{ $old('interval_seconds', $settings->interval_seconds) }}" aria-describedby="interval_seconds-help"
                        @error('interval_seconds') aria-invalid="true" @enderror>
                    <p id="interval_seconds-help">{{ __('portfolio.carousel_interval_help') }}</p>
                </div>
                <div class="blog-field">
                    <label for="max_slides">{{ __('portfolio.carousel_max') }}</label>
                    <input id="max_slides" type="number" name="max_slides" min="0" max="500" step="1" required
                        value="{{ $old('max_slides', $settings->max_slides) }}" aria-describedby="max_slides-help"
                        @error('max_slides') aria-invalid="true" @enderror>
                    <p id="max_slides-help">{{ __('portfolio.carousel_max_help') }}</p>
                </div>
            </div>
            @foreach (['autoplay', 'pause_on_hover', 'show_indicators'] as $flag)
                <input type="hidden" name="{{ $flag }}" value="0">
                <label class="blog-check">
                    <input type="checkbox" name="{{ $flag }}" value="1" @checked((bool) $old($flag, $settings->$flag))>
                    <span>{{ __('portfolio.carousel_'.$flag) }}</span>
                </label>
            @endforeach
        </fieldset>

        <fieldset class="blog-language carousel-admin__slides">
            <legend>{{ __('portfolio.carousel_slides') }}</legend>
            <p class="carousel-admin__automatic-note">{{ __('portfolio.carousel_automatic_note') }}</p>
            <p>{{ __('portfolio.carousel_slides_help') }}</p>
            @if ($candidates->isEmpty())
                <p>{{ __('portfolio.carousel_empty') }}</p>
            @else
                <div class="carousel-admin__bulk" data-carousel-bulk hidden>
                    <button class="blog-button blog-button--secondary" type="button" data-carousel-all="1">{{ __('portfolio.carousel_show_all') }}</button>
                    <button class="blog-button blog-button--secondary" type="button" data-carousel-all="0">{{ __('portfolio.carousel_hide_all') }}</button>
                </div>
                <ol class="carousel-admin__list" data-carousel-list>
                    @foreach ($candidates as $candidate)
                        @php
                            $title = $candidate->item->localized('title');
                            $editUrl = $candidate->type === 'project'
                                ? route('admin.projects.edit', ['project' => $candidate->item, 'lang' => app()->getLocale()])
                                : route('admin.blog.edit', ['blog' => $candidate->item, 'lang' => app()->getLocale()]);
                        @endphp
                        <li class="carousel-admin__item" data-carousel-item data-status="{{ $candidate->status }}">
                            <input type="hidden" name="slides[{{ $loop->index }}][type]" value="{{ $candidate->type }}">
                            <input type="hidden" name="slides[{{ $loop->index }}][id]" value="{{ $candidate->id }}">
                            <span class="carousel-admin__handle" aria-hidden="true" data-carousel-handle hidden>⠿</span>
                            <img class="carousel-admin__thumb" src="{{ $candidate->item->coverUrl() }}" alt="" width="96" height="60" loading="lazy" decoding="async">
                            <div class="carousel-admin__info">
                                <h2>{{ $title }}</h2>
                                <p>
                                    {{ $candidate->type === 'project' ? __('portfolio.project_type') : __('portfolio.blog_type') }}
                                    · {{ __('portfolio.carousel_status_'.$candidate->status) }}
                                    · <a class="carousel-admin__edit" href="{{ $editUrl }}">{{ __('blog.edit') }}</a>
                                </p>
                            </div>
                            <input type="hidden" name="slides[{{ $loop->index }}][visible]" value="0">
                            <label class="blog-check carousel-admin__visible">
                                <input type="checkbox" name="slides[{{ $loop->index }}][visible]" value="1" @checked($candidate->visible)>
                                <span>{{ __('portfolio.carousel_visible') }}</span>
                            </label>
                            <div class="carousel-admin__order">
                                <label for="slide-position-{{ $loop->index }}">{{ __('portfolio.carousel_position') }}</label>
                                <input id="slide-position-{{ $loop->index }}" type="number" name="slides[{{ $loop->index }}][position]"
                                    min="0" max="10000" value="{{ $loop->iteration }}" required data-carousel-position>
                                <button class="blog-button blog-button--secondary" type="button" data-carousel-move="-1" hidden
                                    aria-label="{{ __('portfolio.carousel_up', ['title' => $title]) }}" title="{{ __('portfolio.carousel_up', ['title' => $title]) }}">↑</button>
                                <button class="blog-button blog-button--secondary" type="button" data-carousel-move="1" hidden
                                    aria-label="{{ __('portfolio.carousel_down', ['title' => $title]) }}" title="{{ __('portfolio.carousel_down', ['title' => $title]) }}">↓</button>
                            </div>
                        </li>
                    @endforeach
                </ol>
                <p class="carousel-admin__announce" aria-live="polite" data-carousel-announce></p>
            @endif
        </fieldset>
        <div class="blog-save">
            <button class="blog-button" type="submit">{{ __('blog.save') }}</button>
        </div>
    </form>
</section>
