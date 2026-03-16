<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Monitors', 'slug' => 'monitors'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ];

        foreach ($categories as $cat) {
            $category = Category::create($cat);

            if ($cat['name'] === 'Laptops') {
                Product::create([
                    'name' => 'ProBook 15 G8',
                    'description' => 'High performance laptop for business professionals with 16GB RAM and 512GB SSD.',
                    'price' => 1299.99,
                    'stock_quantity' => 10,
                    'category_id' => $category->id,
                ]);
                Product::create([
                    'name' => 'AirBook Thin',
                    'description' => 'Ultra-thin and lightweight laptop for students and travelers.',
                    'price' => 999.00,
                    'stock_quantity' => 20,
                    'category_id' => $category->id,
                ]);
            } elseif ($cat['name'] === 'Monitors') {
                Product::create([
                    'name' => 'UltraWide 34"',
                    'description' => '34-inch curved ultrawide monitor with 144Hz refresh rate.',
                    'price' => 549.99,
                    'stock_quantity' => 15,
                    'category_id' => $category->id,
                ]);
            } else {
                Product::create([
                    'name' => 'Mechanical Keyboard',
                    'description' => 'RGB backlit mechanical keyboard with blue switches.',
                    'price' => 89.99,
                    'stock_quantity' => 50,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
