@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'w-full mt-1 text-sm border border-gray-300 focus:border-gray-400 focus:ring-1 focus:ring-gray-200 rounded-md shadow-sm']) !!} />
