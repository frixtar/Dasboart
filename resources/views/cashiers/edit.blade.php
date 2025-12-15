<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            {{ __('Editar Perfil de Cajero') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6 text-white">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold backdrop-blur-sm border-2 border-white/30">
                            {{ substr($cashier->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">{{ $cashier->name }}</h3>
                            <p class="text-blue-100 opacity-90">{{ $cashier->email }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cashiers.update', $cashier->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <!-- SECCIÓN 1: DATOS GENERALES -->
                    <h4 class="text-gray-700 font-bold text-lg mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 6.134-1 6.134V9.134"></path></svg>
                        Información Personal
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        
                        <!-- Nombre -->
                        <div>
                            <label class="block text-gray-600 text-sm font-bold mb-2">Nombre Completo</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $cashier->name) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition" required>
                            </div>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-600 text-sm font-bold mb-2">Correo Electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $cashier->email) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition" required>
                            </div>
                            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- SECCIÓN 2: SEGURIDAD -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
                        <h4 class="text-yellow-800 font-bold text-lg mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Seguridad (Opcional)
                        </h4>
                        <p class="text-yellow-700 text-sm mb-4">Solo llena estos campos si deseas cambiar la contraseña del cajero.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-600 text-xs font-bold uppercase tracking-wider mb-2">Nueva Contraseña</label>
                                <input type="password" name="password" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 outline-none transition bg-white" placeholder="••••••••">
                                <p class="text-xs text-yellow-600 mt-1 ml-1">🔒 Mínimo 8 caracteres.</p>
                                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-600 text-xs font-bold uppercase tracking-wider mb-2">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 outline-none transition bg-white" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <!-- BOTONES DE ACCIÓN -->
                    <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('cashiers.index') }}" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-bold transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Cancelar
                        </a>
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>