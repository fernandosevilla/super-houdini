<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-white">
        {{ __('Esta es una zona segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" class="dark:text-white" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full dark:bg-neutral-700 dark:text-white"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
