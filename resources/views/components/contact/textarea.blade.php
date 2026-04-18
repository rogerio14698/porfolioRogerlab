@props([
    'id',
    'name',
    'label',
    'value' => '',
    'placeholder' => '',
])

<div class="formLabel textarea">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea
        {{ $attributes }}
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
    >{{ $value }}</textarea>
</div>