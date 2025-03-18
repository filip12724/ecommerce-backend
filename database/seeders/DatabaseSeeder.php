<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        

        User::factory()->create([
            'name' => 'Filip',
            'email' => 'filip@example.com',
        ]);

        $categories=Category::factory()->count(15)->create();

        Product::factory(50)->create()->each(function ($product) use ($categories) {
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }); 

    }
}
