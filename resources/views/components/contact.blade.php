<section class="seccionContact">
    <h2 data-i18n="contact.title">Contacto</h2>
    <form method="POST" action="{{ route('contact.submit') }}" class="contactForm" novalidate>
        @csrf

        @if (session('contact_message'))
            <div class="contactAlert contactAlert--{{ session('contact_status', 'info') }}" role="status">
                {{ session('contact_message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="contactAlert contactAlert--error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        {{--         <div class="" aria-hidden="true">
            <label for="company" data-i18n="contact.form.company">Empresa</label>
            <input id="company" name="company" type="text" value="{{ old('company') }}" tabindex="-1"
                autocomplete="off">
        </div> 
        --}}

        <div class="contactFormGrid">
            <x-contact.field id="name" name="name" label="Nombre" labelKey="contact.form.name" placeholder="Roger"
                :value="old('name')" maxlength="120" required />

            <x-contact.field id="subject" name="subject" label="Asunto" labelKey="contact.form.subject"
                placeholder="Quiero hablar contigo sobre una vacante"
                placeholderKey="contact.form.subject_placeholder" :value="old('subject')" maxlength="150" required />

            <x-contact.field id="email" name="email" type="email" label="Correo electronico"
                labelKey="contact.form.email" placeholder="example@email.com"
                placeholderKey="contact.form.email_placeholder" :value="old('email')" inputmode="email"
                autocomplete="email" maxlength="255" required />

            <x-contact.textarea id="message" name="message" label="Mensaje" labelKey="contact.form.message"
                placeholder="Cuéntame el puesto, el equipo, el stack o el motivo del contacto y te respondo lo antes posible."
                placeholderKey="contact.form.message_placeholder" :value="old('message')" maxlength="5000" required />
        </div>

        <div class="contactFormMeta">
            <p data-i18n="contact.form.notice">Antes de que el mensaje llegue al administrador, debes confirmar tu
                direccion de correo mediante un enlace de verificacion.</p>
        </div>

        <div class="contactTurnstile" data-turnstile-widget data-sitekey="{{ config('services.turnstile.site_key') }}"
            data-theme="auto" data-action="contact"></div>

        <div class="contactSubmitRow">
            <button type="submit" data-i18n="contact.form.submit">Enviar mensaje</button>
        </div>
    </form>
</section>
