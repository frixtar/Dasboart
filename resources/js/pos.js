let allProducts = [];
let cart = [];
let currentTotal = 0;

const cartContainer = document.getElementById('cartContainer');
const emptyMessage = document.getElementById('emptyCartMessage');
const payButton = document.getElementById('payButton');
const barcodeInput = document.getElementById('barcodeInput');
const paymentModal = document.getElementById('paymentModal');
const paymentInput = document.getElementById('paymentInput');
const modalTotalLabel = document.getElementById('modalTotal');
const changeLabel = document.getElementById('changeLabel');
const confirmButton = document.getElementById('confirmButton');
const noResultsMessage = document.getElementById('noResults');

const formatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
document.addEventListener('DOMContentLoaded', () => {
    if (window.posConfig) {
        allProducts = window.posConfig.products;
        barcodeInput.focus();
    }
});
window.addToCart = addToCart;
window.updateQty = updateQty;
window.removeFromCart = removeFromCart;
window.clearCart = clearCart;
window.openPaymentModal = openPaymentModal;
window.closeModal = closeModal;
window.calculateChange = calculateChange;
window.confirmSale = confirmSale;
window.filterProducts = filterProducts;

function filterProducts() {
    const term = barcodeInput.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.product-card');
    let hasVisible = false;

    cards.forEach(card => {
        const searchData = card.getAttribute('data-search');
        if (searchData.includes(term)) {
            card.style.display = 'flex';
            hasVisible = true;
        } else {
            card.style.display = 'none';
        }
    });

    if (!hasVisible && term !== '') {
        noResultsMessage.classList.remove('hidden');
    } else {
        noResultsMessage.classList.add('hidden');
    }
}
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
    filterProducts();
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
        div.className = 'flex justify-between items-center p-3 bg-white border border-gray-200 rounded-lg shadow-sm animate-fade-in';
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
    currentTotal = tot;
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
            if(cart.length === 0) return; // Si ya está vacío no hace nada
            if(confirm('¿Vaciar ticket completo?')) {
                cart = [];
                renderCart();
            }
            barcodeInput.focus();
        }

function openPaymentModal() {
    if(cart.length === 0) return;
    modalTotalLabel.innerText = formatter.format(currentTotal);
    paymentInput.value = ''; 
    changeLabel.innerText = formatter.format(0);
    changeLabel.className = "text-2xl font-bold text-gray-800"; // Reset clases
    confirmButton.disabled = true;
    paymentModal.classList.remove('hidden');
    paymentModal.classList.add('flex');
    setTimeout(() => paymentInput.focus(), 100);
}

function closeModal() {
    paymentModal.classList.add('hidden');
    paymentModal.classList.remove('flex');
    barcodeInput.focus();
}

function calculateChange() {
    const payment = parseFloat(paymentInput.value) || 0;
    const change = payment - currentTotal;

    if (change >= 0) {
        changeLabel.innerText = formatter.format(change);
        changeLabel.className = "text-2xl font-bold text-green-600";
        confirmButton.disabled = false;
    } else {
        changeLabel.innerText = "Falta: " + formatter.format(Math.abs(change));
        changeLabel.className = "text-2xl font-bold text-red-500";
        confirmButton.disabled = true;
    }
}

function confirmSale() {
    confirmButton.disabled = true;
    confirmButton.innerText = "Procesando...";

    const saleData = {
        cart: cart,
        amount_paid: parseFloat(paymentInput.value),
        change: parseFloat(paymentInput.value) - currentTotal
    };
    fetch(window.posConfig.routes.storeSale, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.posConfig.csrfToken
        },
        body: JSON.stringify(saleData)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert("!!¡Venta Exitosa! Ticket #!!" + data.invoice_number);
            const ticketUrl = window.posConfig.routes.ticketBase + "/" + data.sale_id + "/ticket";
            
            const width = 400; const height = 600;
            const left = (screen.width - width) / 2; const top = (screen.height - height) / 2;
            
            window.open(ticketUrl, 'Ticket', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left);
            
            setTimeout(() => { window.location.reload(); }, 500);
        } else {
            alert("Error: " + data.message);
            confirmButton.disabled = false;
            confirmButton.innerText = "CONFIRMAR PAGO";
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error de conexión");
        confirmButton.disabled = false;
        confirmButton.innerText = "CONFIRMAR PAGO";
    });
}

//Teclado
if(barcodeInput) {
    barcodeInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !paymentModal.classList.contains('hidden')) { 
            closeModal(); 
        }
        
        if (e.key === 'Enter') {
            if (!paymentModal.classList.contains('hidden') && !confirmButton.disabled) {
                confirmSale();
                return;
            }
            
            e.preventDefault();
            const term = this.value.toLowerCase().trim();
            if(term === "") return;

            const exactBarcode = allProducts.find(p => p.barcode === term);
            if (exactBarcode) {
                addToCart(exactBarcode.id);
                return;
            }

            const matches = allProducts.filter(p => 
                p.barcode.includes(term) || p.name.toLowerCase().includes(term)
            );

            if (matches.length === 1) {
                addToCart(matches[0].id);
            } else if (matches.length === 0) {
                alert('No se encontró: ' + term);
                this.value = '';
                filterProducts();
            }
        }
    });
}