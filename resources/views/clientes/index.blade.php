<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8">
        <div class="flex justify-end mb-4">
            <a href="{{ route('clientes.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Agregar Cliente
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Teléfono</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">RFC</th>
                        <th class="px-6 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($clientes as $client)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $client->name }}</td>
                            <td class="px-6 py-3">{{ $client->phone }}</td>
                            <td class="px-6 py-3">{{ $client->email }}</td>
                            <td class="px-6 py-3">{{ $client->rfc }}</td>

                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('clientes.edit', $client) }}"
                                   class="text-blue-600 hover:text-blue-800 mr-3">
                                    ✏️
                                </a>

                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('¿Eliminar cliente?')">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</x-app-layout>
