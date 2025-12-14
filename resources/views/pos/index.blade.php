<x-pos-layout>
    <div class="h-full flex flex-col md:flex-row bg-gray-100 overflow-hidden">
        
        <!-- SECCIÓN IZQUIERDA: PRODUCTOS -->
        <div class="w-full md:w-2/3 p-4 flex flex-col h-full">
            <!-- Buscador -->
            <div class="bg-white p-4 rounded-xl shadow-sm mb-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" id="barcodeInput" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-gray-50 text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-lg shadow-inner" placeholder="Escanea o busca producto..." autofocus>
                </div>
            </div>

            <!-- Grid -->
            <div class="flex-1 overflow-y-auto pr-2 pb-20">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4" id="productsGrid">
                    @foreach($products as $product)
                    <div onclick="addToCart({{ $product->id }})" class="bg-white rounded-xl shadow-sm hover:shadow-md cursor-pointer transition-all hover:-translate-y-1 border border-gray-100 group select-none relative flex flex-col h-full">
                        <div class="h-24 bg-blue-50 rounded-t-xl flex items-center justify-center relative overflow-hidden shrink-0">
                            <svg class="w-10 h-10 text-blue-300 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span class="absolute top-2 right-2 {{ $product->stock < 10 ? 'bg-red-500' : 'bg-green-500' }} text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $product->stock }}</span>
                        </div>
                        <div class="p-3 flex flex-col flex-1 justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight mb-1">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-500">Ref: {{ $product->barcode }}</p>
                            </div>
                            <div class="flex justify-between items-end mt-2">
                                <span class="text-lg font-extrabold text-blue-600">${{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- SECCIÓN DERECHA: TICKET -->
        <div class="w-full md:w-1/3 bg-white border-l border-gray-200 flex flex-col h-full shadow-xl z-10">
            <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center shrink-0">
                <h3 class="font-bold text-lg text-gray-700">Ticket de Venta</h3>
                <button onclick="clearCart()" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1 bg-red-50 px-3 py-1 rounded">Limpiar</button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/50" id="cartContainer">
                <div id="emptyCartMessage" class="flex flex-col items-center justify-center h-full text-gray-400 opacity-60">
                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <p class="text-sm">Carrito vacío</p>
                </div>
            </div>

            <div class="p-6 bg-white border-t border-gray-200 shrink-0">
                <div class="space-y-1 mb-4">
                    <div class="flex justify-between text-sm text-gray-600"><span>Subtotal</span><span id="subtotalLabel">$0.00</span></div>
                    <div class="flex justify-between text-sm text-gray-600"><span>IVA (16%)</span><span id="ivaLabel">$0.00</span></div>
                </div>
                <div class="flex justify-between items-end mb-6 pt-4 border-t border-dashed border-gray-200">
                    <span class="text-gray-800 font-bold">Total</span>
                    <span id="totalLabel" class="text-3xl font-extrabold text-blue-600">$0.00</span>
                </div>
                <!-- Botón que ABRIRÁ el Modal -->
                <button onclick="openPaymentModal()" id="payButton" disabled class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2 text-lg">
                    COBRAR
                </button>
            </div>
        </div>
    </div>

    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform scale-100 transition-transform">
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Finalizar Venta</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Total a Pagar -->
            <div class="bg-blue-50 p-5 rounded-xl mb-6 text-center border border-blue-100">
                <p class="text-sm text-blue-600 font-bold uppercase tracking-wider">Total a Pagar</p>
                <p id="modalTotal" class="text-4xl font-extrabold text-blue-700">$0.00</p>
            </div>

            <!-- Formulario -->
            <div class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Efectivo Recibido ($)</label>
                    <input type="number" id="paymentInput" oninput="calculateChange()" 
                           class="w-full text-3xl font-bold text-gray-800 p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none text-right transition" 
                           placeholder="0.00">
                </div>

                <div class="flex justify-between items-center p-4 bg-gray-100 rounded-xl border border-gray-200">
                    <span class="font-bold text-gray-600 text-lg">Cambio:</span>
                    <span id="changeLabel" class="text-2xl font-bold text-gray-800">$0.00</span>
                </div>
            </div>

            <!-- Botones -->
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button onclick="closeModal()" class="py-3 px-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                    Cancelar
                </button>
                <button onclick="confirmSale()" id="confirmButton" disabled 
                        class="py-3 px-4 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed shadow-lg flex justify-center items-center">
                    CONFIRMAR PAGO
                </button>
            </div>
        </div>
    </div>
    <script>
        // 1. CARGA DE DATOS
        const allProducts = @json($products);
        let cart = [];
        let currentTotal = 0;

        // 2. REFERENCIAS DOM (Pantalla Principal)
        const cartContainer = document.getElementById('cartContainer');
        const emptyMessage = document.getElementById('emptyCartMessage');
        const payButton = document.getElementById('payButton');
        const barcodeInput = document.getElementById('barcodeInput');

        // 3. REFERENCIAS DOM (Modal de Cobro)
        const paymentModal = document.getElementById('paymentModal');
        const paymentInput = document.getElementById('paymentInput');
        const modalTotalLabel = document.getElementById('modalTotal');
        const changeLabel = document.getElementById('changeLabel');
        const confirmButton = document.getElementById('confirmButton');

        // Formateador
        const formatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });

        function addToCart(productId) {
            const product = allProducts.find(p => p.id === productId);

            if (!product) { alert("Producto no encontrado"); return; }
            if (product.stock <= 0) { alert("¡Sin stock!"); return; }

            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                if (existingItem.quantity + 1 > product.stock) {
                    alert("Stock insuficiente.");
                    return;
                }
                existingItem.quantity++;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    hasIva: product.has_iva,
                    quantity: 1,
                    maxStock: product.stock
                });
            }
            renderCart();
            barcodeInput.value = '';
            barcodeInput.focus();
        }

        function renderCart() {
            cartContainer.innerHTML = ''; 

            if (cart.length === 0) {
                cartContainer.appendChild(emptyMessage);
                emptyMessage.classList.remove('hidden');
                updateTotals(0,0,0);
                payButton.disabled = true;
                return;
            }

            let subtotal = 0;
            let totalIva = 0;
            let total = 0;

            cart.forEach((item, index) => {
                const rowTotal = item.price * item.quantity;
                let itemSubtotal = rowTotal;
                let itemIva = 0;
                
                if(item.hasIva) {
                    itemSubtotal = rowTotal / 1.16;
                    itemIva = rowTotal - itemSubtotal;
                }

                subtotal += itemSubtotal;
                totalIva += itemIva;
                total += rowTotal;

                const div = document.createElement('div');
                div.className = 'flex justify-between items-center p-3 bg-white border border-gray-200 rounded-lg shadow-sm';
                div.innerHTML = `
                    <div class="flex-1 overflow-hidden mr-2">
                        <h4 class="font-bold text-gray-800 text-sm truncate">${item.name}</h4>
                        <div class="text-xs text-gray-500">${formatter.format(item.price)} x ${item.quantity}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-blue-600 text-sm">${formatter.format(rowTotal)}</span>
                        <div class="flex flex-col gap-1">
                            <button onclick="updateQty(${index}, 1)" class="w-6 h-6 bg-blue-50 text-blue-600 border border-blue-200 rounded text-xs hover:bg-blue-100">+</button>
                            <button onclick="updateQty(${index}, -1)" class="w-6 h-6 bg-gray-50 text-gray-600 border border-gray-200 rounded text-xs hover:bg-gray-100">-</button>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-gray-400 hover:text-red-500 ml-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                `;
                cartContainer.appendChild(div);
            });

            updateTotals(subtotal, totalIva, total);
            payButton.disabled = false;
        }

        function updateTotals(sub, iva, tot) {
            currentTotal = tot; // Guardamos el total numérico globalmente
            document.getElementById('subtotalLabel').innerText = formatter.format(sub);
            document.getElementById('ivaLabel').innerText = formatter.format(iva);
            document.getElementById('totalLabel').innerText = formatter.format(tot);
        }

        function updateQty(index, change) {
            const item = cart[index];
            if (change > 0 && item.quantity >= item.maxStock) {
                alert("Stock máximo alcanzado");
                return;
            }
            if (item.quantity + change > 0) {
                item.quantity += change;
                renderCart();
            } else {
                if(confirm("¿Eliminar producto?")) removeFromCart(index);
            }
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            renderCart();
            barcodeInput.focus();
        }

        function clearCart() {
            if(confirm('¿Vaciar ticket?')) {
                cart = [];
                renderCart();
            }
            barcodeInput.focus();
        }

        function openPaymentModal() {
            if(cart.length === 0) return;

            // Preparamos el modal
            modalTotalLabel.innerText = formatter.format(currentTotal);
            paymentInput.value = ''; 
            changeLabel.innerText = formatter.format(0);
            changeLabel.classList.remove('text-red-500', 'text-green-600');
            confirmButton.disabled = true;

            // Mostramos
            paymentModal.classList.remove('hidden');
            paymentModal.classList.add('flex');
            
            // Foco al input de dinero
            setTimeout(() => paymentInput.focus(), 100);
        }

        function closeModal() {
            paymentModal.classList.add('hidden');
            paymentModal.classList.remove('flex');
            barcodeInput.focus();
        }

        // Calcular Cambio en tiempo real
        function calculateChange() {
            const payment = parseFloat(paymentInput.value) || 0;
            const change = payment - currentTotal;

            if (change >= 0) {
                changeLabel.innerText = formatter.format(change);
                changeLabel.classList.remove('text-red-500');
                changeLabel.classList.add('text-green-600');
                confirmButton.disabled = false; // ¡Alcanza para pagar!
            } else {
                changeLabel.innerText = "Falta: " + formatter.format(Math.abs(change));
                changeLabel.classList.add('text-red-500');
                changeLabel.classList.remove('text-green-600');
                confirmButton.disabled = true; // No alcanza
            }
        }

        // --- ENVIAR VENTA AL SERVIDOR ---
        function confirmSale() {
            confirmButton.disabled = true;
            confirmButton.innerText = "Procesando...";

            const saleData = {
                cart: cart,
                amount_paid: parseFloat(paymentInput.value),
                change: parseFloat(paymentInput.value) - currentTotal
            };

            fetch("{{ route('sales.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(saleData)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {

                    alert("✅ ¡Venta Exitosa! Ticket #" + data.invoice_number);
                    
                    const ticketUrl = "{{ url('/sales') }}/" + data.sale_id + "/ticket";

                    const width = 400;
                    const height = 600;
                    const left = (screen.width - width) / 2;
                    const top = (screen.height - height) / 2;
                    
                    window.open(ticketUrl, 'Ticket', `width=${width},height=${height},top=${top},left=${left}`);

                    setTimeout(() => {
                        window.location.reload();
                    }, 500);

                } else {
                    alert("Error: " + data.message);
                    confirmButton.disabled = false;
                    confirmButton.innerText = "CONFIRMAR PAGO";
                }
            });
        }

        // Teclas Rápidas
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !paymentModal.classList.contains('hidden')) {
                closeModal();
            }
            if (e.key === 'Enter' && !paymentModal.classList.contains('hidden') && !confirmButton.disabled) {
                confirmSale();
            }
            if (e.key === 'Enter' && paymentModal.classList.contains('hidden') && document.activeElement === barcodeInput) {
                const code = barcodeInput.value.trim();
                if(code) {
                    const product = allProducts.find(p => p.barcode === code);
                    if (product) addToCart(product.id);
                    else alert('Producto no encontrado');
                    barcodeInput.value = '';
                }
            }
        });

        window.onload = () => barcodeInput.focus();

    </script>
</x-pos-layout>