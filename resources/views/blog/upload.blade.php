<div class="blog-upload" data-upload-row data-upload-index="{{ $index }}">
    <label for="upload-{{ $index }}">{{ __('blog.image') }}</label>
    <input id="upload-{{ $index }}" type="file" name="uploads[{{ $index }}][file]" accept="image/jpeg,image/png,image/webp"
        @error('uploads.'.$index.'.file') aria-invalid="true" aria-describedby="blog-errors" @enderror>
    @foreach (config('blog.locales') as $locale)
        <div class="blog-field">
            <label for="upload-alt-{{ $index }}-{{ $locale }}">{{ __('blog.alt') }} ({{ strtoupper($locale) }})</label>
            <input id="upload-alt-{{ $index }}-{{ $locale }}" name="uploads[{{ $index }}][alt][{{ $locale }}]" maxlength="300"
                value="{{ old('uploads.'.$index.'.alt.'.$locale) }}"
                @error('uploads.'.$index.'.alt.'.$locale) aria-invalid="true" aria-describedby="blog-errors" @enderror>
        </div>
    @endforeach
    <button class="blog-button blog-button--secondary" type="button" data-remove-upload hidden>{{ __('blog.remove_upload') }}</button>
</div>
