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
    // 1. PROCESAR Y GUARDAR LA VENTA
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
                // Generar folio único
                $invoiceNumber = 'TICKET-' . date('Ymd-His') . '-' . rand(100, 999);

                $sale = Sale::create([
                    'user_id' => Auth::id(),
                    'invoice_number' => $invoiceNumber,
                    'subtotal' => 0, // Se calcula abajo
                    'iva' => 0,
                    'total' => 0,
                    'amount_paid' => $data['amount_paid'] ?? 0, 
                    'change' => $data['change'] ?? 0,    
                ]);

                $totalSale = 0;
                $subtotalSale = 0;
                $ivaSale = 0;

                // Procesar cada producto
                foreach ($cart as $item) {
                    $product = Product::lockForUpdate()->find($item['id']);

                    if (!$product || $product->stock < $item['quantity']) {
                        throw new \Exception("Stock insuficiente para: " . $product->name);
                    }

                    $price = $product->price;
                    $quantity = $item['quantity'];
                    $rowTotal = $price * $quantity;

                    // Cálculo de IVA
                    $rowSubtotal = $rowTotal;
                    $rowIva = 0;

                    if ($product->has_iva) {
                        $rowSubtotal = $rowTotal / 1.16;
                        $rowIva = $rowTotal - $rowSubtotal;
                    }

                    $totalSale += $rowTotal;
                    $subtotalSale += $rowSubtotal;
                    $ivaSale += $rowIva;

                    // Guardar detalle
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total_row' => $rowTotal,
                    ]);

                    // Restar inventario
                    $product->decrement('stock', $quantity);
                }

                // Actualizar totales finales de la venta
                $sale->update([
                    'subtotal' => $subtotalSale,
                    'iva' => $ivaSale,
                    'total' => $totalSale,
                ]);

                return $sale;
            });

            return response()->json([
                'success' => true,
                'message' => 'Venta guardada correctamente',
                'invoice_number' => $result->invoice_number,
                'sale_id' => $result->id 
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 400);
        }
    }

    public function ticket($id)
    {
        $sale = Sale::with(['details.product', 'user'])->findOrFail($id);
        
        return view('sales.ticket', compact('sale'));
    }
}