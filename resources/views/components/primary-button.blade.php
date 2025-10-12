<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700
             border border-transparent rounded-md font-semibold text-sm text-white
             uppercase tracking-wide shadow-sm active:bg-gray-900 focus:outline-none
             focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150'
    ]) }}
>
    {{ $slot }}
</button>
