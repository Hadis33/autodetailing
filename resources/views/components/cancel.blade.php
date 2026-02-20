<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => '
            inline-flex items-center px-4 py-2
            border border-gray-300 rounded-md
            font-semibold text-xs text-gray-700 uppercase tracking-widest
            bg-transparent
            hover:bg-gray-100 focus:bg-gray-100
            active:bg-gray-200
            focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2
            disabled:opacity-50
            transition ease-in-out duration-150
        ',
    ]) }}>
    {{ $slot }}
</button>
