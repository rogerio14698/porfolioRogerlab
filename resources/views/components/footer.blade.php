<footer class="contenedorFooter">
    <p data-i18n="footer.rights" data-i18n-year="{{ date('Y') }}">&copy; {{ date('Y') }} Roger Lab. Todos los derechos reservados.</p>

    <div class="info">
        <p>rogerlucas14698@gmail.com</p>
        <p>+34 629 948 107</p>
    </div>

    <div class="privacy">
        <a href="{{ route('privacy-policy') }}" data-partial-nav data-i18n="footer.privacy">Politica de privacidad</a>
        <a href="{{ route('terms-of-service') }}" data-partial-nav data-i18n="footer.terms">Terminos del servicio</a>
        <a href="{{ route('cookies-privacy') }}" data-partial-nav data-i18n="footer.cookies">Politica de cookies</a>
    </div>

</footer>