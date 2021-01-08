<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@taskord.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'password' => Hash::make('admin'),
            'isStaff' => true,
        ]);

        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Test',
            'username' => 'test',
        ]);
        
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Suspended',
            'username' => 'suspended',
            'isSuspended' => true,
            'isFlagged' => true,
            'email' => 'suspended@taskord.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
        ]);
        
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Unverified',
            'username' => 'unverified',
            'email' => 'unverified@taskord.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'email_verified_at' => null,
        ]);
        
        User::factory()->count(46)->create();
    }
}
