<section class="blog">
    @if (isset($article))
        <article class="blog-detail">
            <div class="blog-header">
                <p class="blog-label">RogerLab / Blog</p>
                <h1>{{ $article->title }}</h1>
            </div>
            <div class="blog-image blog-image-detail">
                @if ($article->image)
                    <img src="{{ asset($article->image) }}" alt="{{ $article->title }}">
                @else
                    <img src="{{ asset('img/LogoPorfolio.jpg') }}" alt="Foto estándar">
                @endif
            </div>
            <div class="blog-content">{!! nl2br(e($article->content)) !!}</div>
            <a class="blog-link blog-back" href="{{ route('blog') }}">Volver al blog</a>
        </article>
    @else
        <header class="blog-header">
            <p class="blog-label">RogerLab / Ideas</p>
            <h1>Blog Profesional</h1>
        </header>
        {{-- 
        En ves de cargar todo con: @include('components.articles.menosCodigoMasSoluciones')
    @include('components.articles.visitasCliente')
    @include('components.articles.precioPaginaWeb')
    @include('components.articles.landingPageVSFullWeb')
    @include('components.articles.contratarUnDesarrolladorWeb')
    Ahora lo va a leer directamente de la base de datos y construilo dinámicamente
     --}}

        @foreach ($articles as $article)
            <article class="blog-card blog-card-with-image">
                <div class="blog-image">
                    @if ($article->image)
                        <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" loading="lazy">
                    @else
                        <img src="{{ asset('img/LogoPorfolio.jpg') }}" alt="Foto estándar" loading="lazy">
                    @endif
                </div>
                <div class="blog-card-content">
                    <h2>
                        @if ($article->link)
                            <a href="{{ route('blog.show', $article) }}">{{ $article->title }}</a>
                        @else
                            {{ $article->title }}
                        @endif
                    </h2>
                    <p>{{ Str::limit(strip_tags($article->content), 180) }}</p>
                    @if ($article->link)
                        <a class="blog-link" href="{{ route('blog.show', $article) }}">Leer artículo <span aria-hidden="true">-&gt;</span></a>
                    @endif
                </div>
            </article>
        @endforeach
    @endif
</section>