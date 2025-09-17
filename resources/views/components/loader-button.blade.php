@props([
    'action', // wire:click method name
    'label' => 'Submit', // Default label
    'class' => 'btn btn-primary', // Optional extra classes
])

<button
    {{ $attributes->merge([
        'class' => "$class d-flex justify-content-center align-items-center",
        'wire:click' => $action,
        'wire:loading.attr' => 'disabled',
        'wire:target' => $action,
    ]) }}>
    <span wire:loading wire:target="{{ $action }}" class="spinner-border spinner-border-sm me-2" role="status"
        aria-hidden="true"></span>

    <span wire:loading.remove wire:target="{{ $action }}">
        {{ $label }}
    </span>
</button>
