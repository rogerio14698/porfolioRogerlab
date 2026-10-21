<section class="blog blog-admin">
    <h1>{{ $skill->exists ? __('portfolio.edit_skill') : __('portfolio.new_skill') }}</h1>
    @include('blog.toolbar')
    @include('blog.messages')
    <p>{{ __('portfolio.publication_help') }}</p>
    <form class="blog-form blog-editor" method="POST" action="{{ $skill->exists ? route('admin.skills.update', ['skill' => $skill, 'lang' => app()->getLocale()]) : route('admin.skills.store', ['lang' => app()->getLocale()]) }}">
        @csrf
        @if ($skill->exists) @method('PUT') @endif
        @foreach (config('blog.locales') as $locale)
            <fieldset class="blog-language" lang="{{ $locale }}">
                <legend>{{ __('blog.'.$locale) }}</legend>
                @include('portfolio.field', ['name' => "translations.$locale.label", 'label' => __('portfolio.label'), 'value' => $skill->translations[$locale]['label'] ?? '', 'length' => 100, 'required' => $locale === 'es'])
            </fieldset>
        @endforeach
        @include('portfolio.field', ['name' => 'position', 'label' => __('portfolio.position'), 'value' => $skill->position, 'type' => 'number', 'length' => 5, 'required' => true])
        @include('portfolio.save', ['record' => $skill])
    </form>
    @if ($skill->exists)
        @include('portfolio.delete', ['action' => route('admin.skills.destroy', ['skill' => $skill, 'lang' => app()->getLocale()])])
    @endif
</section>
