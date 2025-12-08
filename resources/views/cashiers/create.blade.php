<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nuevo Cajero
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('cashiers.store') }}" method="POST">
                        @csrf
                        
                        <!-- Nombre -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre Completo</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <!-- Texto de ayuda agregado -->
                            <p class="text-xs text-gray-500 mt-1">🔤 Solo letras y espacios (sin números).</p>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico (Login)</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirmar Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Correo Electrónico</label>
                            <input type="email" name="email_confirmation" value="{{ old('email_confirmation') }}" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                            <input type="password" name="password" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <p class="text-xs text-gray-500 mt-1">🔒 Mínimo 8 caracteres.</p>
                            @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('cashiers.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition shadow-lg">
                                Registrar Cajero
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>