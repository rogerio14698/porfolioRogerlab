@if (session('status'))
    <p class="blog-notice" role="status">{{ session('status') }}</p>
@endif
@if (session('warning'))
    <p class="blog-notice" role="alert">{{ session('warning') }}</p>
@endif
@if ($errors->any())
    <div class="blog-notice" role="alert" tabindex="-1" id="blog-errors">
        <p><strong>{{ __('blog.errors') }}</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <p>{{ __('blog.upload_again') }}</p>
    </div>
@endif
