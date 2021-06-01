<?php

namespace Database\Seeders;

use App\Models\Milestone;
use Illuminate\Database\Seeder;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Milestone::factory()->create([
            'user_id' => 1,
        ]);

        Milestone::factory()->count(29)->create();
    }
}
