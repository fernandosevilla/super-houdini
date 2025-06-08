@extends('layouts.admin')

@section('title', 'Perfil')

@section('content')

    <h1 class="text-2xl font-bold dark:text-white mb-4">
        {{ __('Perfil') }}
    </h1>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-neutral-50 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-neutral-50 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-neutral-50 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

@endsection
