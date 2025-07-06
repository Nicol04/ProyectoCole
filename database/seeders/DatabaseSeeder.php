<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Estudiantes5aSeeder as SeedersEstudiantes5aSeeder;
use Database\Seeders\Estudiantes5bSeeder as SeedersEstudiantes5bSeeder;
use Database\Seeders\Estudiantes5cSeeder as SeedersEstudiantes5cSeeder;
use Database\Seeders\Estudiantes5dSeeder as SeedersEstudiantes5dSeeder;
use EstudiantesSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // AvatarUsuariosSeeder::class,
            // PersonasSeeder::class,
            // UsersSeeder::class,
            // AulasSeeder::class,
            // UsuarioAulaSeeder::class,
            // RolesSeeder::class,
            // PermisosSeeder::class,
            // RoleUserSeeder::class,
            SeedersEstudiantes5aSeeder::class,
            SeedersEstudiantes5bSeeder::class,
            SeedersEstudiantes5cSeeder::class,
            SeedersEstudiantes5dSeeder::class,
        ]);
    }
}
