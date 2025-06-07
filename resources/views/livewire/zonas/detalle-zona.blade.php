<div>
    <h1 class="text-2xl font-semibold dark:text-white">{{ $zona->nombre }}</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
        Creada por <strong>{{ $zona->creador->name }}</strong> ({{ $zona->created_at->format('d/m/Y') }})
    </p>

    @can('view', $zona)
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Tienes acceso a esta zona</p>
        {{-- @dd($zona) --}}

        <livewire:credenciales.lista-credenciales :zonaId="$zona->id" />
    @else
        @if (!$zona->usuarios->contains(auth()->id()))
            <button
                wire:click="solicitarAcceso"
                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Solicitar acceso
            </button>

        @elseif ($zona->usuarios->find(auth()->id())->pivot->estado === 'pendiente')
            <p class="mt-4 text-yellow-600">Tu solicitud está pendiente de respuesta.</p>

        @elseif ($zona->usuarios->find(auth()->id())->pivot->estado === 'denegado')
            <p class="mt-4 text-red-600">Tu solicitud fue denegada.</p>
        @endif
    @endcan
</div>
