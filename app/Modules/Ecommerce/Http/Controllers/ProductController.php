<?php

namespace App\Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Get all products
     */
    public function index()
    {
        $products = Product::active()->inStock()->paginate(12);
        return view('Ecommerce::pages.products.index', compact('products'));
    }

    /**
     * Show product details
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('Ecommerce::pages.products.show', compact('product'));
    }

    /**
     * Get products via API
     */
    public function getProducts()
    {
        $products = Product::active()->inStock()->get();
        return response()->json($products);
    }
}
