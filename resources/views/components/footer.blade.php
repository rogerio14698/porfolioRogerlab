<footer class="contenedorFooter">
    <p data-i18n="footer.rights" data-i18n-year="{{ date('Y') }}">&copy; {{ date('Y') }} Roger Lab. Todos los derechos reservados.</p>

    <div class="info">
        <p>rogerlucas14698@gmail.com</p>
        <a href="https://wa.me/34629948107?text=Hola%20Roger,%20quiero%20contactarte%20sobre%20tu%20portafolio">+34 629 948 107</a>
        <div class="social-icons">
            <a href="https://www.linkedin.com/in/rogerio-lucas-viana-51a149258/"><i class="fa-brands fa-linkedin"></i></a>
            <a href="https://github.com/rogerio14698"><i class="fa-brands fa-github"></i></a>
        </div>
    </div>

    <div class="privacy">
        <a href="{{ route('privacy-policy') }}" data-partial-nav data-i18n="footer.privacy">Politica de privacidad</a>
        <a href="{{ route('terms-of-service') }}" data-partial-nav data-i18n="footer.terms">Terminos del servicio</a>
        <a href="{{ route('cookies-privacy') }}" data-partial-nav data-i18n="footer.cookies">Politica de cookies</a>
    </div>

</footer>