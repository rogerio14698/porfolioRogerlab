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

    <div class="contactHoneypot" aria-hidden="true">
        <label for="company">Company</label>
        <input
            id="company"
            name="company"
            type="text"
            value="{{ old('company') }}"
            tabindex="-1"
            autocomplete="off"
        >
    </div>

    <x-contact.field
        id="name"
        name="name"
        label="Name"
        placeholder="Roger"
        :value="old('name')"
        maxlength="120"
        required
    />

    <x-contact.field
        id="subject"
        name="subject"
        label="Subject"
        placeholder="Project inquiry"
        :value="old('subject')"
        maxlength="150"
        required
    />

    <x-contact.field
        id="email"
        name="email"
        type="email"
        label="Email"
        placeholder="example@email.com"
        :value="old('email')"
        inputmode="email"
        autocomplete="email"
        maxlength="255"
        required
    />

    <x-contact.textarea
        id="message"
        name="message"
        label="Message"
        placeholder="Tell me about your project, context, and timeline."
        :value="old('message')"
        maxlength="5000"
        required
    />

    <div class="contactFormMeta">
        <p>
            Before the message reaches the administrator, you must confirm your email address via a verification link.
        </p>
    </div>

    <div
        class="contactTurnstile"
        data-turnstile-widget
        data-sitekey="{{ config('services.turnstile.site_key') }}"
        data-theme="auto"
        data-action="contact"
    ></div>

    <div class="formLabel">
        <button type="submit">Send</button>
    </div>
</form>