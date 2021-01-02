<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory()->create([
            'user_id' => 1,
            'product_id' => 1,
            'task' => 'Hello, World!',
            'done' => true,
        ]);

        Task::factory()->count(499)->create();
    }
}
