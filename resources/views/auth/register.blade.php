<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-amber-100 p-4">
        
        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all hover:scale-[1.01]">
            
            <!-- Encabezado -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-20 h-20 bg-white opacity-10 rounded-full -translate-x-10 -translate-y-10"></div>
                
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Nuevo Usuario
                </h2>
                <p class="text-orange-100 text-sm opacity-90">Únete al equipo de trabajo</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-bold mb-2 text-xs uppercase tracking-wider">Nombre Completo</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none bg-gray-50 focus:bg-white transition"
                               type="text" name="name" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-bold mb-2 text-xs uppercase tracking-wider">Correo Electrónico</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none bg-gray-50 focus:bg-white transition"
                               type="email" name="email" required autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-bold mb-2 text-xs uppercase tracking-wider">Contraseña</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none bg-gray-50 focus:bg-white transition"
                               type="password" name="password" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block text-gray-600 font-bold mb-2 text-xs uppercase tracking-wider">Confirmar Contraseña</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none bg-gray-50 focus:bg-white transition"
                               type="password" name="password_confirmation" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Botón -->
                    <button class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                        Registrar Cuenta
                    </button>

                    <div class="mt-6 text-center text-sm">
                        <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-800 font-bold hover:underline">
                            ¿Ya tienes cuenta? Iniciar Sesión
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>