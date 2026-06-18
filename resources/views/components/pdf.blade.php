<div class="contactPdfRow">
    <h3 class="contactPdfTitle" data-i18n="pdf.title">Currículum</h3>
    <div class="contactPdfLinks">
        <a href="{{ route('pdf-cv.english') }}" target="_blank" rel="noopener noreferrer" class="contactPdfLink" data-i18n="hero.cta.cv_en">CV English</a>
        <a href="{{ route('pdf-cv.spanish') }}" target="_blank" rel="noopener noreferrer"
            class="contactPdfLink" data-i18n="hero.cta.cv_es">CV Español</a>

        {{-- De momento no incluir el enlace al repositorio pero si hacerlo despues. --}}
        @if (route('home') != route('home'))
            @include('components.btnEnlaceRepositorio')
        @endif
    </div>
</div>
