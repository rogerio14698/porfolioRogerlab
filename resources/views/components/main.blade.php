<main class="contenedor contenidoMain">
    @include('components.nav')
    @include('components.aside')
    @if ($section === 'home')
        @include('components.textoAbout')
    @elseif ($section === 'about')
        @include('components.about')
    @elseif ($section === 'projects')
        @include('components.projects')
    @elseif ($section === 'contact')
        @include('components.contact')
    @else
        <p>Section not found.</p>
    @endif
</main>