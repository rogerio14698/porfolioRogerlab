@php
    $parts = explode('.', $name);
    $inputName = array_shift($parts).implode('', array_map(fn ($part) => '['.$part.']', $parts));
    $fieldId = str_replace('.', '-', $name);
@endphp
<div class="blog-field">
    <label for="{{ $fieldId }}">{{ $label }}</label>
    @if ($multiline ?? false)
        <textarea id="{{ $fieldId }}" name="{{ $inputName }}" rows="{{ $rows ?? 5 }}" maxlength="{{ $length }}"
            @required($required ?? false) @error($name) aria-invalid="true" aria-describedby="{{ $fieldId }}-error" @enderror>{{ old($name, $value) }}</textarea>
    @else
        <input id="{{ $fieldId }}" type="{{ $type ?? 'text' }}" name="{{ $inputName }}"
            value="{{ old($name, $value) }}" maxlength="{{ $length }}" @required($required ?? false)
            @if (($type ?? '') === 'number') min="0" max="10000" @endif
            @error($name) aria-invalid="true" aria-describedby="{{ $fieldId }}-error" @enderror>
    @endif
    @error($name)<p id="{{ $fieldId }}-error">{{ $message }}</p>@enderror
</div>
