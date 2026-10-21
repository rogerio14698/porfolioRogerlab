<div class="blog-toolbar">
    <a class="blog-button blog-button--secondary" href="{{ route('admin.blog.index', ['lang' => app()->getLocale()]) }}">{{ __('blog.dashboard') }}</a>
    <a class="blog-button blog-button--secondary" href="{{ route('admin.projects.index', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.projects') }}</a>
    <a class="blog-button blog-button--secondary" href="{{ route('admin.skills.index', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.skills') }}</a>
    <a class="blog-button blog-button--secondary" href="{{ route('admin.carousel.edit', ['lang' => app()->getLocale()]) }}">{{ __('portfolio.carousel_admin') }}</a>
    <a class="blog-link" href="{{ route('blog', ['lang' => app()->getLocale()]) }}">{{ __('blog.back') }}</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="blog-button blog-button--secondary" type="submit">{{ __('blog.sign_out') }}</button>
    </form>
</div>
