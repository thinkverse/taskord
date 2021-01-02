<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        Question::factory()->count(100)->create();
    }
}
