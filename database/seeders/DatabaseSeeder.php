<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create staff users
        User::create([
            'name' => 'John Attendant',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Jane Attendant',
            'email' => 'staff2@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        // Create categories
        $laptops = Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'description' => 'Desktop and portable laptops for work and gaming',
        ]);

        $accessories = Category::create([
            'name' => 'Accessories',
            'slug' => 'accessories',
            'description' => 'Computer accessories including mice, keyboards, and chargers',
        ]);

        $consoles = Category::create([
            'name' => 'Consoles',
            'slug' => 'consoles',
            'description' => 'Gaming consoles',
        ]);

        $games = Category::create([
            'name' => 'Games',
            'slug' => 'games',
            'description' => 'Video games for various platforms',
        ]);

        $gamingAccessories = Category::create([
            'name' => 'Gaming Accessories',
            'slug' => 'gaming-accessories',
            'description' => 'Headsets, controllers, and gaming peripherals',
        ]);

        // Create sample products
        // Laptops
        Product::create([
            'category_id' => $laptops->id,
            'name' => 'Dell XPS 13',
            'brand' => 'Dell',
            'model' => 'XPS 13 Plus',
            'sku' => 'DELL-XPS13-001',
            'serial_number' => 'DL123456789',
            'cost_price' => 1200,
            'selling_price' => 1500,
            'quantity_in_stock' => 8,
            'low_stock_threshold' => 3,
            'supplier' => 'Dell Global Supplies',
            'description' => 'Ultra-portable laptop with 13-inch FHD display',
        ]);

        Product::create([
            'category_id' => $laptops->id,
            'name' => 'MacBook Air M2',
            'brand' => 'Apple',
            'model' => 'M2 13-inch',
            'sku' => 'APPLE-MBA-M2',
            'serial_number' => 'AP987654321',
            'cost_price' => 1800,
            'selling_price' => 2200,
            'quantity_in_stock' => 5,
            'low_stock_threshold' => 2,
            'supplier' => 'Apple Authorized Distributor',
            'description' => 'Premium laptop with Apple M2 chip',
        ]);

        Product::create([
            'category_id' => $laptops->id,
            'name' => 'Lenovo ThinkPad',
            'brand' => 'Lenovo',
            'model' => 'E15',
            'sku' => 'LENOVO-TP-E15',
            'cost_price' => 950,
            'selling_price' => 1200,
            'quantity_in_stock' => 2,
            'low_stock_threshold' => 3,
            'supplier' => 'Lenovo Business Solutions',
            'description' => 'Business laptop with long battery life',
        ]);

        // Accessories
        Product::create([
            'category_id' => $accessories->id,
            'name' => 'Wireless Mouse',
            'brand' => 'Logitech',
            'model' => 'MX Master 3',
            'sku' => 'LOGI-MX3-001',
            'cost_price' => 60,
            'selling_price' => 90,
            'quantity_in_stock' => 25,
            'low_stock_threshold' => 5,
            'supplier' => 'Logitech Direct',
            'description' => 'Precision wireless mouse for productivity',
        ]);

        Product::create([
            'category_id' => $accessories->id,
            'name' => 'Mechanical Keyboard',
            'brand' => 'Corsair',
            'model' => 'K95 RGB',
            'sku' => 'CORS-K95-RGB',
            'cost_price' => 120,
            'selling_price' => 180,
            'quantity_in_stock' => 15,
            'low_stock_threshold' => 4,
            'supplier' => 'Corsair Gaming',
            'description' => 'Premium mechanical keyboard with RGB lighting',
        ]);

        // Gaming Consoles
        Product::create([
            'category_id' => $consoles->id,
            'name' => 'PlayStation 5',
            'brand' => 'Sony',
            'model' => 'PS5 Standard Edition',
            'sku' => 'SONY-PS5-STD',
            'serial_number' => 'PS5-12345678',
            'cost_price' => 450,
            'selling_price' => 599,
            'quantity_in_stock' => 4,
            'low_stock_threshold' => 2,
            'supplier' => 'Sony Interactive Entertainment',
            'description' => 'Latest generation gaming console',
        ]);

        Product::create([
            'category_id' => $consoles->id,
            'name' => 'Xbox Series X',
            'brand' => 'Microsoft',
            'model' => 'Series X',
            'sku' => 'MS-XBOX-SX',
            'serial_number' => 'XB-87654321',
            'cost_price' => 450,
            'selling_price' => 599,
            'quantity_in_stock' => 3,
            'low_stock_threshold' => 2,
            'supplier' => 'Microsoft Gaming',
            'description' => '4K gaming console with fast loading',
        ]);

        // Games
        Product::create([
            'category_id' => $games->id,
            'name' => 'Elden Ring',
            'brand' => 'FromSoftware',
            'model' => 'PS5 Version',
            'sku' => 'ELDEN-PS5-001',
            'cost_price' => 45,
            'selling_price' => 59.99,
            'quantity_in_stock' => 12,
            'low_stock_threshold' => 3,
            'supplier' => 'Bandai Namco Entertainment',
            'description' => 'Award-winning action RPG game',
        ]);

        // Gaming Accessories
        Product::create([
            'category_id' => $gamingAccessories->id,
            'name' => 'Gaming Headset',
            'brand' => 'HyperX',
            'model' => 'Cloud Flight',
            'sku' => 'HYPER-FLIGHT',
            'cost_price' => 80,
            'selling_price' => 120,
            'quantity_in_stock' => 18,
            'low_stock_threshold' => 4,
            'supplier' => 'HyperX Gaming',
            'description' => 'Wireless gaming headset with surround sound',
        ]);

        Product::create([
            'category_id' => $gamingAccessories->id,
            'name' => 'Game Controller',
            'brand' => 'Sony',
            'model' => 'DualSense',
            'sku' => 'SONY-DS5-CTRL',
            'cost_price' => 50,
            'selling_price' => 75,
            'quantity_in_stock' => 20,
            'low_stock_threshold' => 5,
            'supplier' => 'Sony Interactive Entertainment',
            'description' => 'Next-gen controller with haptic feedback',
        ]);
    }
}
