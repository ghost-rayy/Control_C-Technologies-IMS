@extends('layouts.app')

@section('title', 'Record Sale | Inventory Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-11">
        <div class="mb-4">
            <h1 class="page-title-new mb-1">
                <i class="bi bi-cart-plus-fill text-primary"></i> Record New Sale
            </h1>
            <p class="text-muted small">Search for products and add them to the sale summary</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card recent-sales-card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">
                            <i class="bi bi-box-seam me-2 text-primary"></i> Product Selection
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="saleForm" method="POST" action="{{ route('admin.sales.store') }}">
                            @csrf

                            <!-- Product Selection -->
                            <div class="mb-4">
                                <label for="productSearch" class="form-label-new">Search Products</label>
                                <div class="input-group-new">
                                    <input type="text" id="productSearch" class="form-control" placeholder="Search by product name, brand or model...">
                                    <span class="search-icon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                                <div id="productList" class="search-results-dropdown" style="display: none;">
                                    <!-- Products will be loaded here -->
                                </div>
                            </div>

                            <!-- Selected Items -->
                            <div class="mb-4">
                                <h6 class="form-label-new mb-3">Selected Items</h6>
                                <div class="table-responsive border rounded-3">
                                    <table class="table recent-sales-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Unit Price</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody">
                                            <!-- Items will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="paymentMethod" class="form-label-new">Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="paymentMethod" class="form-select" required>
                                        <option value="">Select payment method...</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Mobile Money">Mobile Money</option>
                                        <option value="Card">Card</option>
                                    </select>
                                </div>
         
                                <div class="col-md-6 mb-4">
                                    <label for="transactionRef" class="form-label-new">Transaction Reference <span class="text-muted fw-normal">(Optional)</span></label>
                                    <input type="text" name="transaction_ref" id="transactionRef" class="form-control" placeholder="e.g., M123456">
                                </div>
                            </div>

                            <input type="hidden" id="itemsInput" name="items" value="[]">

                            <div class="d-flex gap-2 pt-4 border-top">
                                <button type="submit" class="btn btn-save-new px-4" id="submitBtn" disabled>
                                    <i class="bi bi-check-circle-fill"></i> Complete Sale
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel-new px-4">
                                    <i class="bi bi-x-lg"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="col-lg-4">
                <div class="card recent-sales-card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-turquoise text-white py-3">
                        <h6 class="mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-journal-text"></i> Sale Summary
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="summary-line">
                            <span class="label">Items:</span>
                            <span class="value" id="itemCount">0</span>
                        </div>
                        
                        <div class="summary-line">
                            <span class="label">Subtotal:</span>
                            <span class="value" id="subtotal">₵ 0.00</span>
                        </div>
     
                        <hr class="my-3 opacity-10">
     
                        <div class="summary-line secondary">
                            <span class="label">Cost:</span>
                            <span class="value" id="totalCost">₵ 0.00</span>
                        </div>
                        <div class="summary-line secondary">
                            <span class="label">Profit:</span>
                            <span class="value text-success" id="totalProfit">₵ 0.00</span>
                        </div>
     
                        <hr class="my-4 opacity-10">
     
                        <div class="summary-line total">
                            <span class="label">Total Amount:</span>
                            <span class="value text-primary" id="totalAmount">₵ 0.00</span>
                        </div>
     
                        <!-- Tip Box -->
                        <div class="tip-box-blue mt-4">
                            <div class="d-flex gap-3">
                                <i class="bi bi-info-circle-fill text-primary" style="font-size: 1.25rem;"></i>
                                <div>
                                    <h6 class="mb-1" style="font-weight: 700; color: #1e293b; font-size: 14px;">Quick Tip</h6>
                                    <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.5;">Search and add products to start recording your sale. All changes are calculated in real-time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const products = @json($products);
let saleItems = [];

// Search and filter products
document.getElementById('productSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const productList = document.getElementById('productList');

    if (searchTerm.length < 1) {
        productList.style.display = 'none';
        return;
    }

    const filtered = products.filter(p =>
        p.name.toLowerCase().includes(searchTerm) ||
        p.brand.toLowerCase().includes(searchTerm)
    );

    if (filtered.length === 0) {
        productList.innerHTML = '<div class="alert alert-warning small mb-0">No products found</div>';
    } else {
        productList.innerHTML = filtered.map(p =>
            `<div class="list-group-item list-group-item-action cursor-pointer p-2 border-bottom"
                  onclick="addItem(${p.id}, '${p.name}', ${p.selling_price}, ${p.cost_price}, ${p.quantity_in_stock})">
                <div class="d-flex justify-content-between">
                    <strong>${p.name}</strong>
                    <span class="badge bg-secondary">${p.quantity_in_stock} in stock</span>
                </div>
                <small class="text-muted">${p.brand} | GHS ${parseFloat(p.selling_price).toFixed(2)}</small>
            </div>`
        ).join('');
    }

    productList.style.display = 'block';
});

