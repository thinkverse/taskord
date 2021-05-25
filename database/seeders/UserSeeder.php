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
        // 1
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Staff',
            'username' => 'staff',
            'email' => 'staff@taskord.com',
            'password' => Hash::make('staff'),
            'is_patron' => true,
            'is_staff' => true,
        ]);

        // 2
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Test',
            'username' => 'test',
        ]);

        // 3
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Suspended',
            'username' => 'suspended',
            'isSuspended' => true,
            'isFlagged' => true,
            'email' => 'suspended@taskord.com',
        ]);

        // 4
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Unverified',
            'username' => 'unverified',
            'email' => 'unverified@taskord.com',
            'email_verified_at' => null,
        ]);

        // 5
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Ops',
            'username' => 'ops',
        ]);

        // 6
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Ghost',
            'username' => 'ghost',
        ]);

        User::factory()->count(44)->create();
    }
}
