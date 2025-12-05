<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Agregar Cliente') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8">
        <form action="{{ route('clientes.store') }}" method="POST"
              class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">Nombre *</label>
                <input type="text" name="name" required
                       class="w-full border rounded p-2">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium">Teléfono</label>
                    <input type="text" name="phone" class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-medium">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium">RFC</label>
                <input type="text" name="rfc" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Dirección</label>
                <textarea name="address" class="w-full border rounded p-2"></textarea>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar
            </button>
        </form>
    </div>
</x-app-layout>
