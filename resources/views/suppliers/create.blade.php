<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Proveedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-700">Registrar Información</h3>
                        <a href="{{ route('suppliers.index') }}" class="text-gray-500 hover:text-gray-700">Cancelar</a>
                    </div>

                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre Empresa -->
                            <div class="col-span-2">
                                <label for="name" class="block font-medium text-sm text-gray-700">Nombre de la Empresa</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Ej. Distribuidora Global">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Nombre Contacto (contact_name) -->
                            <div>
                                <label for="contact_name" class="block font-medium text-sm text-gray-700">Nombre del Vendedor / Contacto</label>
                                <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ej. Juan Pérez">
                                @error('contact_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">Teléfono</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ej. 55 1234 5678">
                                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-span-2">
                                <label for="email" class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="contacto@empresa.com">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="col-span-2">
                                <label for="address" class="block font-medium text-sm text-gray-700">Dirección</label>
                                <textarea name="address" id="address" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('suppliers.index') }}" class="bg-gray-100 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-200 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Guardar Proveedor
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>