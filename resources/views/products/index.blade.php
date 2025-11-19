<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Productos / Autos') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('products.create') }}"
                   class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                    + Agregar Auto
                </a>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">Marca</th>
                            <th class="px-6 py-3">Modelo</th>
                            <th class="px-6 py-3">Año</th>
                            <th class="px-6 py-3">Precio</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $product->brand }}</td>
                                <td class="px-6 py-4">{{ $product->model }}</td>
                                <td class="px-6 py-4">{{ $product->year }}</td>
                                <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $product->status }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        ✏️
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('¿Eliminar este producto?')"
                                                class="text-red-600 hover:text-red-800">
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
    </div>
</x-app-layout>
