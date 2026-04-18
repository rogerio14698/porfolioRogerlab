@props([
    'id',
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
])

<div class="formLabel">
    <label for="{{ $id }}">{{ $label }}</label>
    <input
        {{ $attributes }}
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
    >
</div>