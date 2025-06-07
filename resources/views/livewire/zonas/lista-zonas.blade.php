<div
    class="space-y-8"
    x-data="{
        modalIsOpen: @entangle('showModal'),
        warningModalIsOpen: false,
        selectedId: @entangle('selectedId'),
    }"
    x-on:keydown.escape.window="modalIsOpen = false; warningModalIsOpen = false"
    x-on:notification.window="alert(event.detail.type.toUpperCase() + ': ' + event.detail.message)"
>
    {{-- Sección: Mis Zonas --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold dark:text-white">Mis Zonas</h2>

            <button
                wire:click="abrirCrearZona"
                @click="modalIsOpen = true"
                type="button"
                class="whitespace-nowrap rounded-md bg-black border border-black px-4 py-2
                       text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75
                       focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black
                       active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed
                       dark:bg-white dark:border-white dark:text-black dark:focus-visible:outline-white"
            >
                Crear nueva zona
            </button>
        </div>

        @if ($zonasCreadas->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">Aún no has creado ninguna zona.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($zonasCreadas as $zona)
                    <div class="bg-neutral-50 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 shadow-lg rounded-lg p-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-medium dark:text-gray-200">{{ $zona->nombre }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                @if ($zona->requiere_verificacion)
                                    <span class="w-fit inline-flex overflow-hidden rounded-md bg-white text-xs font-medium text-amber-800 dark:bg-neutral-950 dark:text-amber-500">
                                        <span class="px-2 py-1 bg-amber-500/10 dark:bg-amber-500/10">Requiere verificación</span>
                                    </span>
                                @else
                                    <span class="w-fit inline-flex overflow-hidden rounded-md bg-white text-xs font-medium text-green-800 dark:bg-neutral-950 dark:text-green-500">
                                        <span class="px-2 py-1 bg-green-500/10 dark:bg-green-500/10">Acceso libre</span>
                                    </span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-2">Creada el {{ $zona->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <div
                                x-data="{ isOpen: false, openedWithKeyboard: false }"
                                x-on:keydown.esc.window="isOpen = false; openedWithKeyboard = false"
                                class="relative w-fit">
                                {{-- Botón desplegable “Acciones” --}}
                                <button
                                    type="button"
                                    x-on:click="isOpen = ! isOpen"
                                    x-on:keydown.space.prevent="openedWithKeyboard = true"
                                    x-on:keydown.enter.prevent="openedWithKeyboard = true"
                                    x-on:keydown.down.prevent="openedWithKeyboard = true"
                                    class="inline-flex items-center gap-2 whitespace-nowrap rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-800 dark:bg-neutral-900 dark:focus-visible:outline-neutral-300"
                                    x-bind:class="(isOpen || openedWithKeyboard) ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-300'"
                                    x-bind:aria-expanded="isOpen || openedWithKeyboard"
                                    aria-haspopup="true">
                                    Acciones&nbsp;<i class="fa-solid fa-arrow-down"></i>
                                </button>

                                {{-- Menú desplegable --}}
                                <div
                                    x-cloak
                                    x-show="isOpen || openedWithKeyboard"
                                    x-transition
                                    x-trap="openedWithKeyboard"
                                    x-on:click.outside="isOpen = false; openedWithKeyboard = false"
                                    x-on:keydown.down.prevent="$focus.wrap().next()"
                                    x-on:keydown.up.prevent="$focus.wrap().previous()"
                                    class="absolute top-11 flex w-fit min-w-48 flex-col divide-y divide-neutral-300 overflow-hidden rounded-md bg-neutral-50 dark:divide-neutral-700 dark:bg-neutral-900"
                                    role="menu">
                                    <div class="flex flex-col py-1.5">
                                        <a href="{{ route('zonas.show', $zona) }}"
                                        class="flex items-center gap-2 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-hidden dark:bg-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-50/5 dark:hover:text-white dark:focus-visible:bg-neutral-50/10 dark:focus-visible:text-white" role="menuitem">
                                            <i class="fa-solid fa-eye"></i> Ver
                                        </a>
                                        <button
                                            wire:click="editarZona({{ $zona->id }})"
                                            class="flex items-center gap-2 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-hidden dark:bg-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-50/5 dark:hover:text-white dark:focus-visible:bg-neutral-50/10 dark:focus-visible:text-white" role="menuitem">
                                            <i class="fa-solid fa-pen-to-square"></i> Editar
                                        </button>
                                        <button
                                            @click="selectedId = {{ $zona->id }}; warningModalIsOpen = true"
                                            class="flex items-center gap-2 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-hidden dark:bg-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-50/5 dark:hover:text-white dark:focus-visible:bg-neutral-50/10 dark:focus-visible:text-white" role="menuitem">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $zonasCreadas->links() }}
            </div>
        @endif
    </section>

    {{-- Zonas Compartidas --}}
    <section>
        <h2 class="text-xl font-semibold dark:text-white mb-4">Zonas Compartidas</h2>

        @if ($zonasCompartidas->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">No tienes zonas compartidas activas.</p>
        @else
            {{-- Aquí tu grid de zonas compartidas --}}
        @endif
    </section>

    {{-- MODAL: Crear Nueva Zona (Alpine + Livewire) --}}
    <div
        x-cloak
        x-show="modalIsOpen"
        x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="modalIsOpen"
        x-on:keydown.escape.window="modalIsOpen = false"
        x-on:click.self="modalIsOpen = false"
        class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8"
        role="dialog"
        aria-modal="true"
        aria-labelledby="crearZonaModalTitle">
        <!-- Modal Dialog -->
        <div
            x-show="modalIsOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="scale-0"
            x-transition:enter-end="scale-100"
            class="flex w-full max-w-lg flex-col gap-4 overflow-hidden rounded-md bg-white text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300">
            <!-- Dialog Header -->
            <div class="flex items-center justify-between bg-neutral-50/60 p-4 dark:bg-neutral-950/20">
                <h3 id="crearZonaModalTitle" class="font-semibold tracking-wide text-neutral-900 dark:text-white">
                    {{ $zonaId ? 'Editar Zona' : 'Crear Zona' }}
                </h3>
                <button x-on:click="modalIsOpen = false" aria-label="Cerrar modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Dialog Body -->
            <div class="flex w-full p-2 flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="nombreZona" class="pl-0.5 text-sm font-medium">Nombre de la zona</label>
                <input
                    id="nombreZona"
                    type="text"
                    wire:model.defer="nombreZona"
                    placeholder="Nombre de la zona"
                    class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                />
                @error('nombreZona')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <label for="requiereVerificacion" class="inline-flex items-center justify-between gap-3 rounded-md bg-neutral-50 px-4 py-1.5 dark:bg-neutral-900">
                <input
                    id="requiereVerificacion"
                    type="checkbox"
                    wire:model.defer="requiereVerificacion"
                    class="peer sr-only"
                    role="switch"
                />
                <span class="tracking-wide text-sm font-medium text-neutral-600 peer-checked:text-neutral-900 peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:text-neutral-300 dark:peer-checked:text-white">
                    Requiere verificación
                </span>
                <div
                    class="relative h-6 w-11 rounded-full bg-white
                           after:absolute after:bottom-0 after:left-[0.0625rem] after:top-0
                           after:my-auto after:h-5 after:w-5 after:rounded-full after:bg-neutral-600
                           after:transition-all after:content-[''] peer-checked:after:translate-x-5
                           peer-checked:bg-black peer-checked:after:bg-neutral-100
                           peer-focus:outline-2 peer-focus:outline-offset-2 peer-focus:outline-neutral-800
                           peer-focus:peer-checked:outline-black peer-active:outline-offset-0
                           peer-disabled:cursor-not-allowed peer-disabled:opacity-70
                           dark:border-neutral-700 dark:bg-neutral-950 dark:after:bg-neutral-300
                           dark:peer-checked:bg-white dark:peer-checked:after:bg-black
                           dark:peer-focus:outline-neutral-300 dark:peer-focus:peer-checked:outline-white"
                    aria-hidden="true">
                </div>
            </label>
            @error('requiereVerificacion')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <!-- Dialog Footer -->
            <div class="flex flex-col-reverse justify-between gap-2 bg-neutral-50/60 p-4 dark:bg-neutral-950/20 sm:flex-row sm:items-center md:justify-end">
                <button
                    x-on:click="modalIsOpen = false"
                    type="button"
                    class="whitespace-nowrap rounded-md px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:opacity-offset-0 dark:text-neutral-300 dark:focus-visible:outline-white">
                    Cancelar
                </button>
                {{-- Botón que INVOLUCRA a Livewire --}}
                <button
                    wire:click="{{ $zonaId ? 'actualizarZona' : 'crearZona' }}"
                    type="button"
                    class="whitespace-nowrap rounded-md bg-black px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:opacity-offset-0 dark:bg-white dark:text-black dark:focus-visible:outline-white">
                    {{ $zonaId ? 'Actualizar' : 'Crear' }}
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
                    ¿Seguro quieres eliminar la zona?
                </h3>
                <p>Esta acción no se puede deshacer.</p>
            </div>
            <div class="flex items-center justify-center border-neutral-300 p-4 dark:border-neutral-700">
                <button
                    x-on:click="
                        $wire.eliminarZona(selectedId);
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
