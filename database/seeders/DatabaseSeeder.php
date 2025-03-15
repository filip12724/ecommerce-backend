<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        Product::factory()->count(50)->create(); 

        User::factory()->create([
            'name' => 'Filip',
            'email' => 'filip@example.com',
        ]);
    }
}
