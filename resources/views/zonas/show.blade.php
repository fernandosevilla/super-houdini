@extends('layouts.admin')

@section('title', 'Zonas')

@section('content')
<div class="container mx-auto p-4">
    @livewire('zonas.detalle-zona', ['zona' => $zona])
</div>
@endsection
