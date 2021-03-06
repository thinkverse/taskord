<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()->count(30)->create([
            'task_id' => 1,
        ]);

        Comment::factory()->count(70)->create();
    }
}
