<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'customer@example.com'],
            ['name' => 'Customer User', 'password' => Hash::make('password'), 'role' => 'customer']
        );

        $electronics = Category::firstOrCreate(
            ['slug' => 'electronics'],
            ['name' => 'Electronics', 'description' => 'Everyday devices and accessories.', 'is_active' => true]
        );

        $fashion = Category::firstOrCreate(
            ['slug' => 'fashion'],
            ['name' => 'Fashion', 'description' => 'Clothing and daily essentials.', 'is_active' => true]
        );

        Product::firstOrCreate(
            ['slug' => 'wireless-headphones'],
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Headphones',
                'description' => 'Comfortable wireless headphones with clear sound.',
                'price' => 2499,
                'stock' => 25,
                'is_active' => true,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'cotton-t-shirt'],
            [
                'category_id' => $fashion->id,
                'name' => 'Cotton T-Shirt',
                'description' => 'Soft regular-fit cotton t-shirt.',
                'price' => 599,
                'stock' => 50,
                'is_active' => true,
            ]
        );
    }
}
