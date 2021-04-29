<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->create([
            'slug' => 'taskord',
            'name' => 'Taskord',
            'avatar' => 'https://taskord.com/storage/logos/jKG9nPJJmzZvtKjxSwUxMuXM6AfLyBtw.png',
            'description' => 'Get things done socially with Taskord',
            'user_id' => 1,
            'launched' => true,
        ]);

        Product::factory()->count(99)->create();
    }
}
