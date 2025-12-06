<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validamos que venga el carrito
        $data = $request->validate([
            'cart' => 'required|array|min:1',
        ]);

        try {
            // INICIO DE LA TRANSACCIÓN (Todo o nada)
            $result = DB::transaction(function () use ($data) {
                
                $cart = $data['cart'];
                $totalSale = 0;
                $subtotalSale = 0;
                $ivaSale = 0;

                $invoiceNumber = 'TICKET-' . date('Ymd-His');

                $sale = Sale::create([
                    'user_id' => Auth::id(), // El cajero actual
                    'invoice_number' => $invoiceNumber,
                    'subtotal' => 0, // Lo actualizamos al final
                    'iva' => 0,
                    'total' => 0,
                ]);

                foreach ($cart as $item) {
                    $product = Product::lockForUpdate()->find($item['id']); // Bloqueamos para evitar doble venta simultánea

                    // Validación de Stock (Seguridad de Backend)
                    if (!$product || $product->stock < $item['quantity']) {
                        throw new \Exception("Stock insuficiente para el producto: " . $product->name);
                    }

                    // Cálculos
                    $price = $product->price; // Usamos el precio de la BD, no el del frontend (por seguridad)
                    $quantity = $item['quantity'];
                    $rowTotal = $price * $quantity;

                    // Lógica de IVA
                    $rowSubtotal = $rowTotal;
                    $rowIva = 0;

                    if ($product->has_iva) {
                        $rowSubtotal = $rowTotal / 1.16;
                        $rowIva = $rowTotal - $rowSubtotal;
                    }

                    // Sumamos a los generales
                    $totalSale += $rowTotal;
                    $subtotalSale += $rowSubtotal;
                    $ivaSale += $rowIva;

                    // C. Guardar el Detalle
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total_row' => $rowTotal,
                    ]);

                    // D. RESTAR STOCK (Lo más importante)
                    $product->decrement('stock', $quantity);
                }

                // E. Actualizamos la venta con los totales reales calculados
                $sale->update([
                    'subtotal' => $subtotalSale,
                    'iva' => $ivaSale,
                    'total' => $totalSale,
                ]);

                return $sale;
            });

            // Si todo salió bien:
            return response()->json([
                'success' => true,
                'message' => 'Venta guardada correctamente',
                'invoice_number' => $result->invoice_number
            ]);

        } catch (\Exception $e) {
            // Si algo falló (Stock insuficiente, error de BD, etc.)
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 400); // Error 400
        }
    }
}