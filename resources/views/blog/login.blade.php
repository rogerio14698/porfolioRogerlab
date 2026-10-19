<section class="blog blog-access">
    <header class="blog-header">
        <h1>{{ __('blog.login') }}</h1>
        <p>{{ __('blog.login_intro') }}</p>
    </header>
    @include('blog.messages')
    <form class="blog-form" method="POST" action="{{ route('login.store', ['lang' => app()->getLocale()]) }}">
        @csrf
        <label for="email">{{ __('blog.email') }}</label>
        <input id="email" name="email" type="email" value="{{ old('email', config('blog.owner_email')) }}"
            autocomplete="username" required maxlength="254" @error('email') aria-invalid="true" @enderror>
        <label for="password">{{ __('blog.password') }}</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required maxlength="72">
        <button class="blog-button" type="submit">{{ __('blog.sign_in') }}</button>
    </form>
    <a class="blog-link" href="{{ route('blog', ['lang' => app()->getLocale()]) }}">{{ __('blog.back') }}</a>
</section>
