<div class="card h-100 shadow-sm hover-shadow-lg transition">
    <div class="position-relative overflow-hidden" style="height: 250px;">
        @if($product->image)
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="card-img-top h-100 object-fit-cover" />
        @else
             <img src="{{ asset('assets/img/default.jpg') }}" alt="{{ $product->name }}" class="card-img-top h-100 object-fit-cover" />
        @endif
        
        @if($product->stock > 0)
            <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
        @else
            <span class="badge bg-danger position-absolute top-0 end-0 m-2">Out of Stock</span>
        @endif
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
        
        <p class="card-text text-muted small" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
            {{ $product->description ?? 'No description available' }}
        </p>

        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="h5 mb-0 text-primary">${{ number_format($product->price, 2) }}</span>
                <small class="text-muted">{{ $product->stock }} in stock</small>
            </div>

            @if($product->stock > 0)
                <form action="{{ route('cart.api.add') }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="input-group input-group-sm mb-2">
                        <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="form-control">
                        <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn" data-product-name="{{ $product->name }}">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </form>
            @else
                <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
            @endif

            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .hover-shadow-lg {
        transition: box-shadow 0.3s ease;
    }

    .add-to-cart-btn {
        white-space: nowrap;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.add-to-cart-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const productName = this.querySelector('.add-to-cart-btn').dataset.productName;
            const formData = new FormData(this);
            
            fetch('{{ route("cart.api.add") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success toast
                    showToast('success', data.message);
                    // Update cart count
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
