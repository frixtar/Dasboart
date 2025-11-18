<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

            <h1 class="text-3xl font-bold text-center mb-6 text-gray-700">
                🏪 Punto de Venta - Login
            </h1>

            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-600 font-medium mb-1">Correo</label>
                    <input class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        type="email" name="email" required autofocus autocomplete="username">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-600 font-medium mb-1">Contraseña</label>
                    <input class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        type="password" name="password" required autocomplete="current-password">
                </div>

                <!-- Remember -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-gray-600 text-sm">Recordarme</span>
                </div>

                <button
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg py-2 text-lg font-semibold transition">
                    Iniciar Sesión
                </button>

                <div class="text-center mt-4 text-sm">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-indigo-600 font-semibold">Registrarse</a>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
