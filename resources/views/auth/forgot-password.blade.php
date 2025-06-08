<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-white text-center">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Solo déjanos saber tu dirección de correo electrónico y enviaremos un enlace de restablecimiento de contraseña que te permitirá elegir una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="dark:text-white" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-neutral-700 dark:text-white" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
