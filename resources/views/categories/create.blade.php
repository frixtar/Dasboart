<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        
                        <!-- Nombre de la Categoría -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @error('name') border-red-500 @enderror" 
                                   placeholder="Ej: Lácteos" required autofocus>
                            <p class="text-xs text-gray-500 mt-1">🔤 Nombre corto para identificar el grupo de productos.</p>
                            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Descripción (Opcional) -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Descripción (Opcional)</label>
                            <textarea name="description" rows="3" 
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500" 
                                      placeholder="Ej: Leche, yogurt, quesos y derivados...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('categories.index') }}" class="bg-gray-100 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-200 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Guardar Categoría
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>