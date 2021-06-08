@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-dark']) }}>
    {{ $value ?? $slot }}
</label>
