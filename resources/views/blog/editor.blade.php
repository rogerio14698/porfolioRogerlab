<section class="blog blog-admin">
    <header class="blog-header">
        <h1>{{ $article->exists ? __('blog.edit') : __('blog.new') }}</h1>
        <p>{{ __('blog.languages_help') }}</p>
    </header>
    @include('blog.toolbar')
    @include('blog.messages')
    <form class="blog-form blog-editor" method="POST" enctype="multipart/form-data"
        action="{{ $article->exists ? route('admin.blog.update', ['blog' => $article, 'lang' => app()->getLocale()]) : route('admin.blog.store', ['lang' => app()->getLocale()]) }}">
        @csrf
        @if ($article->exists) @method('PUT') @endif
        <div class="blog-field">
            <label for="link">{{ __('blog.slug') }}</label>
            <input id="link" name="link" value="{{ old('link', $article->link) }}" required maxlength="160"
                pattern="[a-z0-9]+(-[a-z0-9]+)*" aria-describedby="slug-help" @error('link') aria-invalid="true" @enderror>
            <p id="slug-help">{{ __('blog.slug_help') }}</p>
        </div>
        @foreach (config('blog.locales') as $locale)
            <details class="admin-language-panel" @if ($locale === app()->getLocale() || $errors->has("translations.$locale.*")) open @endif>
            <summary>{{ __('blog.'.$locale) }}</summary>
            <fieldset class="blog-language" lang="{{ $locale }}">
                <legend>{{ __('blog.'.$locale) }}</legend>
                <div class="blog-field">
                    <label for="title-{{ $locale }}">{{ __('blog.title') }} ({{ strtoupper($locale) }})</label>
                    <input id="title-{{ $locale }}" name="translations[{{ $locale }}][title]" maxlength="200"
                        value="{{ old('translations.'.$locale.'.title', $article->translations[$locale]['title'] ?? ($locale === 'es' ? $article->title : '')) }}" @required($locale === 'es')
                        @error('translations.'.$locale.'.title') aria-invalid="true" aria-describedby="blog-errors" @enderror>
                </div>
                <div class="blog-field">
                    <label for="content-{{ $locale }}">{{ __('blog.content') }} ({{ strtoupper($locale) }})</label>
                    <textarea id="content-{{ $locale }}" name="translations[{{ $locale }}][content]" rows="12" maxlength="100000"
                        @error('translations.'.$locale.'.content') aria-invalid="true" aria-describedby="blog-errors" @enderror>{{ old('translations.'.$locale.'.content', $article->translations[$locale]['content'] ?? ($locale === 'es' ? $article->content : '')) }}</textarea>
                    <p>{{ __('blog.plain_text') }}</p>
                </div>
                <details class="blog-seo" @if ($errors->has('translations.'.$locale.'.seo_*')) open @endif>
                    <summary>SEO ({{ strtoupper($locale) }})</summary>
                    <p>{{ __('blog.seo_help') }}</p>
                    @foreach (['seo_title' => 70, 'seo_description' => 160, 'seo_keywords' => 255] as $field => $length)
                        <div class="blog-field">
                            <label for="{{ $field }}-{{ $locale }}">{{ __('blog.'.$field) }}</label>
                            <input id="{{ $field }}-{{ $locale }}" name="translations[{{ $locale }}][{{ $field }}]"
                                maxlength="{{ $length }}" value="{{ old('translations.'.$locale.'.'.$field, $article->translations[$locale][$field] ?? ($locale === 'es' ? $article->$field : '')) }}"
                                @error('translations.'.$locale.'.'.$field) aria-invalid="true" aria-describedby="blog-errors" @enderror>
                        </div>
                    @endforeach
                </details>
            </fieldset>
            </details>
        @endforeach
        <fieldset class="blog-language">
            <legend>{{ __('blog.images') }}</legend>
            <p>{{ __('blog.images_help') }}</p>
            <p>{{ __('blog.alt_help') }}</p>
            @foreach ($article->images as $image)
                <div class="blog-upload">
                    <img src="{{ route('blog.image', $image) }}" alt="{{ $image->localizedAlt() }}" loading="lazy">
                    @foreach (config('blog.locales') as $locale)
                        <div class="blog-field">
                            <label for="alt-{{ $image->id }}-{{ $locale }}">{{ __('blog.alt') }} ({{ strtoupper($locale) }})</label>
                            <input id="alt-{{ $image->id }}-{{ $locale }}" name="existing_images[{{ $image->id }}][alt][{{ $locale }}]"
                                maxlength="300" value="{{ old('existing_images.'.$image->id.'.alt.'.$locale, $image->alt[$locale] ?? '') }}"
                                @error('existing_images.'.$image->id.'.alt.'.$locale) aria-invalid="true" aria-describedby="blog-errors" @enderror>
                        </div>
                    @endforeach
                    <label class="blog-check"><input type="checkbox" name="remove_images[]" value="{{ $image->id }}"
                        @checked(in_array($image->id, old('remove_images', [])))>{{ __('blog.remove_image') }}</label>
                </div>
            @endforeach
            @php($uploadRows = old('uploads', [0 => []]))
            <div data-blog-uploads>
                @foreach ($uploadRows as $index => $upload)
                    @include('blog.upload', ['index' => $index])
                @endforeach
            </div>
            <button type="button" class="blog-button blog-button--secondary" data-add-upload hidden>{{ __('blog.add_image') }}</button>
            <noscript>
                @for ($index = 0; $index < config('blog.max_images'); $index++)
                    @if (!array_key_exists($index, $uploadRows))
                        @include('blog.upload', ['index' => $index])
                    @endif
                @endfor
            </noscript>
            <template id="blog-upload-template">
                @include('blog.upload', ['index' => '__INDEX__'])
            </template>
        </fieldset>
        <div class="blog-save">
            <label for="status">{{ __('blog.status') }}</label>
            <select id="status" name="status">
                <option value="draft" @selected(old('status', $article->is_published ? 'published' : 'draft') === 'draft')>{{ __('blog.draft') }}</option>
                <option value="published" @selected(old('status', $article->is_published ? 'published' : 'draft') === 'published')>{{ __('blog.published') }}</option>
            </select>
            <p>{{ __('blog.unpublish_help') }}</p>
            <button class="blog-button" type="submit">{{ __('blog.save') }}</button>
            @if ($article->exists)
                <a class="blog-link" href="{{ route('admin.blog.preview', ['blog' => $article, 'lang' => app()->getLocale()]) }}">{{ __('blog.preview') }}</a>
            @endif
        </div>
    </form>
    @if ($article->exists)
        <form class="blog-form blog-delete" method="POST" action="{{ route('admin.blog.destroy', ['blog' => $article, 'lang' => app()->getLocale()]) }}">
            @csrf @method('DELETE')
            <label class="blog-check"><input type="checkbox" name="confirm_delete" value="1" required>{{ __('blog.delete_confirm') }}</label>
            <button class="blog-button blog-button--secondary" type="submit">{{ __('blog.delete') }}</button>
        </form>
    @endif
</section>
