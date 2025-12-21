@extends('layouts.web')

@section('style')
    <style>
        main {
            margin-top: 80px;
        }
    </style>
      <!-- Ecommerce CSS File -->
  <link href="{{ asset('assets/web/css/ecommerce.css') }}" rel="stylesheet">
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

@section('content')
    <!-- Featured Section -->
    <section id="featuredProduct" class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold mb-4">Welcome to Our Store</h1>
                    <p class="lead mb-4">Discover amazing products at incredible prices. Shop now and enjoy free shipping on
                        orders over $50.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        Shop Now <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="featured-image-container">
                        <img src="{{ asset('assets/img/cover.jpeg') }}" alt="Featured Products"
                            class="featured-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-2">Featured Products</h2>
                    <p class="text-muted">Check out our latest and most popular products</p>
                </div>
            </div>



            @if ($products->count() > 0)
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            @include('Ecommerce::components.product-card')
                        </div>
                    @endforeach
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                            View All Products
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">No Products Available</h4>
                    <p>No featured products available at the moment. Please check back later.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="text-center">
                        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                        <h5>Free Shipping</h5>
                        <p class="text-muted">On orders over $50</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="text-center">
                        <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                        <h5>Secure Checkout</h5>
                        <p class="text-muted">100% secure payment</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="text-center">
                        <i class="fas fa-undo fa-3x text-primary mb-3"></i>
                        <h5>Easy Returns</h5>
                        <p class="text-muted">30-day return policy</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
