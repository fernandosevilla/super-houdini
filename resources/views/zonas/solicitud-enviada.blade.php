@extends('layouts.admin')

@section('title', 'Solicitud enviada')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold dark:text-white">Solicitud enviada</h1>
        <p class="text-gray-600 dark:text-gray-400">Tu petición de acceso a <strong>{{ $zona->nombre }}</strong> ha sido recibida.<br>
        En cuanto el propietario la apruebe, podrás verla en tu lista de “Zonas Compartidas”.</p>

        <div class="mt-4 flex justify-center">
            <a href="{{ route('zonas.index') }}"
                class="whitespace-nowrap rounded-md bg-black border border-black px-4 py-2 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-white dark:border-white dark:text-black dark:focus-visible:outline-white">
                Volver a mis zonas
            </a>
        </div>
    </div>
@endsection
