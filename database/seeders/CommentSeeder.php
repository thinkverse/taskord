<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('comments')->insert([
            'user_id' => 1,
            'task_id' => 1,
            'comment' => 'Hello, World!',
            'created_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
        ]);
        foreach (range(1, 500) as $index) {
            DB::table('comments')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'task_id' => $faker->numberBetween($min = 1, $max = 50),
                'comment' => $faker->sentence($nbWords = 10, $variableNbWords = true),
                'created_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            ]);
        }
    }
}
