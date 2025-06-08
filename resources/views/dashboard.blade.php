@extends('layouts.admin')

@section('title', 'Inicio')

@section('content')
    <h1 class="text-2xl font-bold dark:text-white mb-4">Inicio</h1>

    @livewire('inicio.resumen')

@endsection
