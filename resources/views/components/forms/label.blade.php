@props(['value'])

<label {{ $attributes->merge(['class' => 'inline-block text-xs font-medium text-gray-700 md:text-sm']) }}>
    {{ $value ?? $slot }}
</label>
