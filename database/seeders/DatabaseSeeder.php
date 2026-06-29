<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\NeuroTagSeeder;
use Database\Seeders\ErrorPatternSeeder;
use Database\Seeders\ExerciseTemplateSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Catálogos base del dominio pedagógico
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            NeuroTagSeeder::class,
            ErrorPatternSeeder::class,
            ExerciseTemplateSeeder::class,
            DemoContentSeeder::class,
        ]);
    }
}
