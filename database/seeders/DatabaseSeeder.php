<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);
        
        User::factory()->create([
            'name' => 'Muhammad Fariez',
            'email' => 'cihils46@gmail.com',
            'username' => 'fariez04',
            'password' => bcrypt('12345'),
            'role' => 'Admin'
        ]);

        User::factory()->create([
            'name' => 'Boboiboy Topan',
            'email' => 'cihilxd46@gmail.com',
            'username' => 'rajameme',
            'password' => bcrypt('12345'),
            'role' => 'Cashier'
        ]);

    }
}
