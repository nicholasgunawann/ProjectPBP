<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' =>
            'inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300
             border border-transparent rounded-md font-medium text-sm text-gray-800
             uppercase tracking-wide shadow-sm focus:outline-none focus:ring-2
             focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150'
    ]) }}
>
    {{ $slot }}
</button>
