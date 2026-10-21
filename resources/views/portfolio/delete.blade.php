<form class="blog-form blog-delete" method="POST" action="{{ $action }}">
    @csrf @method('DELETE')
    <label class="blog-check"><input type="checkbox" name="confirm_delete" value="1" required>{{ __('portfolio.delete_confirm') }}</label>
    <button class="blog-button blog-button--secondary" type="submit">{{ __('portfolio.delete') }}</button>
</form>
