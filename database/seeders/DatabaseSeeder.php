<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Elektronik'],
            ['name' => 'Laptop'],
            ['name' => 'Sepatu'],
            ['name' => 'Pakain'],
        ]);

        DB::table('products')->insert([
            ['name' => 'Kulkas', 'price' => 13000000, 'category_id' => 1, 'status_stock' => 'tersedia', 'description' => 'bagus barangya'],
            ['name' => 'Asus TUF Gaming', 'price' => 40000, 'category_id' => 2, 'status_stock' => 'tersedia', 'description' => 'bagus barangya'],
            ['name' => 'nike', 'price' => 500000, 'category_id' => 3, 'status_stock' => 'tersedia', 'description' => 'bagus barangya'],
            ['name' => 'adidas', 'price' => 2000000, 'category_id' => 3, 'status_stock' => 'tersedia', 'description' => 'bagus barangya'],

        ]);
    }
}
