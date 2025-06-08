<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <div x-data="{ showSidebar: false }" class="relative flex w-full flex-col md:flex-row">
        @include('components.sidebar')

        <div id="main-content" class="h-screen w-full overflow-y-auto p-4 bg-white dark:bg-neutral-950">
            @yield('content')
        </div>
    </div>

    @livewireScripts
</body>
</html>
