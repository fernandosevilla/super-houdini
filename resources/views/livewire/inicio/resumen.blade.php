<section class="grid gap-6">
    <h1 class="text-2xl font-bold dark:text-white">Bienvenido a Super Houdini</h1>
    <p class="text-gray-600 dark:text-gray-400">Gestor de contraseñas con Zonas Compartidas y funciones inteligentes.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('zonas.index') }}">
            <div class="bg-neutral-50 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 shadow-lg rounded-lg p-4 flex flex-col justify-between hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                <h2 class="text-lg font-medium dark:text-white">Total de Zonas Creadas</h2>
                <p class="text-3xl">{{ $totalZonas }}</p>
            </div>
        </a>

        <a href="{{ route('zonas.index') }}">
            <div class="bg-neutral-50 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 shadow-lg rounded-lg p-4 flex flex-col justify-between hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                <h2 class="text-lg font-medium dark:text-white">Total de Zonas Compartidas</h2>
                <p class="text-3xl">{{ $totalZonasCompartidas }}</p>
            </div>
        </a>

        <div class="bg-neutral-50 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 shadow-lg rounded-lg p-4 flex flex-col justify-between hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
            <h2 class="text-lg font-medium dark:text-white">Total de Credenciales Disponibles</h2>
            <p class="text-3xl">{{ $totalCredenciales }}</p>
        </div>
    </div>
</section>
