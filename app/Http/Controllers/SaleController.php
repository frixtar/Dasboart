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
        $data = $request->validate([
            'cart' => 'required|array|min:1',
            'amount_paid' => 'nullable|numeric',
            'change' => 'nullable|numeric',
        ]);

        try {
            $result = DB::transaction(function () use ($data) {
                
                $cart = $data['cart'];
                $totalSale = 0;
                $subtotalSale = 0;
                $ivaSale = 0;

                // Generamos un folio único real
                $invoiceNumber = 'TICKET-' . date('Ymd-His') . '-' . rand(100, 999);

                // A. Creamos el encabezado de la venta (Inicializado en 0)
                $sale = Sale::create([
                    'user_id' => Auth::id(),
                    'invoice_number' => $invoiceNumber,
                    'subtotal' => 0,
                    'iva' => 0,
                    'total' => 0,
                ]);


                foreach ($cart as $item) {
                    // Bloqueamos el producto para evitar errores de concurrencia
                    $product = Product::lockForUpdate()->find($item['id']);

                    // Validación de Stock (Seguridad de Backend)
                    if (!$product || $product->stock < $item['quantity']) {
                        throw new \Exception("Stock insuficiente para el producto: " . $product->name);
                    }

                    // Cálculos usando el precio real de la Base de Datos
                    $price = $product->price; 
                    $quantity = $item['quantity'];
                    $rowTotal = $price * $quantity;

                    // Lógica de IVA
                    $rowSubtotal = $rowTotal;
                    $rowIva = 0;

                    if ($product->has_iva) {
                        $rowSubtotal = $rowTotal / 1.16;
                        $rowIva = $rowTotal - $rowSubtotal;
                    }

                    // Sumamos a los acumuladores generales
                    $totalSale += $rowTotal;
                    $subtotalSale += $rowSubtotal;
                    $ivaSale += $rowIva;

                    // C. Guardar el Detalle (Renglón del ticket)
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total_row' => $rowTotal,
                    ]);

                    // D. RESTAR STOCK (Crucial)
                    $product->decrement('stock', $quantity);
                }

                // E. Actualizamos la venta con los totales finales calculados
                $sale->update([
                    'subtotal' => $subtotalSale,
                    'iva' => $ivaSale,
                    'total' => $totalSale,
                ]);

                return $sale;
            });

            // Respuesta exitosa al Frontend
            return response()->json([
                'success' => true,
                'message' => 'Venta guardada correctamente',
                'invoice_number' => $result->invoice_number,
                'sale_id' => $result->id
            ]);

        } catch (\Exception $e) {
            // Si algo falla, Laravel deshace todos los cambios (Rollback)
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 400);
        }
    }
}