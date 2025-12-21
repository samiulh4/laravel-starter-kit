<?php

namespace App\Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Constructor - Apply auth middleware
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * View cart
     */
    public function index()
    {
        $cart = Auth::user()->cart;

        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id(), 'total_amount' => 0]);
        }

        return view('Ecommerce::pages.cart.index', compact('cart'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is in stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available');
        }

        $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id(), 'total_amount' => 0]);
        $cart->addItem($product, $request->quantity);

        return back()->with('success', $product->name . ' added to cart');
    }

    /**
     * Add to cart via API (AJAX)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);

            // Check if product is in stock
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available',
                ], 422);
            }

            $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id(), 'total_amount' => 0]);
            $cartItem = $cart->addItem($product, $request->quantity);

            return response()->json([
                'success' => true,
                'message' => $product->name . ' added to cart',
                'cart_count' => $cart->getItemCount(),
                'total_amount' => $cart->total_amount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Auth::user()->cart->items()->findOrFail($cartItemId);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        Auth::user()->cart->calculateTotal();

        return back()->with('success', 'Cart updated');
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        $cart = Auth::user()->cart;

        if (!$cart) {
            return back()->with('error', 'Cart not found');
        }

        $cart->removeItem($productId);

        return back()->with('success', 'Item removed from cart');
    }

    /**
     * Remove item via API (AJAX)
     */
    public function removeItem(Request $request, $productId)
    {
        try {
            $cart = Auth::user()->cart;

            if (!$cart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart not found',
                ], 404);
            }

            $cart->removeItem($productId);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $cart->getItemCount(),
                'total_amount' => $cart->total_amount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $cart = Auth::user()->cart;

        if ($cart) {
            $cart->clear();
        }

        return back()->with('success', 'Cart cleared');
    }

    /**
     * Get cart count (AJAX)
     */
    public function getCount()
    {
        $cart = Auth::user()->cart;
        $count = $cart ? $cart->getItemCount() : 0;

        return response()->json([
            'count' => $count,
        ]);
    }
}
