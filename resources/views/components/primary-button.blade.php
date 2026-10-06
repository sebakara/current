<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-slate-800 dark:bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 dark:hover:bg-gray-700 focus:bg-slate-700 dark:focus:bg-gray-700 active:bg-slate-900 dark:active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
