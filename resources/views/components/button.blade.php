@props(['type' => 'submit'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-primary w-100']) }}>
    {{ $slot }}
</button>
