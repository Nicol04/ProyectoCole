<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudiantesRollbackSeeder extends Seeder
{
    public function run()
    {
        // Lista de DNIs usados en el seeder original
        $dnis = [
            "78695078", "78966727", "78943552", "79062387", "20163808900058",
            "78679895", "78645183", "78591640", "78855939", "78666267", "78917802",
            "78894540", "78668000", "78842389", "79022808", "78819474", "78878057",
            "78680478", "78999018", "79066934", "78612600", "78989629", "78623225",
            "78824876", "78737866", "78818469", "78876782", "79124335", "79048048",
            "78975827", "78601571", "78799304", "78612629", "78563719"
        ];

        // Obtener los persona_ids a eliminar
        $personas = DB::table('personas')->whereIn('dni', $dnis)->get();

        foreach ($personas as $persona) {
            $user = DB::table('users')->where('persona_id', $persona->id)->first();

            if ($user) {
                // Eliminar relaciones
                DB::table('model_has_roles')->where('model_id', $user->id)->delete();
                DB::table('usuario_aulas')->where('user_id', $user->id)->delete();
                DB::table('users')->where('id', $user->id)->delete();
            }

            // Eliminar la persona
            DB::table('personas')->where('id', $persona->id)->delete();
        }

        $this->command->info('Estudiantes eliminados correctamente.');
    }
}
