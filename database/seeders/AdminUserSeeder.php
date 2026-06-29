<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Teacher Demo User
        |--------------------------------------------------------------------------
        */

        $teacher = User::updateOrCreate(
            [
                'email' => 'claramoras@hotmail.com',
            ],
            [
                'name' => 'Clara Moras',
                'password' => Hash::make('Password123'),
                'email_verified_at' => now(),
            ]
        );

        $teacher->syncRoles(['teacher']);

        /*
        |--------------------------------------------------------------------------
        | Student Demo User
        |--------------------------------------------------------------------------
        */

        $student = User::updateOrCreate(
            [
                'email' => 'student@example.com',
            ],
            [
                'name' => 'Demo Student',
                'password' => Hash::make('Password123'),
                'email_verified_at' => now(),
            ]
        );

        $student->syncRoles(['student']);

        /*
        |--------------------------------------------------------------------------
        | Super Admin Demo User
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            [
                'email' => 'admin@eymont.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Password123'),
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles(['super-admin']);
    }
}
