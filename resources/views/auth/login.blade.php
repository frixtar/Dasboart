<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-amber-100 p-4">
        
        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all hover:scale-[1.01]">
            
            <!-- AQUÍ ESTÁ EL CAMBIO: LOGO REAL -->
            <div class="bg-white p-8 text-center border-b border-gray-100 relative overflow-hidden">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('kutay.png') }}" alt="Abarrotes Kutay" class="h-32 w-auto object-contain transition-transform hover:scale-105">
                </div>
                
                <p class="text-orange-600 mt-2 text-sm font-bold tracking-wide uppercase opacity-80">
                    Sistema de Punto de Venta
                </p>
            </div>

            <div class="p-8 pt-6">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm animate-pulse">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Credenciales incorrectas</h3>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-6 relative">
                        <label class="block text-gray-600 font-bold mb-2 text-xs uppercase tracking-wider">Correo Electrónico</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none bg-gray-50 focus:bg-white text-gray-700"
                                type="email" name="email" required autofocus autocomplete="username" placeholder="admin@tienda.com">
                        </div>
                    </div>

                    <div class="mb-6">
                         <label class="block text-gray-600 font-bold mb-2 text-xs uppercase tracking-wider">Contraseña</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none bg-gray-50 focus:bg-white text-gray-700"
                                type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center space-x-2 cursor-pointer group select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 transition cursor-pointer">
                            <span class="text-sm text-gray-500 group-hover:text-gray-700 transition font-medium">Recordarme</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-orange-600 hover:text-orange-800 font-bold transition hover:underline">
                                ¿Olvidaste tu clave?
                            </a>
                        @endif
                    </div>

                    <button class="w-full bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Iniciar Sesión</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>

                </form>
            </div>
        </div>
        
        <div class="absolute bottom-4 text-center text-orange-900/20 text-xs font-semibold select-none">
            &copy; {{ date('Y') }} Abarrotes Kutay
        </div>

    </div>
</x-guest-layout>