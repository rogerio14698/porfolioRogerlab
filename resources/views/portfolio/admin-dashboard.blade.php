<section class="blog blog-admin">
    <header class="blog-header">
        <h1>{{ __('profile.admin.dashboard') }}</h1>
        <p>{{ __('profile.admin.intro') }}</p>
    </header>
    @include('blog.messages')
    <div class="admin-destinations">
        @foreach ([
            ['admin.profile.edit', 'profile.admin.profile', 'profile.admin.profile_help'],
            ['admin.projects.index', 'portfolio.projects', 'profile.admin.projects_help'],
            ['admin.skills.index', 'profile.admin.tools', 'profile.admin.skills_help'],
            ['admin.carousel.edit', 'portfolio.carousel_admin', 'profile.admin.carousel_help'],
            ['admin.blog.index', 'blog.dashboard', 'profile.admin.blog_help'],
        ] as [$destination, $label, $help])
            <a class="admin-destination" href="{{ route($destination, ['lang' => app()->getLocale()]) }}">
                <h2>{{ __($label) }}</h2>
                <p>{{ __($help) }}</p>
            </a>
        @endforeach
    </div>
</section>
