<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Milestone;

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
