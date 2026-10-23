<section class="hero">
    <div @class(['heroMedia', 'heroMedia--without-photo' => ! $siteProfile->photoUrl()])>
        <div class="heroCopy">
            <h1>Rogerio<br>Lucas Viana</h1>
            <p class="heroHeadline">{{ $siteProfile->text('role') }}</p>
            <p class="heroIntro">{{ $siteProfile->text('intro') }}</p>
            <div class="heroeActions">
                <a href="{{ route('projects', ['lang' => app()->getLocale()]) }}" data-partial-nav>{{ __('portfolio.read_work') }}</a>
                <a href="{{ route(app()->getLocale() === 'en' ? 'pdf-cv.english' : 'pdf-cv.spanish') }}" target="_blank" rel="noopener noreferrer">{{ __('portfolio.cv') }}</a>
                <a href="{{ route(app()->getLocale() === 'en' ? 'pdf-cv.spanish' : 'pdf-cv.english') }}" target="_blank" rel="noopener noreferrer" class="heroOtherCv">{{ app()->getLocale() === 'en' ? 'CV Español' : 'CV English' }}</a>
            </div>

            <p class="heroAvailability">{{ $siteProfile->text('availability') }}</p>
        </div>
        @if ($siteProfile->photoUrl())
        <img src="{{ $siteProfile->photoUrl() }}"
            @if (! $siteProfile->photo_path)
                srcset="{{ asset('img/cv-foto-480-v1.webp') }} 480w, {{ asset('img/cv-foto-960-v1.webp') }} 960w"
                sizes="(min-width: 768px) 336px, 93vw"
            @endif
            alt="{{ $siteProfile->text('photo_alt') }}"
            class="heroFoto" width="1170" height="2080" fetchpriority="high">
        @endif
    </div>

    <section class="contributions" aria-labelledby="contributions-title">
        <h2 id="contributions-title">{{ $siteProfile->text('contributions_title') }}</h2>
        <div class="contributions__list">
            @foreach (range(1, 3) as $index)
                <article class="contribution">
                    <h3>{{ $siteProfile->text("offer{$index}_title") }}</h3>
                    <div>
                        <p>{{ $siteProfile->text("offer{$index}_body") }}</p>
                        @if ($proofProjects->has($index))
                            <ul class="contribution__projects" aria-label="{{ __('profile.admin.work') }}">
                                @foreach ($proofProjects->get($index) as $proof)
                                    <li>
                                        <a class="contribution__project" href="{{ route('projects.show', ['project' => $proof->slug, 'lang' => app()->getLocale()]) }}" data-partial-nav>
                                            @if (isset($proof->media[$proof->cover_index ?? 0]))
                                                <img src="{{ $proof->coverUrl() }}" alt="" width="320" height="200" loading="lazy" decoding="async">
                                            @endif
                                            <span>{{ $proof->localized('title') }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
        <a class="contributions__contact" href="{{ route('contact') }}" data-partial-nav>{{ __('profile.admin.contact') }}</a>
    </section>

    @if ($siteProfile->research_enabled)
    <section class="researchNote">
        <h2>{{ $siteProfile->text('research_title') }}</h2>
        <div>
            <p>{{ $siteProfile->text('research_body') }}</p>
            <a href="{{ route($siteProfile->research_route, ['lang' => app()->getLocale()]) }}" data-partial-nav>{{ $siteProfile->text('research_link') }}</a>
        </div>
    </section>
    @endif

    @include('portfolio.discover')

    <section class="profileBiography" aria-labelledby="profile-biography-title">
        <h2 id="profile-biography-title">{{ $siteProfile->text('bio_title') }}</h2>
        <div class="textoAbout">
            <p>{{ $siteProfile->text('bio1') }}</p>
            <p>{{ $siteProfile->text('bio2') }}</p>
        </div>
    </section>
</section>
