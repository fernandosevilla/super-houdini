@extends('layouts.admin')

@section('title', 'Zonas')

@section('content')
    <h1 class="text-2xl font-bold dark:text-white mb-4">Lista de Zonas</h1>

    @livewire('zonas.lista-zonas')
@endsection
