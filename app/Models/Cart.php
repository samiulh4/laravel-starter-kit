<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the cart
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all cart items
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Calculate and update the total amount
     */
    public function calculateTotal()
    {
        $this->total_amount = $this->items()->sum(\DB::raw('quantity * price'));
        $this->save();
        return $this->total_amount;
    }

    /**
     * Add item to cart or update quantity if exists
     */
    public function addItem(Product $product, int $quantity = 1)
    {
        $cartItem = $this->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $this->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        $this->calculateTotal();
        return $cartItem ?? $this->items()->where('product_id', $product->id)->first();
    }

    /**
     * Remove item from cart
     */
    public function removeItem($productId)
    {
        $this->items()->where('product_id', $productId)->delete();
        $this->calculateTotal();
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $this->items()->delete();
        $this->total_amount = 0;
        $this->save();
    }

    /**
     * Get item count
     */
    public function getItemCount()
    {
        return $this->items()->sum('quantity');
    }
}
