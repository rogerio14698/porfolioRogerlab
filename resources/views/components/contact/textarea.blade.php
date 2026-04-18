@props([
    'id',
    'name',
    'label',
    'labelKey' => null,
    'value' => '',
    'placeholder' => '',
    'placeholderKey' => null,
])

<div class="formLabel textarea">
    <label for="{{ $id }}" @if($labelKey) data-i18n="{{ $labelKey }}" @endif>{{ $label }}</label>
    <textarea
        {{ $attributes }}
        id="{{ $id }}"
        name="{{ $name }}"
        @if($placeholderKey) data-i18n-placeholder="{{ $placeholderKey }}" @endif
        placeholder="{{ $placeholder }}"
    >{{ $value }}</textarea>
</div>