<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Estudiantes5bSeeder extends Seeder
{
    public function run()
    {
        $estudiantes = [
            ["78932878", "ARRANGUI", "TAVARA", "MARIA DEL ROSARIO", "Femenino"],
            ["78578600", "BUSCAL", "PINTO", "BRIANNA SUYAY", "Femenino"],
            ["78924455", "CALLE", "ORTIZ", "YAJDIEL ABISHAI", "Masculino"],
            ["78656323", "CASTILLO", "VILCHEZ", "EMMANUEL EDUARDO", "Masculino"],
            ["78912509", "CHINGA", "CHUNGA", "MATHIAS JAMPIER", "Masculino"],
            ["79526070", "CHIRA", "GOMEZ", "DAYIRO DANIEL", "Masculino"],
            ["78921006", "CHUQUIHUANGA", "GUERRERO", "BRAYRON YAHIR", "Masculino"],
            ["78805470", "COCIOS", "PATIÑO", "ANDERSON ESMIT", "Masculino"],
            ["79043069", "CORNEJO", "HUAMAN", "MILER BRAULIO", "Masculino"],
            ["78998445", "COVEÑAS", "SOSA", "ALEXA ARIANA", "Femenino"],
            ["78788393", "CULCAS", "CHIROQUE", "AGUEDA ALEJANDRA BLAUDINA", "Femenino"],
            ["78583281", "JARA", "OBLITAS", "ORIANA GUADALUPE", "Femenino"],
            ["78987278", "JIMENEZ", "SILUPU", "DAYRON ANDRE", "Masculino"],
            ["78787277", "LACHIRA", "SANCHEZ", "FRANSHESCO D'ANGELL", "Masculino"],
            ["79021132", "MOGOLLON", "ORDINOLA", "LUIS FRANCISCO", "Masculino"],
            ["79025975", "MORE", "ACARO", "ESMERALDA", "Femenino"],
            ["78705838", "MORY", "ABAD", "NATANAEL BARZILAI", "Masculino"],
            ["78787643", "NAVARRO", "LUZON", "MIA MAGALY", "Femenino"],
            ["78644452", "PACHERRES", "CUEVA", "ELIAS ANDREW", "Masculino"],
            ["79043243", "PEÑA", "DIOSES", "MATEO EDUARDO", "Masculino"],
            ["79082975", "PUESCAS", "LIZANO", "CRISTOFER SMITH", "Masculino"],
            ["78777823", "PULACHE", "LIZA", "LIAM JOSE ALEXANDER", "Masculino"],
            ["78909992", "RAMIREZ", "GUERRERO", "DANIEL ANDRÉ", "Masculino"],
            ["78555432", "RETO", "ZAPATA", "ALEXANDRA GERALDINE", "Femenino"],
            ["78616194", "REYES", "CHIROQUE", "BRIANNA DEL MILAGRO", "Femenino"],
            ["78814556", "ROMERO", "CORREA", "JOSE RICARDO", "Masculino"],
            ["78636397", "RONDOY", "CAMPOVERDE", "AITANA UZIEL", "Femenino"],
            ["78636380", "RONDOY", "CAMPOVERDE", "PATRICK GAEL", "Masculino"],
            ["78696309", "RUESTA", "ANASTACIO", "ORLANDO DAVID", "Masculino"],
            ["78882112", "SALVADOR", "PEÑA", "LLIAM ISRAEL", "Masculino"],
            ["78904854", "SANCHEZ", "RODRIGUEZ", "JEICO JAEL", "Masculino"],
            ["78932808", "SEMINARIO", "RIVERA", "CARLOS DAVID", "Masculino"],
            ["78665783", "SILVA", "SOJO", "STHEFANNO ALEXANDRO", "Masculino"],
            ["78837758", "SULLON", "TORRES", "LIAN GUSTAVO", "Masculino"],
            ["78845828", "TOCTO", "GUERRERO", "THIAGO VLADIMIR", "Masculino"],
            ["78610676", "WONG", "ESTRADA", "HEIDY LIZET", "Femenino"],
        ];

        foreach ($estudiantes as [$dni, $ap1, $ap2, $nombres, $genero]) {
            // Capitalizar datos
            $ap1Capital = ucfirst(strtolower($ap1));
            $ap2Capital = ucfirst(strtolower($ap2));
            $nombresCapital = ucwords(strtolower($nombres));
            $primerNombre = explode(' ', $nombresCapital)[0] ?? '';

            // Nombre de usuario: PrimerApellido + 1ra letra nombre + 1ra letra 2do apellido
            $username = $ap1Capital . strtolower(($primerNombre[0] ?? '') . ($ap2Capital[0] ?? ''));

            // Avatar por género
            $avatar = $genero === 'Masculino' ? 2 : 3;

            // Insertar en personas
            $persona_id = DB::table('personas')->insertGetId([
                'nombre' => $nombresCapital,
                'apellido' => "$ap1Capital $ap2Capital",
                'dni' => $dni,
                'genero' => $genero,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insertar en users
            $user_id = DB::table('users')->insertGetId([
                'name' => $username,
                'password' => Hash::make($dni),
                'persona_id' => $persona_id,
                'avatar_usuario_id' => $avatar,
                'estado' => 'Activo',
                'password_plano' => encrypt($dni),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Relación usuario-aula
            DB::table('usuario_aulas')->insert([
                'user_id' => $user_id,
                'aula_id' => 2, // Aula 5B
                'año_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Rol estudiante
            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => $user_id,
            ]);
        }
    }
}