function addItem(productId, name, price, cost, stock) {
    let item = saleItems.find(i => i.product_id === productId);

    if (item) {
        item.quantity = Math.min(item.quantity + 1, stock);
    } else {
        saleItems.push({
            product_id: productId,
            product_name: name,
            unit_price: price,
            unit_cost: cost,
            quantity: 1,
            max_stock: stock
        });
    }

    document.getElementById('productSearch').value = '';
    document.getElementById('productList').style.display = 'none';
    updateDisplay();
}

function removeItem(productId) {
    saleItems = saleItems.filter(i => i.product_id !== productId);
    updateDisplay();
}

function updateQuantity(productId, quantity) {
    const item = saleItems.find(i => i.product_id === productId);
    if (item) {
        item.quantity = Math.max(1, Math.min(parseInt(quantity), item.max_stock));
        updateDisplay();
    }
}

function updateDisplay() {
    const itemsBody = document.getElementById('itemsBody');
    let subtotal = 0;
    let totalCost = 0;

    if (saleItems.length === 0) {
        itemsBody.innerHTML = `
            <tr>
                <td colspan="5" class="py-5 text-center">
                    <div class="empty-state">
                        <i class="bi bi-cart3 display-4 text-light-grey mb-3 d-block"></i>
                        <span class="text-muted">No items selected</span>
                    </div>
                </td>
            </tr>`;
        document.getElementById('submitBtn').disabled = true;
    } else {
        itemsBody.innerHTML = saleItems.map(item => {
            const itemTotal = item.unit_price * item.quantity;
            const itemCost = item.unit_cost * item.quantity;
            subtotal += itemTotal;
            totalCost += itemCost;

            return `<tr>
                <td class="product-name-sm">${item.product_name}</td>
                <td>₵${item.unit_price.toFixed(2)}</td>
                <td>
                    <input type="number" class="form-control form-control-sm qty-input"  
                           value="${item.quantity}" min="1" max="${item.max_stock}"
                           onchange="updateQuantity(${item.product_id}, this.value)">
                </td>
                <td class="sale-amount">₵${itemTotal.toFixed(2)}</td>
                <td class="text-end">
                    <button type="button" class="btn-action-view text-danger border-0"
                            onclick="removeItem(${item.product_id})">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
            </tr>`;
        }).join('');
        document.getElementById('submitBtn').disabled = false;
    }

    document.getElementById('itemCount').textContent = saleItems.reduce((sum, i) => sum + i.quantity, 0);
    document.getElementById('subtotal').textContent = '₵ ' + subtotal.toFixed(2);
    document.getElementById('totalAmount').textContent = '₵ ' + subtotal.toFixed(2);
    document.getElementById('totalCost').textContent = '₵ ' + totalCost.toFixed(2);
    document.getElementById('totalProfit').textContent = '₵ ' + (subtotal - totalCost).toFixed(2);

    // Update hidden input
    document.getElementById('itemsInput').value = JSON.stringify(
        saleItems.map(i => ({
            product_id: i.product_id,
            quantity: i.quantity
        }))
    );
}

document.getElementById('saleForm').addEventListener('submit', function(e) {
    if (saleItems.length === 0) {
        e.preventDefault();
        alert('Please add at least one item to the sale');
    }
});

// Initialize
updateDisplay();
</script>

<style>
.bg-turquoise { background-color: #06b6d4; }

.recent-sales-card {
    border-radius: 12px;
    background: #fff;
}

.form-label-new {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
    display: block;
}

.input-group-new {
    position: relative;
}

.input-group-new .form-control {
    padding-right: 40px;
    border-color: #e2e8f0;
    border-radius: 8px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.search-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.search-results-dropdown {
    position: absolute;
    width: 100%;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-top: 5px;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    max-height: 300px;
    overflow-y: auto;
    z-index: 100;
}

.recent-sales-table thead th {
    background: #f8fafc;
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1.25rem;
    border: none;
}

.product-name-sm {
    font-weight: 500;
    color: #1e293b;
}

.sale-amount {
    font-weight: 700;
    color: #0f172a;
}

.qty-input {
    width: 70px;
    border-radius: 6px;
    text-align: center;
}

.btn-action-view {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f1f5f9;
    transition: all 0.2s;
}

.btn-action-view:hover {
    background: #e2e8f0;
}

.summary-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.summary-line .label {
    color: #64748b;
    font-size: 13px;
    font-weight: 500;
}

.summary-line .value {
    color: #0f172a;
    font-size: 1.25rem;
    font-weight: 700;
}

.summary-line.secondary {
    margin-bottom: 0.5rem;
}

.summary-line.secondary .value {
    font-size: 0.95rem;
}

.summary-line.total .label {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
}

.summary-line.total .value {
    font-size: 1.5rem;
    color: #3b82f6;
}

.tip-box {
    background-color: #f0f9ff;
    border: 1px solid #e0f2fe;
    border-radius: 10px;
    padding: 1rem;
}

.text-light-grey { color: #e2e8f0; }

.btn-save-new {
    background-color: #cbd5e1;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-save-new:not(:disabled) {
    background-color: #22c55e;
}

.btn-save-new:not(:disabled):hover {
    background-color: #16a34a;
    color: #fff;
}

.btn-cancel-new {
    background-color: #475569;
    color: #fff;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
}

.btn-cancel-new:hover {
    background-color: #334155;
    color: #fff;
}
</style>
@endsection
