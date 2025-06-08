<div>
    <form wire:submit.prevent="enviar" class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl w-full mx-auto p-6">
        <div class="space-y-4">
            <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="nombreCompleto" class="w-fit pl-0.5 text-sm">Nombre completo</label>
                <input id="nombreCompleto" type="text" wire:model="nombreCompleto"
                    class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2
                            focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed
                            disabled:opacity-75 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                    placeholder="Escribe tu nombre" />
                @error('nombreCompleto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                <label for="email" class="w-fit pl-0.5 text-sm">Email</label>
                <input id="email" type="email" wire:model="email"
                    class="w-full rounded-md bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2
                            focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed
                            disabled:opacity-75 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                    placeholder="Escribe tu email" />
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
            <label for="mensaje" class="w-fit pl-0.5 text-sm">Mensaje</label>
            <textarea id="mensaje" wire:model="mensaje" rows="6"
                class="w-full rounded-md bg-neutral-50 px-2.5 py-2 text-sm focus-visible:outline-2
                        focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed
                        disabled:opacity-75 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                placeholder="Escribe tu mensaje aquí…">
            </textarea>
            @error('mensaje')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="md:col-span-2">
            <button type="submit"
                class="rounded-md bg-black border border-black px-4 py-2 text-sm font-medium tracking-wide
                        text-neutral-100 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2
                        focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75
                        disabled:cursor-not-allowed dark:bg-white dark:border-white dark:text-black
                        dark:focus-visible:outline-white">
                Enviar
            </button>
        </div>
    </form>
</div>
