@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border border-gray focus:border-orange-light focus:ring focus:ring-orange-lightest rounded-md shadow-sm']) !!} />
