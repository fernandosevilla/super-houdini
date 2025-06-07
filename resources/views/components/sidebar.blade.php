@php
    $menu = config('menu');
    $currentRoute = request()->routeIs(...);
@endphp

<nav
    x-cloak
    class="fixed left-0 z-20 flex h-screen w-60 shrink-0 flex-col bg-neutral-50 p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative dark:bg-neutral-900"
    x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-60'"
    aria-label="sidebar navigation"
>
    <!-- Logo -->
    <div class="flex justify-center">
        <a href="{{ url('/') }}" class="w-fit text-2xl font-bold text-neutral-900 dark:text-white mb-4">
            Super Houdini
        </a>
    </div>

    <hr>

    <!-- Links del menú -->
    <div class="flex flex-col gap-2 overflow-y-auto pb-6 mt-4">
        @foreach ($menu as $item)
            @if (empty($item['can'] ?? null) || auth()->user()->canAny($item['can']))
                @if (!empty($item['type']) && $item['type'] === 'header')
                    <div class="px-2 pt-4 text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                        {{ $item['text'] }}
                    </div>
                @else
                    @php
                        $isActive = request()->routeIs($item['route']);
                        $base = 'flex items-center gap-2 px-2 py-1.5 text-sm font-medium rounded-md focus-visible:underline focus:outline-hidden';
                        $active = $isActive
                            ? 'bg-black/10 text-neutral-900 dark:bg-white/10 dark:text-white'
                            : 'text-neutral-600 hover:bg-black/5 hover:text-neutral-900 dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white';
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       class="{{ $base }} {{ $active }}"
                       aria-current="{{ $isActive ? 'page' : false }}">
                        <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                        <span>{{ $item['text'] }}</span>
                        @if ($isActive)
                            <span class="sr-only">active</span>
                        @endif
                    </a>
                @endif
            @endif
        @endforeach
    </div>

    <!-- Perfil / Logout al final del sidebar -->
    <div x-data="{ menuIsOpen: false }" class="mt-auto" x-on:keydown.esc.window="menuIsOpen = false">
        <button
            type="button"
            class="flex w-full items-center rounded-md gap-2 p-2 text-left text-neutral-600 hover:bg-black/5 hover:text-neutral-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white dark:focus-visible:outline-white"
            x-bind:class="menuIsOpen ? 'bg-black/10 dark:bg-white/10' : ''"
            aria-haspopup="true"
            x-on:click="menuIsOpen = ! menuIsOpen"
            x-bind:aria-expanded="menuIsOpen"
        >
            <div class="flex flex-col">
                <span class="text-sm font-bold text-neutral-900 dark:text-white">{{ Auth::user()->name }}</span>
                <span class="w-32 overflow-hidden text-ellipsis text-xs md:w-36" aria-hidden="true">
                    {{ Auth::user()->email }}
                </span>
                <span class="sr-only">profile settings</span>
            </div>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                stroke="currentColor"
                fill="none"
                stroke-width="2"
                class="ml-auto size-4 shrink-0 -rotate-90 md:rotate-0"
                aria-hidden="true"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        <div
            x-cloak
            x-show="menuIsOpen"
            class="absolute bottom-20 right-6 z-20 -mr-1 w-48 divide-y divide-neutral-300 bg-white dark:divide-neutral-700 dark:bg-neutral-950 rounded-md md:-right-44 md:bottom-4"
            role="menu"
            x-on:click.outside="menuIsOpen = false"
            x-on:keydown.down.prevent="$focus.wrap().next()"
            x-on:keydown.up.prevent="$focus.wrap().previous()"
            x-transition
            x-trap="menuIsOpen"
        >
            <div class="flex flex-col py-1.5">
                <a
                    href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-hidden dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white"
                    role="menuitem"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="size-5 shrink-0"
                        aria-hidden="true"
                    >
                        <path
                            d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z"
                        />
                    </svg>
                    <span>Mi Perfil</span>
                </a>
            </div>
            <div class="flex flex-col py-1.5 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        role="menuitem"
                        class="w-full flex items-center justify-start gap-2 px-2 py-1.5 text-left text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-hidden dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            class="size-5 shrink-0"
                            aria-hidden="true"
                        >
                            <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M6 10a.75.75 0 0 1 .75-.75h9.546l-1.048-.943a.75.75 0 1 1 1.004-1.114l2.5 2.25a.75.75 0 0 1 0 1.114l-2.5 2.25a.75.75 0 1 1-1.004-1.114l1.048-.943H6.75A.75.75 0 0 1 6 10Z" clip-rule="evenodd" />
                        </svg>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Botón toggle para pantallas pequeñas -->
<button
    x-cloak
    class="fixed right-4 top-4 z-20 rounded-full bg-black p-4 md:hidden text-neutral-100 dark:bg-white dark:text-black"
    x-on:click="showSidebar = ! showSidebar"
>
    <svg
        x-show="showSidebar"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 16 16"
        fill="currentColor"
        class="size-5"
        aria-hidden="true"
    >
        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
    </svg>
    <svg
        x-show="!showSidebar"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 16 16"
        fill="currentColor"
        class="size-5"
        aria-hidden="true"
    >
        <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
    </svg>
    <span class="sr-only">sidebar toggle</span>
</button>
