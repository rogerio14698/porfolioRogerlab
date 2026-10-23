<section class="seccionAboutMe">
    <h1 class="pageTitle" data-i18n="nav.about">{{ __('profile.admin.about_seo') }}</h1>
    <div @class(['aboutNarrative', 'aboutNarrative--single' => ! $siteProfile->research_enabled])>
    <div>
    <h2>{{ __('profile.method_title') }}</h2>
    <p>{{ __('profile.method1') }}</p>
    <p>{{ __('profile.method2') }}</p>
    </div>
    @if ($siteProfile->research_enabled)
        <div>
            <h2>{{ $siteProfile->text('research_title') }}</h2>
            <p>{{ $siteProfile->text('research_body') }}</p>
        </div>
    @endif
    </div>
    @if ($skills->isNotEmpty())
        <section class="profileTools">
            <h2>{{ __('profile.admin.tools') }}</h2>
            <ul>
                @foreach ($skills as $skill)
                    <li>{{ $skill->label() }}</li>
                @endforeach
            </ul>
        </section>
    @endif
</section>