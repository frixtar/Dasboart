<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'POS') }} - Terminal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 h-screen overflow-hidden">
    
    <!-- Barra Superior Minimalista -->
    <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 z-50 relative">
        
        <!-- Izquierda: Logo y Título -->
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-8 w-auto fill-current text-orange-500" />
            </a>
            <div class="h-6 w-px bg-gray-300 mx-2"></div>
            <h1 class="font-bold text-xl text-gray-700 tracking-tight">TERMINAL DE VENTA</h1>
        </div>

        <!-- Derecha: Usuario y Salir -->
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wider">{{ Auth::user()->role }}</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100 hover:text-red-700 transition" 
                        title="Cerrar Sesión">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </header>

    <!-- Contenido Principal (El POS) -->
    <main class="h-[calc(100vh-64px)]">
        {{ $slot }}
    </main>

</body>
</html>