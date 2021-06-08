<button
    {{ $attributes->merge(['type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-gray-darker border border-transparent rounded-md font-semibold text-xs
    text-white uppercase tracking-wide hover:bg-orange active:bg-gray-900 focus:outline-none focus:border-gray-dark focus:ring
    focus:ring-gray-light disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
