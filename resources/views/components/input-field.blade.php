@props(['type' => 'text', 'name', 'placeholder' => '', 'value' => ''])

<div class="mb-3">
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" class="form-control @error($name) is-invalid @enderror">
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
