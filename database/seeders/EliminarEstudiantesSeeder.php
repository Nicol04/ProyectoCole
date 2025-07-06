<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EliminarEstudiantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Aulas afectadas (ajusta los ID según lo que usaste)
        $aulas = [1, 2, 3, 4];

        // Encuentra usuarios asociados a esas aulas
        $userIds = DB::table('usuario_aulas')
            ->whereIn('aula_id', $aulas)
            ->pluck('user_id');

        // Elimina roles
        DB::table('model_has_roles')
            ->whereIn('model_id', $userIds)
            ->where('model_type', 'App\\Models\\User')
            ->delete();

        // Elimina usuario_aulas
        DB::table('usuario_aulas')->whereIn('user_id', $userIds)->delete();

        // Elimina usuarios
        DB::table('users')->whereIn('id', $userIds)->delete();

        // Elimina personas
        DB::table('personas')->whereIn('id', function ($query) use ($userIds) {
            $query->select('persona_id')
                ->from('users')
                ->whereIn('id', $userIds);
        })->delete();

        echo "Registros eliminados con éxito.\n";
    }
}
