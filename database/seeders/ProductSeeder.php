<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

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
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'description' => 'Get things done socially with Taskord',
            'user_id' => 1,
            'launched' => true,
        ]);

        Product::factory()->count(99)->create();
    }
}
