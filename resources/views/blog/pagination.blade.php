@if ($paginator->hasPages())
    <nav class="blog-pagination" aria-label="{{ __('blog.heading') }}">
        @if ($paginator->previousPageUrl())
            <a class="blog-button blog-button--secondary" href="{{ $paginator->previousPageUrl() }}">{{ __('blog.previous') }}</a>
        @endif
        <span>{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
        @if ($paginator->nextPageUrl())
            <a class="blog-button blog-button--secondary" href="{{ $paginator->nextPageUrl() }}">{{ __('blog.next') }}</a>
        @endif
    </nav>
@endif
