<?php

namespace Database\Seeders;

use App\Models\ProductUpdate;
use Illuminate\Database\Seeder;

class ProductUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductUpdate::factory()->count(100)->create();
    }
}
