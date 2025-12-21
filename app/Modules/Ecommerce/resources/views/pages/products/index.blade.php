@extends('layouts.web')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-2">Our Products</h1>
                <p class="text-muted">Discover our amazing collection of products</p>
            </div>
        </div>

        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        @include('Ecommerce::components.product-card')
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">No Products Available</h4>
                <p>There are currently no products available. Please check back later.</p>
            </div>
        @endif
    </div>
</section>

<style>
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
    }

    .toast {
        min-width: 300px;
    }
</style>
@endsection
