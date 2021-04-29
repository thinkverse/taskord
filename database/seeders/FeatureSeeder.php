<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::factory()->create([
            'name' => 'Meetups',
            'slug' => 'meetups',
            'description' => 'User can host meetups in Taskord',
        ]);

        Feature::factory()->create([
            'name' => 'Help menu',
            'slug' => 'help_menu',
            'description' => 'Help menu in navbar dropdown',
        ]);
    }
}
