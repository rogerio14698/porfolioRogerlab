<section class="blog blog-admin">
    <h1>{{ $project->exists ? __('portfolio.edit_project') : __('portfolio.new_project') }}</h1>
    @include('blog.toolbar')
    @include('blog.messages')
    <p>{{ __('portfolio.publication_help') }}</p>
    <form class="blog-form blog-editor" method="POST" enctype="multipart/form-data" action="{{ $project->exists ? route('admin.projects.update', ['project' => $project, 'lang' => app()->getLocale()]) : route('admin.projects.store', ['lang' => app()->getLocale()]) }}">
        @csrf
        @if ($project->exists) @method('PUT') @endif
        @include('portfolio.field', ['name' => 'slug', 'label' => __('portfolio.slug'), 'value' => $project->slug, 'length' => 160, 'required' => true])
        <p>{{ __('blog.slug_help') }}</p>
        @foreach (config('blog.locales') as $locale)
            <details class="admin-language-panel" @if ($locale === app()->getLocale() || $errors->has("translations.$locale.*")) open @endif>
            <summary>{{ __('blog.'.$locale) }}</summary>
            <fieldset class="blog-language" lang="{{ $locale }}">
                <legend>{{ __('blog.'.$locale) }}</legend>
                @foreach (['title' => 200, 'summary' => 600, 'content' => 100000, 'image_alt' => 300, 'category' => 100, 'period' => 100] as $field => $length)
                    @include('portfolio.field', ['name' => "translations.$locale.$field", 'label' => __('portfolio.'.$field), 'value' => $project->translations[$locale][$field] ?? '', 'length' => $length, 'multiline' => in_array($field, ['summary', 'content']), 'required' => $locale === 'es' && $field === 'title'])
                @endforeach
                <p>{{ __('blog.plain_text') }}</p>
                <details class="blog-seo" @if ($errors->has("translations.$locale.seo_*")) open @endif>
                    <summary>SEO ({{ strtoupper($locale) }})</summary>
                    <p>{{ __('blog.seo_help') }}</p>
                    @foreach (['seo_title' => 70, 'seo_description' => 160] as $field => $length)
                        @include('portfolio.field', ['name' => "translations.$locale.$field", 'label' => __('portfolio.'.$field), 'value' => $project->translations[$locale][$field] ?? '', 'length' => $length])
                    @endforeach
                </details>
            </fieldset>
            </details>
        @endforeach
        @include('portfolio.field', ['name' => 'technologies', 'label' => __('portfolio.technologies'), 'value' => $project->technologies, 'length' => 2000, 'multiline' => true])
        @foreach (['repository_url', 'website_url'] as $field)
            @include('portfolio.field', ['name' => $field, 'label' => __('portfolio.'.$field), 'value' => $project->$field, 'type' => 'url', 'length' => 2048])
        @endforeach
        @include('portfolio.field', ['name' => 'position', 'label' => __('portfolio.position'), 'value' => $project->position, 'type' => 'number', 'length' => 5, 'required' => true])
        <input type="hidden" name="is_featured" value="0">
        <label class="blog-check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured))>{{ __('portfolio.featured') }}</label>
        <fieldset class="blog-language">
            <legend>{{ __('blog.images') }}</legend>
            <p>{{ __('portfolio.images_help') }}</p>
            <p>{{ __('portfolio.alt_help') }}</p>
            @foreach ($project->media ?? [] as $index => $image)
                <div class="blog-upload">
                    <img src="{{ $project->mediaUrl($index) }}" alt="{{ $project->imageAlt($index) }}" loading="lazy">
                    <label class="blog-check"><input type="radio" name="cover_index" value="{{ $index }}" @checked((string) old('cover_index', $project->cover_index ?? 0) === (string) $index)>{{ __('portfolio.cover') }}</label>
                    @foreach (config('blog.locales') as $locale)
                        @include('portfolio.field', ['name' => "media_alt.$index.$locale", 'label' => __('blog.alt').' ('.strtoupper($locale).')', 'value' => $image['alt'][$locale] ?? '', 'length' => 300])
                    @endforeach
                    <label class="blog-check"><input type="checkbox" name="remove_media[]" value="{{ $index }}" @checked(in_array($index, old('remove_media', [])))>{{ __('blog.remove_image') }}</label>
                </div>
            @endforeach
            <div class="blog-field">
                <label for="uploads">{{ __('portfolio.uploads') }}</label>
                <input id="uploads" type="file" name="uploads[]" multiple accept="image/jpeg,image/png,image/webp" @error('uploads') aria-invalid="true" @enderror>
                @error('uploads')<p>{{ $message }}</p>@enderror
            </div>
            <label class="blog-check"><input type="radio" name="cover_index" value="new" @checked(old('cover_index') === 'new')>{{ __('portfolio.new_cover') }}</label>
            @error('cover_index')<p>{{ $message }}</p>@enderror
        </fieldset>
        @include('portfolio.save', ['record' => $project])
        @if ($project->exists)
            <a class="blog-link" href="{{ route('admin.projects.preview', ['project' => $project, 'lang' => app()->getLocale()]) }}">{{ __('blog.preview') }}</a>
        @endif
    </form>
    @if ($project->exists)
        @include('portfolio.delete', ['action' => route('admin.projects.destroy', ['project' => $project, 'lang' => app()->getLocale()])])
    @endif
</section>
