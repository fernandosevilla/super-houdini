<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Super Houdini</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/test.js'])
    @endif
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">
    <nav x-data="{ mobileMenuIsOpen: false }" x-on:click.away="mobileMenuIsOpen = false"
        class="flex items-center justify-between px-6 py-4" aria-label="penguin ui menu">
        <!-- Brand Logo -->
        <a href="#" class="text-2xl font-bold text-neutral-900 dark:text-white">
            Super Houdini
        </a>
        <!-- Desktop Menu -->
        <ul class="hidden items-center gap-4 sm:flex">
            <li>
                <a href="#inicio"
                    class="font-bold text-black underline-offset-2
                                        hover:text-black focus:outline-hidden focus:underline
                                        dark:text-white dark:hover:text-white"
                    aria-current="page">
                    Inicio
                </a>
            </li>
            <li>
                <a href="#sobreMi"
                    class="font-medium text-neutral-600 underline-offset-2
                            hover:text-black focus:outline-hidden focus:underline
                            dark:text-neutral-300 dark:hover:text-white">
                    Sobre mi
                </a>
            </li>
            <li>
                <a href="#contacto"
                    class="font-medium text-neutral-600 underline-offset-2
                            hover:text-black focus:outline-hidden focus:underline
                            dark:text-neutral-300 dark:hover:text-white">
                    Contacto
                </a>
            </li>
            <!-- CTA Button -->
            <li>
                <a href="{{ route('login') }}"
                    class="rounded-md bg-black border border-black px-4 py-2 text-center
                            text-sm font-medium tracking-wide text-neutral-100 hover:opacity-75
                            focus-visible:outline-2 focus-visible:outline-offset-2
                            focus-visible:outline-black active:opacity-100 active:outline-offset-0
                            dark:bg-white dark:border-white dark:text-black dark:focus-visible:outline-white">
                    Iniciar sesión
                </a>
            </li>

            <li>
                <a href="{{ route('register') }}"
                    class="whitespace-nowrap rounded-md bg-neutral-100 border border-neutral-100 px-4 py-2
                            text-sm font-medium tracking-wide text-neutral-900 transition hover:opacity-75
                            text-center focus-visible:outline-2 focus-visible:outline-offset-2
                            focus-visible:outline-neutral-100 active:opacity-100 active:outline-offset-0
                            dark:bg-neutral-800 dark:border-neutral-800 dark:text-white dark:focus-visible:outline-neutral-800">
                    Registrarse
                </a>
            </li>
        </ul>
        <!-- Mobile Menu Button -->
        <button x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen"
            x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
            class="flex text-neutral-600 dark:text-neutral-300 sm:hidden" aria-label="mobile menu"
            aria-controls="mobileMenu">
            <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Mobile Menu -->
        <ul x-cloak x-show="mobileMenuIsOpen"
            x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" id="mobileMenu"
            class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col
                    divide-y divide-neutral-300 rounded-b-md bg-neutral-50 px-6 pb-6 pt-20
                    dark:divide-neutral-700 dark:bg-neutral-900 sm:hidden">

            <li class="py-4">
                <a href="#inicio" class="w-full text-lg font-bold text-black focus:underline dark:text-white"
                    aria-current="page">
                    Inicio
                </a>
            </li>
            <li class="py-4">
                <a href="#sobreMi"
                    class="w-full text-lg font-medium text-neutral-600 focus:underline dark:text-neutral-300">
                    Sobre mi
                </a>
            </li>
            <li class="py-4">
                <a href="#contacto"
                    class="w-full text-lg font-medium text-neutral-600 focus:underline dark:text-neutral-300">
                    Contacto
                </a>
            </li>
            <!-- CTA Button -->
            <li class="mt-4 w-full border-none">
                <a href="{{ route('login') }}"
                    class="rounded-md bg-black border border-black px-4 py-2 block text-center
                            font-medium tracking-wide text-neutral-100 hover:opacity-75
                            focus-visible:outline-2 focus-visible:outline-offset-2
                            focus-visible:outline-black active:opacity-100 active:outline-offset-0
                            dark:bg-white dark:border-white dark:text-black
                            dark:focus-visible:outline-white">
                    Iniciar sesión
                </a>

                <a href="{{ route('register') }}"
                    class="mt-4 rounded-md bg-neutral-100 border border-neutral-100 px-4 py-2 block text-center
                            font-medium tracking-wide text-neutral-900 hover:opacity-75
                            focus-visible:outline-2 focus-visible:outline-offset-2
                            focus-visible:outline-neutral-100 active:opacity-100 active:outline-offset-0
                            dark:bg-neutral-800 dark:border-neutral-800 dark:text-white dark:focus-visible:outline-neutral-800">

                    Registrarse
                </a>
            </li>
        </ul>
    </nav>

    <header class="w-full h-[calc(100vh-4rem)] header-landing">
        <div class="flex h-full items-center justify-center px-6">
            <!-- Contenedor de columnas: COLUMN en móvil, ROW en md+ -->
            <div class="flex flex-col md:flex-row w-full max-w-7xl items-center justify-between gap-8">
                <!-- Columna izquierda: full width en móvil, 1/3 en md+ -->
                <div class="w-full md:w-1/3 mb-8 md:mb-0">
                    <h1 class="text-4xl font-bold text-white text-center md:text-left">Super Houdini</h1>
                    <p class="mt-4 text-lg text-neutral-300 text-center md:text-left">
                        Houdini escapaba de cadenas. Tú del caos de las contraseñas.
                    </p>
                </div>

                <!-- Columna derecha -->
                <article x-data="{
                    length: 20,
                    password: '',
                    includeUpper: true,
                    includeLower: true,
                    includeNumbers: true,
                    includeSymbols: true,
                    generate() {
                        const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                        const lower = 'abcdefghijklmnopqrstuvwxyz'
                        const numbers = '0123456789'
                        const symbols = '!@#$%^&*()_+[]{}|;:,.<>?'
                        let chars = ''

                        if (this.includeUpper)
                            chars += upper

                        if (this.includeLower)
                            chars += lower

                        if (this.includeNumbers)
                            chars += numbers

                        if (this.includeSymbols)
                            chars += symbols

                        if (!chars) {
                            this.password = ''
                            return
                        }

                        let pass = ''

                        for (let i = 0; i < this.length; i++) {
                            pass += chars.charAt(Math.floor(Math.random() * chars.length))
                        }

                        this.password = pass
                    },
                    copy() {
                        if (!this.password)
                            return

                        navigator.clipboard.writeText(this.password)
                            .then(() => {
                                document.querySelector('#copySuccess').classList.remove('hidden')
                                setTimeout(() => {
                                    document.querySelector('#copySuccess').classList.add('hidden')
                                }, 2000)
                            })
                    }
                }"
                    class="w-auto group grid rounded-md max-w-2xl overflow-hidden
                            bg-neutral-50 text-neutral-600
                            dark:bg-neutral-900 dark:text-neutral-300"
                    x-init="generate()">
                    <div class="flex flex-col justify-center p-6 space-y-4">
                        <h3 class="text-center text-balance text-xl font-bold text-neutral-900 lg:text-2xl dark:text-white"
                            aria-describedby="articleDescription">
                            Genera tu contraseña
                        </h3>

                        <p id="articleDescription" class="my-4 max-w-lg text-pretty text-sm text-center">
                            Genera contraseñas seguras y únicas para tus cuentas.
                        </p>

                        <p id="copySuccess" class="hidden text-center text-sm text-green-600">Contraseña copiada</p>

                        <label for="contrasenia_generada" class="w-fit pl-0.5 text-sm">Contraseña</label>
                        <input id="contrasenia_generada" type="text" x-model="password" readonly
                            class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                            name="contrasenia_generada" placeholder="Contraseña generada" />
                        <button type="button" @click="copy()"
                            class="rounded-md bg-black border border-black px-2 py-2 text-sm font-medium tracking-wide text-neutral-100 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-white dark:border-white dark:text-black dark:focus-visible:outline-white">Copiar</button>


                            <label for="rangeSlider" class="sr-only">Brightness</label>
                            <input x-model="length" id="rangeSlider" type="range" min="8" max="50"
                                step="1" @input="generate()"
                                class="h-2 w-full appearance-none bg-neutral-600/15 focus:outline-black
                                    dark:bg-neutral-300/15 dark:focus:outline-white
                                    [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:appearance-none
                                    [&::-moz-range-thumb]:border-none [&::-moz-range-thumb]:bg-black
                                    active:[&::-moz-range-thumb]:scale-110 dark:[&::-moz-range-thumb]:bg-white
                                    [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none
                                    [&::-webkit-slider-thumb]:border-none [&::-webkit-slider-thumb]:bg-black
                                    active:[&::-webkit-slider-thumb]:scale-110 dark:[&::-webkit-slider-thumb]:bg-white
                                    [&::-moz-range-thumb]:rounded-full [&::-webkit-slider-thumb]:rounded-full
                                    rounded-full" />
                            <span class="w-10 text-lg font-bold text-neutral-900 dark:text-white"
                                x-text="length"></span>

                        <h3 class="mb-2 pl-1 font-semibold text-neutral-900 dark:text-white">Incluir</h3>

                        <ul class="grid grid-cols-2 gap-4 min-w-52 overflow-clip rounded-md">
                            <li>
                                <label for="cb_mayusculas"
                                    class="flex items-center gap-2 p-3 text-sm font-medium text-neutral-600 dark:text-neutral-300 has-checked:text-neutral-900 dark:has-checked:text-white has-disabled:cursor-not-allowed has-disabled:opacity-75">
                                    <span class="relative flex items-center">
                                        <input id="cb_mayusculas" type="checkbox" x-model="includeUpper"
                                            @change="generate()"
                                            class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded bg-neutral-50 before:absolute before:inset-0 checked:before:bg-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800 checked:focus:outline-black active:outline-offset-0 disabled:cursor-not-allowed dark:bg-neutral-900 dark:checked:before:bg-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white"
                                            value="Mayusculas" checked />
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            aria-hidden="true" stroke="currentColor" fill="none" stroke-width="4"
                                            class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/2 text-neutral-100 peer-checked:visible dark:text-black">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </span>
                                    <span>Mayúsculas</span>
                                </label>
                            </li>
                            <li>
                                <label for="cb_minusculas"
                                    class="flex items-center gap-2 p-3 text-sm font-medium text-neutral-600 dark:text-neutral-300 has-checked:text-neutral-900 dark:has-checked:text-white has-disabled:cursor-not-allowed has-disabled:opacity-75">
                                    <span class="relative flex items-center">
                                        <input id="cb_minusculas" type="checkbox" x-model="includeLower"
                                            @change="generate()"
                                            class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded bg-neutral-50 before:absolute before:inset-0 checked:before:bg-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800 checked:focus:outline-black active:outline-offset-0 disabled:cursor-not-allowed dark:bg-neutral-900 dark:checked:before:bg-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white"
                                            value="Minusculas" checked />
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            aria-hidden="true" stroke="currentColor" fill="none" stroke-width="4"
                                            class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/2 text-neutral-100 peer-checked:visible dark:text-black">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </span>
                                    <span>Minúsculas</span>
                                </label>
                            </li>

                            <li>
                                <label for="cb_numeros"
                                    class="flex items-center gap-2 p-3 text-sm font-medium text-neutral-600 dark:text-neutral-300 has-checked:text-neutral-900 dark:has-checked:text-white has-disabled:cursor-not-allowed has-disabled:opacity-75">
                                    <span class="relative flex items-center">
                                        <input id="cb_numeros" type="checkbox" x-model="includeNumbers"
                                            @change="generate()"
                                            class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded bg-neutral-50 before:absolute before:inset-0 checked:before:bg-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800 checked:focus:outline-black active:outline-offset-0 disabled:cursor-not-allowed dark:bg-neutral-900 dark:checked:before:bg-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white"
                                            value="Números" checked />
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            aria-hidden="true" stroke="currentColor" fill="none" stroke-width="4"
                                            class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/2 text-neutral-100 peer-checked:visible dark:text-black">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </span>
                                    <span>Números</span>
                                </label>
                            </li>
                            <li>
                                <label for="cb_caracteres_especiales"
                                    class="flex items-center gap-2 p-3 text-sm font-medium text-neutral-600 dark:text-neutral-300 has-checked:text-neutral-900 dark:has-checked:text-white has-disabled:cursor-not-allowed has-disabled:opacity-75">
                                    <span class="relative flex items-center">
                                        <input id="cb_caracteres_especiales" type="checkbox" x-model="includeSymbols"
                                            @change="generate()"
                                            class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded bg-neutral-50 before:absolute before:inset-0 checked:before:bg-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800 checked:focus:outline-black active:outline-offset-0 disabled:cursor-not-allowed dark:bg-neutral-900 dark:checked:before:bg-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white"
                                            value="Caracteres especiales" />
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            aria-hidden="true" stroke="currentColor" fill="none" stroke-width="4"
                                            class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/2 text-neutral-100 peer-checked:visible dark:text-black">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </span>
                                    <span>C. Especiales</span>
                                </label>
                            </li>
                        </ul>


                        <div class="flex items-center justify-center">
                            <button type="button" @click="generate()"
                                class="whitespace-nowrap rounded-md bg-black border border-black
                                 px-4 py-2 text-sm font-medium tracking-wide
                                 text-neutral-100 transition hover:opacity-75 text-center
                                 focus-visible:outline-2 focus-visible:outline-offset-2
                                 focus-visible:outline-black active:opacity-100 active:outline-offset-0
                                 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-white
                                 dark:border-white dark:text-black dark:focus-visible:outline-white">
                                Generar contraseña
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </header>



    <section id="sobreMi" class="m-12 flex flex-col items-center justify-center">
        <!-- Título centrado -->
        <h2 class="text-3xl font-bold text-center mb-6 dark:text-white">
            Sobre mí
        </h2>

        <article
            class="group flex rounded-md max-w-xs flex-col overflow-hidden bg-neutral-50 text-neutral-600
                    dark:bg-neutral-900 dark:text-neutral-300">
            <!-- Images -->
            <div class="relative h-36">
                <img src="https://media1.giphy.com/media/v1.Y2lkPTc5MGI3NjExMG1jb2t4bGkwajU0dDBhY2RucmV5Z3owN2poa2RscDBianRycGZwaCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/wguPsH9cpTJPRH8Yxp/giphy.gif"
                    class="h-full w-full object-cover" alt="cover photo" />
                <div
                    class="relative z-10 mx-auto -mt-14 size-28 overflow-hidden rounded-full border-4 border-neutral-50 dark:border-neutral-900">
                    <img src="{{ asset('img/yo.jpg') }}"
                        class="h-full object-cover transition duration-700 ease-out group-hover:scale-105"
                        alt="avatar" />
                </div>
            </div>

            <div class="flex flex-col gap-2 p-6 text-center mt-12">
                <h3 class="text-balance text-xl font-bold text-neutral-900 lg:text-2xl dark:text-white"
                    aria-describedby="profileDescription">
                    Fernando Sevilla Espinosa
                </h3>
                <span
                    class="mx-auto w-fit bg-black px-2 py-1 text-xs text-neutral-100 dark:bg-white dark:text-black rounded-md">
                    DESARROLLADOR MULTIPLATAFORMA
                </span>

                <p id="profileDescription" class="mt-4 text-pretty text-sm">
                    Me llamo Fernando Sevilla y soy un apasionado por el desarrollo de software.
                </p>
                <p class="mt-4 text-pretty text-sm">
                    Actualmente estoy terminando el C.F.G.S de Desarrollo de Aplicaciones Multiplataforma en el
                    I.E.S. Juan Bosco de Alcázar de San Juan.
                </p>
                <!-- Social Links -->
                <div class="mt-4 flex items-center justify-center gap-6">
                    <!-- Email -->
                    <a href="mailto:fernando.sevillaespinosa@gmail.com"
                        class="text-neutral-600 hover:text-black dark:text-neutral-300 dark:hover:text-white"
                        aria-label="email">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-7 shrink-0">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                    </a>

                    <!-- Linkedin -->
                    <a href="https://www.linkedin.com/in/fernandosevillaespinosa" target="_blank"
                        class="text-neutral-600 hover:text-black dark:text-neutral-300 dark:hover:text-white"
                        aria-label="linkedin">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="size-6 shrink-0">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>
    </section>

    <section id="contacto" class="my-12">
        <h2 class="text-3xl font-bold text-center mb-6 dark:text-white">
            Contacto
        </h2>

        {{-- @livewire('formulario') --}}
    </section>

    <footer class="p-6 flex items-center justify-center text-center text-sm bg-neutral-50 dark:bg-neutral-900
                    dark:text-neutral-100">
        <p>© {{ date('Y') }} <a href="https://github.com/fernandosevilla" target="_blank">Fernando Sevilla Espinosa</a>. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
