<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Agregar Auto') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow">

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label>Marca</label>
                            <input type="text" name="brand"
                                   class="w-full rounded border-gray-300" required>
                        </div>

                        <div>
                            <label>Modelo</label>
                            <input type="text" name="model"
                                   class="w-full rounded border-gray-300" required>
                        </div>

                        <div>
                            <label>Año</label>
                            <input type="number" name="year"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>VIN</label>
                            <input type="text" name="vin"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Placas</label>
                            <input type="text" name="plate"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Color</label>
                            <input type="text" name="color"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Kilometraje</label>
                            <input type="number" name="mileage"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Precio</label>
                            <input type="number" name="price"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Costo</label>
                            <input type="number" name="cost"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Estado</label>
                            <select name="status" class="w-full rounded border-gray-300">
                                <option value="Disponible">Disponible</option>
                                <option value="Vendido">Vendido</option>
                                <option value="Apartado">Apartado</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-4">
                        <label>Descripción</label>
                        <textarea name="description"
                                  class="w-full rounded border-gray-300"></textarea>
                    </div>

                    <div class="mt-4">
                        <label>Imagen</label>
                        <input type="file" name="image" class="w-full">
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                            Guardar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
