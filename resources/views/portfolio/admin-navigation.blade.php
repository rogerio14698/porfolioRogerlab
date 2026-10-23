<nav class="admin-navigation" aria-label="{{ __('profile.admin.content') }}">
    @foreach ([
        ['admin.dashboard', 'profile.admin.dashboard', 'admin.dashboard'],
        ['admin.profile.edit', 'profile.admin.profile', 'admin.profile.*'],
        ['admin.projects.index', 'portfolio.projects', 'admin.projects.*'],
        ['admin.skills.index', 'profile.admin.tools', 'admin.skills.*'],
        ['admin.carousel.edit', 'portfolio.carousel_admin', 'admin.carousel.*'],
        ['admin.blog.index', 'blog.dashboard', 'admin.blog.*'],
    ] as [$destination, $label, $pattern])
        <a href="{{ route($destination, ['lang' => app()->getLocale()]) }}" @if (request()->routeIs($pattern)) aria-current="page" @endif>{{ __($label) }}</a>
    @endforeach
    <a href="{{ route('home', ['lang' => app()->getLocale()]) }}">{{ __('profile.admin.view_site') }}</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">{{ __('blog.sign_out') }}</button>
    </form>
</nav>
