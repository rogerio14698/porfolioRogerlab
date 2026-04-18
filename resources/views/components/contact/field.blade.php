@props([
    'id',
    'name',
    'label',
    'labelKey' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'placeholderKey' => null,
])

<div class="formLabel">
    <label for="{{ $id }}" @if($labelKey) data-i18n="{{ $labelKey }}" @endif>{{ $label }}</label>
    <input
        {{ $attributes }}
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        @if($placeholderKey) data-i18n-placeholder="{{ $placeholderKey }}" @endif
        placeholder="{{ $placeholder }}"
    >
</div>