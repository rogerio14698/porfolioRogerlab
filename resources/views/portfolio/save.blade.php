<div class="blog-save">
    <label for="status">{{ __('blog.status') }}</label>
    <select id="status" name="status">
        <option value="draft" @selected(old('status', $record->is_published ? 'published' : 'draft') === 'draft')>{{ __('blog.draft') }}</option>
        <option value="published" @selected(old('status', $record->is_published ? 'published' : 'draft') === 'published')>{{ __('blog.published') }}</option>
    </select>
    @error('status')<p>{{ $message }}</p>@enderror
    <button class="blog-button" type="submit">{{ __('blog.save') }}</button>
</div>
