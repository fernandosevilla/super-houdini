<button {{ $attributes->merge(['type' => 'button', 'class' => 'whitespace-nowrap rounded-md bg-neutral-800 border border-neutral-800 px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-800 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-neutral-300 dark:border-neutral-300 dark:text-black dark:focus-visible:outline-neutral-300']) }}>
    {{ $slot }}
</button>
