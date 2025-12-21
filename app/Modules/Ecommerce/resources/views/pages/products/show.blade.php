@extends('layouts.web')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Image -->
            <div class="col-md-5 mb-4">
                <div class="bg-light rounded p-3">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" />
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                            <span class="text-white">No Image Available</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-7">
                <h1 class="mb-3">{{ $product->name }}</h1>

                <div class="mb-4">
                    <h3 class="text-primary">${{ number_format($product->price, 2) }}</h3>
                </div>

                <div class="mb-4">
                    @if($product->stock > 0)
                        <span class="badge bg-success">In Stock ({{ $product->stock }} available)</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </div>

                <div class="mb-4">
                    <h5>Description</h5>
                    <p class="lead">{{ $product->description ?? 'No description available' }}</p>
                </div>

                @if($product->stock > 0)
                    <form action="#" method="POST" class="product-add-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="form-control" style="max-width: 100px;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
                            Continue Shopping
                        </a>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                @endif

                <div class="mt-4">
                    <p class="text-muted">
                        <small>
                            <strong>SKU:</strong> {{ $product->id }}<br>
                            <strong>Category:</strong> Products
                        </small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Related Products</h3>
            </div>
            @foreach(\App\Models\Product::active()->inStock()->where('id', '!=', $product->id)->take(4)->get() as $relatedProduct)
                <div class="col-md-6 col-lg-3 mb-4">
                    @include('Ecommerce::components.product-card', ['product' => $relatedProduct])
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.product-add-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ url("cart.api.add") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', data.message);
                    updateCartCount();
                } else {
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'Error adding to cart');
            });
        });
    }
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
