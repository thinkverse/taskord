<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductUpdate;

class ProductUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductUpdate::factory()->count(500)->create();
    }
}
