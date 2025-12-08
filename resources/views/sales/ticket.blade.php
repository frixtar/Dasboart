<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket #{{ $sale->invoice_number }}</title>
    <style>
        /* Configuración para impresora térmica (80mm o 58mm) */
        body {
            font-family: 'Courier New', Courier, monospace; /* Fuente tipo ticket */
            font-size: 12px;
            margin: 0;
            padding: 5px;
            width: 80mm; /* Ancho estándar, ajusta a 58mm si es pequeña */
            color: #000;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h2 { margin: 0; font-size: 16px; font-weight: bold; }
        .header p { margin: 2px 0; }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th { text-align: left; border-bottom: 1px dashed #000; }
        td { padding: 4px 0; vertical-align: top; }
        
        .qty { width: 10%; font-weight: bold; }
        .desc { width: 60%; }
        .price { width: 30%; text-align: right; }
        
        .totals {
            margin-top: 10px;
            text-align: right;
        }
        .totals .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .total-final {
            font-size: 16px;
            font-weight: bold;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
        
        /* Ocultar botón de imprimir en el papel */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()"> <!-- Auto-imprimir al cargar -->

    <div class="header">
        <h2>{{ config('app.name') }}</h2>
        <p>Av. Principal #123, Centro</p>
        <p>Tel: 555-123-4567</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <p><strong>Folio:</strong> {{ $sale->invoice_number }}</p>
        <p><strong>Cajero:</strong> {{ $sale->user->name }}</p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th class="qty">Cant</th>
                <th class="desc">Producto</th>
                <th class="price">Importe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->details as $detail)
            <tr>
                <td class="qty">{{ $detail->quantity }}</td>
                <td class="desc">
                    {{ $detail->product->name }} <br>
                    <small style="color: #555">${{ number_format($detail->price, 2) }} c/u</small>
                </td>
                <td class="price">${{ number_format($detail->total_row, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="totals">
        <div class="row">
            <span>Subtotal:</span>
            <span>${{ number_format($sale->subtotal, 2) }}</span>
        </div>
        <div class="row">
            <span>IVA (16%):</span>
            <span>${{ number_format($sale->iva, 2) }}</span>
        </div>
        <div class="row total-final">
            <span>TOTAL:</span>
            <span>${{ number_format($sale->total, 2) }}</span>
        </div>
        
        <!-- AHORA SÍ MOSTRAMOS ESTO -->
        <div class="row" style="margin-top:5px">
            <span>Efectivo:</span>
            <span>${{ number_format($sale->amount_paid, 2) }}</span>
        </div>
        <div class="row">
            <span>Cambio:</span>
            <span>${{ number_format($sale->change, 2) }}</span>
        </div>
    </div>

    <div class="footer">
        <p>¡Gracias por su compra!</p>
        <p>Este no es un comprobante fiscal</p>
        <p>www.abarroteskutay.com</p>
        
        <br>
        <div class="divider"></div>
        <div class="totals">
        <div class="row">
            <span>Subtotal:</span>
            <span>${{ number_format($sale->subtotal, 2) }}</span>
        </div>
        <div class="row">
            <span>IVA (16%):</span>
            <span>${{ number_format($sale->iva, 2) }}</span>
        </div>
        <div class="row total-final">
            <span>TOTAL:</span>
            <span>${{ number_format($sale->total, 2) }}</span>
        </div>
        
        {{-- 
        <div class="row" style="margin-top:5px">
            <span>Efectivo:</span>
            <span>${{ number_format($sale->amount_paid, 2) }}</span>
        </div>
        <div class="row">
            <span>Cambio:</span>
            <span>${{ number_format($sale->change, 2) }}</span>
        </div>
        --}}
    </div>
        <p style="letter-spacing: 5px; font-size: 10px;">*{{ $sale->invoice_number }}*</p>
    </div>

    <button class="no-print" onclick="window.print()" style="width:100%; padding: 10px; margin-top:20px; cursor:pointer;">
        Imprimir Ticket
    </button>

</body>
</html>