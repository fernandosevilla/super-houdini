<div x-data="{ modalOpen: false, warningModalIsOpen: false }" x-on:open-modal-credencial.window="modalOpen = true"
    x-on:close-modal-credencial.window="modalOpen = false">
    {{-- Encabezado y botón “Crear nueva credencial” --}}
    <section class="mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold dark:text-white">Credenciales</h2>

            {{-- Abrir modal --}}
            <button x-on:click="modalOpen = true; $wire.abrirModalCrear()" type="button"
                class="whitespace-nowrap rounded-md bg-black border border-black px-4 py-2
                       text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75
                       focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black
                       active:opacity-100 active:opacity-offset-0 disabled:opacity-75 disabled:cursor-not-allowed
                       dark:bg-white dark:border-white dark:text-black dark:focus-visible:outline-white">
                Crear nueva credencial
            </button>
        </div>
    </section>

    {{-- Listado de credenciales --}}
    @if ($credenciales->isEmpty())
        <p class="text-gray-600 dark:text-gray-400">No hay credenciales en esta zona.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($credenciales as $cred)
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg shadow p-4 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium dark:text-white">{{ $cred->nombre_sitio }}</h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Usuario: {{ $cred->nombre_usuario ?? '—' }}
                        </p>

                        @if ($cred->url)
                            <p class="text-sm text-blue-500 mt-1">
                                <a href="{{ $cred->url }}" target="_blank" class="hover:underline">
                                    {{ Str::limit($cred->url, 25) }}
                                </a>
                            </p>
                        @endif

                        <p class="text-xs text-gray-400 mt-2">
                            Creada el {{ $cred->created_at->format('d/m/Y') }}
                        </p>

                        @if ($cred->fecha_ultima_rotacion)
                            @php $dias = $cred->dias_para_rotacion; @endphp

                            @if ($dias > 0)
                                <p class="text-sm text-yellow-500 mt-2">
                                    Se rotará en {{ $dias }} día{{ $dias !== 1 ? 's' : '' }}
                                </p>
                            @elseif ($dias === 0)
                                <p class="text-sm text-red-500 mt-2">
                                    Se rota hoy
                                </p>
                            @else
                                <p class="text-sm text-red-500 mt-2">
                                    Rotación vencida hace {{ abs($dias) }} día{{ abs($dias) !== 1 ? 's' : '' }}
                                </p>
                            @endif
                        @endif
                    </div>
                    <div class="mt-4 flex justify-end">
                        <div x-data="{ isOpen: false, openedWithKeyboard: false }"
                            x-on:keydown.esc.window="isOpen = false; openedWithKeyboard = false" class="relative w-fit">
                            {{-- Botón desplegable “Acciones” --}}
                            <button type="button" x-on:click="isOpen = ! isOpen"
                                x-on:keydown.space.prevent="openedWithKeyboard = true"
                                x-on:keydown.enter.prevent="openedWithKeyboard = true"
                                x-on:keydown.down.prevent="openedWithKeyboard = true"
                                class="inline-flex items-center gap-2 whitespace-nowrap rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-800 dark:bg-neutral-900 dark:focus-visible:outline-neutral-300"
                                x-bind:class="(isOpen || openedWithKeyboard) ? 'text-neutral-900 dark:text-white' :
                                'text-neutral-600 dark:text-neutral-300'"
                                x-bind:aria-expanded="isOpen || openedWithKeyboard" aria-haspopup="true">
                                Acciones&nbsp; <i class="fa-solid fa-arrow-down"></i>
                            </button>

                            {{-- Menú desplegable --}}
                            <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard"
                                x-on:click.outside="isOpen = false; openedWithKeyboard = false"
                                x-on:keydown.down.prevent="$focus.wrap().next()"
                                x-on:keydown.up.prevent="$focus.wrap().previous()"
                                class="absolute top-11 flex w-fit min-w-48 flex-col divide-y divide-neutral-300 overflow-hidden rounded-md bg-neutral-50 dark:divide-neutral-700 dark:bg-neutral-900"
                                role="menu">
                                <div class="flex flex-col py-1.5">
                                    <button wire:click="abrirModalEditar({{ $cred->id }})"
                                        class="flex items-center gap-2 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-hidden dark:bg-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-50/5 dark:hover:text-white dark:focus-visible:bg-neutral-50/10 dark:focus-visible:text-white"
                                        role="menuitem">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </button>
                                    <button
                                        type="button"
                                        x-on:click="warningModalIsOpen = true; selectedId = {{ $cred->id }}; isOpen = false"
                                        class="flex items-center gap-2 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-hidden dark:bg-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-50/5 dark:hover:text-white dark:focus-visible:bg-neutral-50/10 dark:focus-visible:text-white"
                                        role="menuitem">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $credenciales->links() }}
        </div>
    @endif

    {{-- Modal -- Ajustado para usar “modalOpen” --}}
    <div x-cloak x-show="modalOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalOpen"
        x-on:keydown.escape.window="modalOpen = false" x-on:click.self="modalOpen = false"
        class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8"
        role="dialog" aria-modal="true" aria-labelledby="crearCredencialModalTitle">
        <!-- Modal Dialog -->
        <div x-show="modalOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="scale-0" x-transition:enter-end="scale-100"
            class="flex w-full max-w-lg flex-col gap-4 max-h-[calc(100vh-4rem)] overflow-y-auto rounded-md bg-white text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300">
            <!-- Dialog Header -->
            <div class="flex items-center justify-between bg-neutral-50/60 p-4 dark:bg-neutral-950/20">
                <h3 id="crearCredencialModalTitle" class="font-semibold tracking-wide text-neutral-900 dark:text-white">
                    @if ($editingId)
                        Editar Credencial
                    @else
                        Crear Credencial
                    @endif
                </h3>
                <button x-on:click="modalOpen = false" aria-label="Cerrar modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
                        fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Dialog Body -->
            <div class="flex w-full p-2 flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="nombreSitio" class="pl-0.5 text-sm font-medium">Nombre del sitio</label>
                <input id="nombreSitio" type="text" required wire:model.defer="nombreSitio"
                    placeholder="Nombre del sitio"
                    class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-neutral-900/50 dark:focus-visible:outline-white" />
                @error('nombreSitio')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex w-full p-2 flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="nombreUsuario" class="pl-0.5 text-sm font-medium">Nombre de usuario (opcional)</label>
                <input id="nombreUsuario" type="text" wire:model.defer="nombreUsuario"
                    placeholder="Nombre del usuario"
                    class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-neutral-900/50 dark:focus-visible:outline-white" />
                @error('nombreUsuario')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{
                showGenerator: false,
                // configuración del generador
                length: 20,
                passwordGen: '',
                includeUpper: true,
                includeLower: true,
                includeNumbers: true,
                includeSymbols: true,
                // al entanglarlo, sincronizamos la contraseña con Livewire
                init() {
                    // Inicializamos passwordGen con el valor actual de Livewire.contrasenia
                    this.passwordGen = @entangle('contrasenia');
                    this.generate();
                },
                generate() {
                    const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    const lower = 'abcdefghijklmnopqrstuvwxyz';
                    const numbers = '0123456789';
                    const symbols = '!@#$%^&*()_+[]{}|;:,.<>?';
                    let chars = '';

                    if (this.includeUpper) chars += upper;
                    if (this.includeLower) chars += lower;
                    if (this.includeNumbers) chars += numbers;
                    if (this.includeSymbols) chars += symbols;

                    if (!chars) {
                        this.passwordGen = '';
                        @this.set('contrasenia', '');
                        return;
                    }

                    let pass = '';
                    for (let i = 0; i < this.length; i++) {
                        pass += chars.charAt(Math.floor(Math.random() * chars.length));
                    }

                    this.passwordGen = pass;
                    // lo pasamos a Livewire
                    @this.set('contrasenia', this.passwordGen);
                },
                copy() {
                    if (!this.passwordGen) return;
                    navigator.clipboard.writeText(this.passwordGen)
                        .then(() => {
                            document.querySelector('#copySuccess').classList.remove('hidden');
                            setTimeout(() => {
                                document.querySelector('#copySuccess').classList.add('hidden');
                            }, 2000);
                        });
                }
            }" x-init="init()" class="relative space-y-4">
                <template x-if="!showGenerator">
                    <div class="ml-2">
                        <label for="contrasenia"
                            class="pl-0.5 text-sm font-medium text-neutral-600 dark:text-neutral-300">
                            Contraseña
                        </label>
                        <input id="contrasenia" type="password" required wire:model.defer="contrasenia"
                            placeholder="Contraseña"
                            class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-neutral-900/50 dark:focus-visible:outline-white" />
                        {{-- icono para abrir generador --}}
                        <button type="button" x-on:click="showGenerator = true"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-600 dark:text-neutral-300 bg-neutral-50 dark:bg-neutral-900 rounded"
                            aria-label="Abrir generador">
                            <i class="fa-solid fa-sliders"></i>
                        </button>
                        @error('contrasenia')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </template>

                {{-- generador de contraseña --}}
                <template x-if="showGenerator">
                    <article
                        class="w-full space-y-4 bg-neutral-50 p-4 rounded-md dark:bg-neutral-900 dark:text-neutral-300">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold dark:text-white">Genera tu contraseña</h3>
                            <button type="button" x-on:click="showGenerator = false"
                                class="text-neutral-600 dark:text-neutral-300" aria-label="Cerrar generador">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <p id="copySuccess" class="hidden text-center text-sm text-green-600">Contraseña copiada</p>

                        {{-- campo con la contraseña generada --}}
                        <div>
                            <label for="contrasenia_generada"
                                class="pl-0.5 text-sm font-medium text-neutral-600 dark:text-neutral-300">
                                Contraseña
                            </label>
                            <input id="contrasenia_generada" type="text" x-model="passwordGen" readonly
                                class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:bg-neutral-900/50 dark:focus-visible:outline-white" />
                            <button type="button" @click="copy()"
                                class="mt-2 rounded-md bg-black px-3 py-1 text-sm font-medium text-neutral-100 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-white dark:text-black dark:focus-visible:outline-white">
                                Copiar
                            </button>
                        </div>

                        {{-- slider para longitud --}}
                        <div class="space-y-2">
                            <label for="rangeSlider"
                                class="block text-sm font-medium text-neutral-600 dark:text-neutral-300">
                                Longitud: <span x-text="length"></span>
                            </label>
                            <input x-model="length" id="rangeSlider" type="range" min="8" max="50"
                                step="1" @input="generate()"
                                class="h-2 w-full appearance-none bg-neutral-600/15 focus:outline-black dark:bg-neutral-300/15 dark:focus:outline-white [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:border-none [&::-moz-range-thumb]:bg-black active:[&::-moz-range-thumb]:scale-110 dark:[&::-moz-range-thumb]:bg-white [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:border-none [&::-webkit-slider-thumb]:bg-black active:[&::-webkit-slider-thumb]:scale-110 dark:[&::-webkit-slider-thumb]:bg-white [&::-moz-range-thumb]:rounded-full [&::-webkit-slider-thumb]:rounded-full rounded-full" />
                        </div>

                        {{-- opciones de inclusión --}}
                        <div class="space-y-2">
                            <h4 class="text-sm font-medium dark:text-white">Incluir</h4>
                            <ul class="grid grid-cols-2 gap-4">
                                <li>
                                    <label for="cb_mayusculas"
                                        class="flex items-center gap-2 p-3 rounded-md border border-neutral-300 dark:border-neutral-700
                          text-sm font-medium text-neutral-600 dark:text-neutral-300
                          hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                        {{-- Checkbox oculto y estilizado con peer --}}
                                        <input id="cb_mayusculas" type="checkbox" x-model="includeUpper"
                                            @change="generate()"
                                            class="peer h-4 w-4 appearance-none rounded bg-neutral-50 border border-neutral-300
                              checked:bg-black checked:border-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800
                              dark:bg-neutral-900 dark:border-neutral-700 dark:checked:bg-white dark:checked:border-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white" />

                                        <span>Mayúsculas</span>
                                    </label>
                                </li>

                                <li>
                                    <label for="cb_minusculas"
                                        class="flex items-center gap-2 p-3 rounded-md border border-neutral-300 dark:border-neutral-700
                                                text-sm font-medium text-neutral-600 dark:text-neutral-300
                                                hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                        <input id="cb_minusculas" type="checkbox" x-model="includeLower"
                                            @change="generate()"
                                            class="peer h-4 w-4 appearance-none rounded bg-neutral-50 border border-neutral-300
                                                checked:bg-black checked:border-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800
                                                dark:bg-neutral-900 dark:border-neutral-700 dark:checked:bg-white dark:checked:border-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white" />

                                        <span>Minúsculas</span>
                                    </label>
                                </li>

                                <li>
                                    <label for="cb_numeros"
                                        class="flex items-center gap-2 p-3 rounded-md border border-neutral-300 dark:border-neutral-700
                                                text-sm font-medium text-neutral-600 dark:text-neutral-300
                                                hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                        <input id="cb_numeros" type="checkbox" x-model="includeNumbers"
                                            @change="generate()"
                                            class="peer h-4 w-4 appearance-none rounded bg-neutral-50 border border-neutral-300
                                                checked:bg-black checked:border-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800
                                                dark:bg-neutral-900 dark:border-neutral-700 dark:checked:bg-white dark:checked:border-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white" />

                                        <span>Números</span>
                                    </label>
                                </li>

                                <li>
                                    <label for="cb_caracteres_especiales"
                                        class="flex items-center gap-2 p-3 rounded-md border border-neutral-300 dark:border-neutral-700
                                                text-sm font-medium text-neutral-600 dark:text-neutral-300
                                                hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                        <input id="cb_caracteres_especiales" type="checkbox" x-model="includeSymbols"
                                            @change="generate()"
                                            class="peer h-4 w-4 appearance-none rounded bg-neutral-50 border border-neutral-300
                                                checked:bg-black checked:border-black focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800
                                                dark:bg-neutral-900 dark:border-neutral-700 dark:checked:bg-white dark:checked:border-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white" />

                                        <span>Caracteres especiales</span>
                                    </label>
                                </li>
                            </ul>
                        </div>


                        {{-- botón para regenerar --}}
                        <div class="flex justify-center">
                            <button type="button" @click="generate()"
                                class="rounded-md bg-black px-4 py-2 text-sm font-medium text-neutral-100 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-white dark:text-black dark:focus-visible:outline-white">
                                Regenerar
                            </button>
                        </div>
                    </article>
                </template>
            </div>


            <div class="flex w-full p-2 flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="url" class="pl-0.5 text-sm font-medium">URL (opcional)</label>
                <input id="url" type="url" wire:model.defer="url" placeholder="URL"
                    class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-neutral-900/50 dark:focus-visible:outline-white" />
                @error('url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex w-full p-2 flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="notas" class="pl-0.5 text-sm font-medium">Notas (opcional)</label>
                <textarea id="notas" wire:model.defer="notas" rows="3" placeholder="Notas"
                    class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2
                            focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-neutral-900/50 dark:focus-visible:outline-white"></textarea>
                @error('notas')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{
                currentVal: @entangle('rotacionCadaDias') ?? 1,
                minVal: 1,
                maxVal: 45,
                decimalPoints: 0,
                incrementAmount: 5
            }" class="flex flex-col gap-1 items-center mb-2">
                <label for="rotacionCadaDias" class="pl-1 text-sm text-neutral-600 dark:text-neutral-300">Rotar cada
                    (días)</label>
                <div class="flex items-center">
                    <button x-on:click="currentVal = Math.max(minVal, currentVal - incrementAmount)"
                        class="flex h-10 items-center justify-center rounded-md bg-neutral-100 px-4 py-2 text-neutral-600 hover:opacity-75 focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 dark:bg-neutral-800 dark:text-neutral-300 dark:focus-visible:outline-white"
                        aria-label="subtract">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                            stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                        </svg>
                    </button>
                    <input x-model="currentVal.toFixed(decimalPoints)" id="rotacionCadaDias" type="text"
                        wire:model="rotacionCadaDias"
                        class="h-10 w-20 rounded-none bg-transparent text-center text-neutral-900 focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-black dark:text-white dark:focus-visible:outline-white"
                        readonly />
                    <button x-on:click="currentVal = Math.min(maxVal, currentVal + incrementAmount)"
                        class="flex h-10 items-center justify-center rounded-md bg-neutral-100 px-4 py-2 text-neutral-600 hover:opacity-75 focus-visible:z-10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 dark:bg-neutral-800 dark:text-neutral-300 dark:focus-visible:outline-white"
                        aria-label="add">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                            stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>

            <div
                class="flex flex-col-reverse justify-between gap-2 bg-neutral-50/60 p-4 dark:bg-neutral-950/20 sm:flex-row sm:items-center md:justify-end">
                <button x-on:click="modalOpen = false" type="button"
                    class="whitespace-nowrap rounded-md px-4 py-2 text-center text-sm font-medium tracking-wide
                        text-neutral-600 transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2
                        focus-visible:outline-black active:opacity-100 active:opacity-offset-0
                        dark:text-neutral-300 dark:focus-visible:outline-white">
                    Cancelar
                </button>
                <button wire:click="guardarCredencial" type="button"
                    class="whitespace-nowrap rounded-md bg-black px-4 py-2 text-center text-sm font-medium
                            tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline-2
                            focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100
                            active:opacity-offset-0 dark:bg-white dark:text-black dark:focus-visible:outline-white">
                    @if ($editingId)
                        Guardar cambios
                    @else
                        Crear
                    @endif
                </button>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="warningModalIsOpen"
        x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="warningModalIsOpen"
        x-on:keydown.escape.window="warningModalIsOpen = false"
        x-on:click.self="warningModalIsOpen = false"
        class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
        role="dialog" aria-modal="true" aria-labelledby="warningModalTitle">

        <div
            x-show="warningModalIsOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 scale-50"
            x-transition:enter-end="opacity-100 scale-100"
            class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-md bg-white text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300">

            <div class="flex items-center justify-between bg-neutral-50/60 px-4 py-2 dark:bg-neutral-950/20">
                <div class="flex items-center justify-center rounded-full bg-amber-500/20 text-amber-500 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <button x-on:click="warningModalIsOpen = false" aria-label="Cerrar modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-4 text-center">
                <h3 id="warningModalTitle" class="mb-2 font-semibold tracking-wide text-neutral-900 dark:text-white">
                    ¿Seguro quieres eliminar la credencial?
                </h3>
                <p>Esta acción no se puede deshacer.</p>
            </div>
            <div class="flex items-center justify-center border-neutral-300 p-4 dark:border-neutral-700">
                <button
                    x-on:click="
                        $wire.eliminarCredencial(selectedId);
                        warningModalIsOpen = false;
                    "
                    type="button"
                    class="w-full whitespace-nowrap rounded-md border border-amber-500 bg-amber-500 px-4 py-2 text-center text-sm font-semibold tracking-wide text-white transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500 active:opacity-100 active:outline-offset-0">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
