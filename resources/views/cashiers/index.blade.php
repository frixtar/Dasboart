<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Cajeros
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('cashiers.create') }}" class="bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block hover:bg-blue-600 transition">
                        + Nuevo Cajero
                    </a>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cashiers as $cajero)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cajero->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cajero->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center gap-3">
                                    <a href="{{ route('cashiers.edit', $cajero->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Editar</a>
                                    
                                    <form action="{{ route('cashiers.destroy', $cajero->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar a este cajero?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>