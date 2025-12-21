@extends('layouts.web')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1>Shopping Cart</h1>
            </div>
        </div>

        @if($cart->items->count() > 0)
            <div class="row">
                <!-- Cart Items -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart->items as $item)
                                            <tr class="cart-item" data-product-id="{{ $item->product_id }}">
                                                <td>
                                                    <a href="{{ route('products.show', $item->product->slug) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>
                                                    <div class="input-group" style="width: 100px;">
                                                        <input type="number" class="form-control quantity-input" value="{{ $item->quantity }}" min="1" data-cart-item-id="{{ $item->id }}">
                                                    </div>
                                                </td>
                                                <td class="subtotal">${{ number_format($item->getSubtotal(), 2) }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger remove-item-btn" data-product-id="{{ $item->product_id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    Continue Shopping
                                </a>
                                <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear entire cart?')">
                                        Clear Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="col-md-4">
                    <div class="card sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($cart->total_amount, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>Free</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <span>$0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong>${{ number_format($cart->total_amount, 2) }}</strong>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100 btn-lg" disabled>
                                Proceed to Checkout
                            </button>

                            <small class="text-muted d-block mt-3">
                                {{ $cart->getItemCount() }} item(s) in cart
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Your Cart is Empty</h4>
                <p>You haven't added any products to your cart yet.</p>
                <hr>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const cartItemId = this.dataset.cartItemId;
            const newQuantity = parseInt(this.value);

            if (newQuantity < 1) {
                this.value = 1;
                return;
            }

            // Here you would make an AJAX request to update the quantity
            console.log('Update cart item', cartItemId, 'to quantity', newQuantity);
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            if (confirm('Remove this item from cart?')) {
                fetch(`/cart/api/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-product-id="${productId}"]`).remove();
                        showToast('success', data.message);
                        updateCartCount();
                        // Reload page after a delay
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Error removing item');
                });
            }
        });
    });
});

function showToast(type, message) {
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    const toastContainer = document.querySelector('.toast-container') || document.body;
    const toastElement = document.createElement('div');
    toastElement.innerHTML = toastHtml;
    toastContainer.appendChild(toastElement.firstElementChild);
    
    const toast = new bootstrap.Toast(toastElement.firstElementChild);
    toast.show();
    
    setTimeout(() => {
        toastElement.firstElementChild.remove();
    }, 3000);
}

function updateCartCount() {
    fetch('{{ route("cart.api.count") }}')
        .then(response => response.json())
        .then(data => {
            const cartBadge = document.querySelector('.cart-count');
            if (cartBadge) {
                cartBadge.textContent = data.count;
            }
        });
}
</script>
@endpush
@endsection
