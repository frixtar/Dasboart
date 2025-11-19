<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Editar Auto
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow">

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label>Marca</label>
                            <input type="text" name="brand" value="{{ $product->brand }}"
                                   class="w-full rounded border-gray-300" required>
                        </div>

                        <div>
                            <label>Modelo</label>
                            <input type="text" name="model" value="{{ $product->model }}"
                                   class="w-full rounded border-gray-300" required>
                        </div>

                        <div>
                            <label>Año</label>
                            <input type="number" name="year" value="{{ $product->year }}"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>VIN</label>
                            <input type="text" name="vin" value="{{ $product->vin }}"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Placas</label>
                            <input type="text" name="plate" value="{{ $product->plate }}"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Color</label>
                            <input type="text" name="color" value="{{ $product->color }}"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Kilometraje</label>
                            <input type="number" name="mileage" value="{{ $product->mileage }}"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Precio</label>
                            <input type="number" name="price" value="{{ $product->price }}"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Costo</label>
                            <input type="number" name="cost" value="{{ $product->cost }}"
                                   class="w-full rounded border-gray-300">
                        </div>

                        <div>
                            <label>Estado</label>
                            <select name="status" class="w-full rounded border-gray-300">
                                <option {{ $product->status == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                <option {{ $product->status == 'Vendido' ? 'selected' : '' }}>Vendido</option>
                                <option {{ $product->status == 'Apartado' ? 'selected' : '' }}>Apartado</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-4">
                        <label>Descripción</label>
                        <textarea name="description" class="w-full rounded border-gray-300">{{ $product->description }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label>Imagen</label>
                        <input type="file" name="image" class="w-full">

                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="mt-2 h-32 rounded">
                        @endif
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700 transition">
                            Actualizar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
