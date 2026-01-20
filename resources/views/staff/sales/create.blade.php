@extends('layouts.app')

@section('title', 'Record New Sale')

@section('content')
<h1 class="page-title">
    <i class="bi bi-plus-square"></i> Record New Sale
</h1>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Products</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="productSearch" class="form-control" placeholder="Search products by name, brand, or SKU...">
                </div>

                <div id="productList" class="row">
                    @foreach($products as $product)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 product-card" data-product-id="{{ $product->id }}" style="cursor: pointer; transition: all 0.3s ease; border: 2px solid transparent;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $product->name }}</h6>
                                    <p class="card-text mb-1">
                                        <small class="text-muted">{{ $product->brand }} - {{ $product->model }}</small>
                                    </p>
                                    <p class="card-text mb-2">
                                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block">Price</small>
                                            <strong>₵{{ number_format($product->selling_price, 2) }}</strong>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Stock</small>
                                            <span class="badge {{ $product->quantity_in_stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->quantity_in_stock }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        @php
            $storeRoute = auth()->user()->isAdmin() ? 'admin.sales.store' : 'staff.sales.store';
        @endphp
        <form method="POST" action="{{ route($storeRoute) }}" id="saleForm">
            @csrf

            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Sale Items</h5>
                </div>
                <div class="card-body">
                    <div id="cartItems">
                        <div class="text-center text-muted py-4">
                            <p>No items added yet</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end"><span id="subtotal">₵0.00</span></td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td class="text-end"><strong><span id="total">₵0.00</span></strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Payment Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method *</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                            <option value="">Select payment method</option>
                            <option value="Cash">Cash</option>
                            <option value="Mobile Money">Mobile Money</option>
                            <option value="Card">Card</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="transaction_ref" class="form-label">Transaction Reference (Optional)</label>
                        <input type="text" class="form-control" id="transaction_ref" name="transaction_ref" placeholder="e.g., Mobile Money Ref #">
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-lg" id="submitBtn" disabled>
                        <i class="bi bi-check-circle"></i> Complete Sale
                    </button>

                    <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('extra-js')
<script>
    let cart = [];
    const products = {!! json_encode($products->toArray()) !!};

    // Search functionality
    document.getElementById('productSearch').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });

    // Add product to cart
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            const productId = parseInt(this.dataset.productId);
            const product = products.find(p => p.id === productId);

            if (!product || product.quantity_in_stock <= 0) {
                alert('This product is out of stock');
                return;
            }

            let cartItem = cart.find(item => item.product_id === productId);
            if (cartItem) {
                if (cartItem.quantity < product.quantity_in_stock) {
                    cartItem.quantity++;
                } else {
                    alert('Cannot exceed available stock');
                }
            } else {
                cart.push({
                    product_id: productId,
                    quantity: 1
                });
            }

            updateCart();
            updateProductHighlight();
        });
    });

    function updateProductHighlight() {
        document.querySelectorAll('.product-card').forEach(card => {
            const productId = parseInt(card.dataset.productId);
            const isInCart = cart.some(item => item.product_id === productId);

            if (isInCart) {
                card.style.borderColor = '#28a745';
                card.style.backgroundColor = '#f0fff4';
                card.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.25)';
            } else {
                card.style.borderColor = 'transparent';
                card.style.backgroundColor = '';
                card.style.boxShadow = '';
            }
        });
    }

    function updateCart() {
        const cartItemsDiv = document.getElementById('cartItems');

        if (cart.length === 0) {
            cartItemsDiv.innerHTML = '<div class="text-center text-muted py-4"><p>No items added yet</p></div>';
            document.getElementById('subtotal').textContent = '₵0.00';
            document.getElementById('total').textContent = '₵0.00';
            document.getElementById('submitBtn').disabled = true;
            return;
        }

        let html = '<table class="table table-sm mb-0">';
        let total = 0;

        cart.forEach((item, index) => {
            const product = products.find(p => p.id === item.product_id);
            const itemTotal = product.selling_price * item.quantity;
            total += itemTotal;

            html += `
                <tr>
                    <td>
                        <div class="small font-weight-bold">${product.name}</div>
                        <small class="text-muted">${product.brand}</small>
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty(${index})">−</button>
                            <input type="text" class="form-control text-center" style="width: 40px;" value="${item.quantity}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQty(${index}, ${product.quantity_in_stock})">+</button>
                        </div>
                    </td>
                    <td class="text-end">
                        ₵${(product.selling_price * item.quantity).toFixed(2)}
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-danger" type="button" onclick="removeItem(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        html += '</table>';
        cartItemsDiv.innerHTML = html;
        document.getElementById('subtotal').textContent = '₵' + total.toFixed(2);
        document.getElementById('total').textContent = '₵' + total.toFixed(2);
        document.getElementById('submitBtn').disabled = false;
    }

    function increaseQty(index, maxStock) {
        if (cart[index].quantity < maxStock) {
            cart[index].quantity++;
            updateCart();
        } else {
            alert('Cannot exceed available stock');
        }
    }

    function decreaseQty(index) {
        if (cart[index].quantity > 1) {
            cart[index].quantity--;
        } else {
            removeItem(index);
        }
        updateCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        updateCart();
        updateProductHighlight();
    }

    // Form submission - prepare hidden fields for items
    document.getElementById('saleForm').addEventListener('submit', function(e) {
        if (cart.length === 0) {
            e.preventDefault();
            alert('Please add items to the cart before completing the sale');
            return;
        }

        // Create hidden inputs for each cart item
        const itemsHtml = cart.map((item, index) => {
            return `
                <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
            `;
        }).join('');

        this.insertAdjacentHTML('beforeend', itemsHtml);
    });
</script>
@endsection
