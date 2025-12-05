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
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre Completo</label>
                            <input type="text" name="name" class="w-full rounded border-gray-300" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico (Login)</label>
                            <input type="email" name="email" class="w-full rounded border-gray-300" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                            <input type="password" name="password" class="w-full rounded border-gray-300" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="w-full rounded border-gray-300" required>
                        </div>

                        <hr class="mb-6">

                        <h3 class="font-bold text-lg mb-4">Permisos Especiales</h3>
                        
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="can_edit_products" id="perm_edit" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <label for="perm_edit" class="ml-2 text-gray-700">Puede Editar Productos (Precios/Stock)</label>
                        </div>

                        <div class="flex items-center mb-6">
                            <input type="checkbox" name="can_delete_products" id="perm_del" class="w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500">
                            <label for="perm_del" class="ml-2 text-gray-700">Puede Eliminar Productos del sistema</label>
                        </div>

                        <button type="submit" class="w-full bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Registrar Cajero
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>