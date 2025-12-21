<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'description' => 'Premium wireless headphones with noise cancellation and 30-hour battery life.',
                'price' => 149.99,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'USB-C Cable',
                'slug' => 'usb-c-cable',
                'description' => '6ft USB-C charging cable compatible with most modern devices.',
                'price' => 12.99,
                'stock' => 200,
                'is_active' => true,
            ],
            [
                'name' => 'Phone Case',
                'slug' => 'phone-case',
                'description' => 'Durable and stylish phone case with protective padding.',
                'price' => 24.99,
                'stock' => 150,
                'is_active' => true,
            ],
            [
                'name' => 'Screen Protector',
                'slug' => 'screen-protector',
                'description' => 'Tempered glass screen protector with installation kit.',
                'price' => 9.99,
                'stock' => 300,
                'is_active' => true,
            ],
            [
                'name' => 'Portable Charger',
                'slug' => 'portable-charger',
                'description' => '10000mAh portable power bank with fast charging support.',
                'price' => 29.99,
                'stock' => 75,
                'is_active' => true,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'slug' => 'bluetooth-speaker',
                'description' => 'Waterproof portable Bluetooth speaker with 12-hour battery.',
                'price' => 59.99,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Mouse',
                'slug' => 'wireless-mouse',
                'description' => 'Ergonomic wireless mouse with precision tracking.',
                'price' => 34.99,
                'stock' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Keyboard Stand',
                'slug' => 'keyboard-stand',
                'description' => 'Adjustable keyboard stand for better ergonomics.',
                'price' => 19.99,
                'stock' => 80,
                'is_active' => true,
            ],
            [
                'name' => 'Laptop Stand',
                'slug' => 'laptop-stand',
                'description' => 'Foldable aluminum laptop stand for improved viewing angle.',
                'price' => 39.99,
                'stock' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'USB Hub',
                'slug' => 'usb-hub',
                'description' => '7-port USB hub with independent switches for each port.',
                'price' => 44.99,
                'stock' => 45,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
