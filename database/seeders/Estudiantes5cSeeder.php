<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class Estudiantes5cSeeder extends Seeder
{
    public function run()
    {
        $estudiantes = [
            ["78902416", "AMAYA", "HERRERA", "KEISHA HARUMI ANJELY", "Femenino"],
            ["78723864", "AZCARATE", "AMAYA", "ROSITA NICOLE", "Femenino"],
            ["78884700", "BENITES", "FARFAN", "ANTONELLA VALESKA", "Femenino"],
            ["78387158", "CAMACHO", "YOVERA", "YOURLADY NICOLE", "Femenino"],
            ["78704497", "CAMIZAN", "SAAVEDRA", "LUCIANA DALEZKA", "Femenino"],
            ["78662403", "CASTILLO", "CARREÑO", "ARIELA SARAÍ", "Femenino"],
            ["79043938", "CASTILLO", "SANCHEZ", "VICTOR HUGO", "Masculino"],
            ["79702825", "DIAZ", "CASTILLO", "ROSA DE GUADALUPE", "Femenino"],
            ["78532804", "ESPINOZA", "HERRERA", "ALBERT STEFANO GERRARD", "Masculino"],
            ["79042936", "FIESTAS", "YEN", "NAHUM ABDIEL", "Masculino"],
            ["77772590", "FLORES", "MENDOZA", "DIEGO FABRIZIO", "Masculino"],
            ["78294603", "GOYCOCHEA", "GARRIDO", "KALED ALEXANDER", "Masculino"],
            ["78874972", "GUTIERREZ", "VILLEGAS", "ELIAS FABRICIO", "Masculino"],
            ["78820098", "LACHIRA", "NAVARRO", "IAN DANIEL", "Masculino"],
            ["78820077", "LACHIRA", "NAVARRO", "THIAGO DANIEL", "Masculino"],
            ["78563023", "LUEY", "MARTINEZ", "EFRAIN MATIAS", "Masculino"],
            ["78631078", "MOSCOL", "GONZALES", "SNAYDER DAVID", "Masculino"],
            ["78599868", "MOSCOL", "LLACSAHUACHE", "RAFAEL IGNACIO", "Masculino"],
            ["79076155", "NOLE", "SILUPU", "DULCE BLANCA VALESKA", "Femenino"],
            ["78841526", "OROZCO", "CORREA", "SEBASTIAN EDILSON", "Masculino"],
            ["78683382", "PACHERRES", "GONZALES", "IKER SANTIAGO", "Masculino"],
            ["79062455", "PACHERRES", "SAAVEDRA", "LUZ MARIA", "Femenino"],
            ["78780670", "PEÑA", "CHUNGA", "JUAN FERNANDO", "Masculino"],
            ["78665563", "PEREZ", "RAMIREZ", "LUIS SEBASTIAN", "Masculino"],
            ["78725512", "RAMIREZ", "MARCHENA", "SAHORY BRITTANI LUCIA", "Femenino"],
            ["78586161", "RUIZ", "YAJAHUANCA", "RAÚL AARÓN", "Masculino"],
            ["78577671", "SANDOVAL", "MEDINA", "BÉNJAMIN JOSHUÁ", "Masculino"],
            ["78650365", "SIANCAS", "SEBASTIAN", "MIRELLA ALEJANDRA", "Femenino"],
            ["79191782", "SILUPU", "PUMAJULCA", "JAVIER EDUARDO PATRICIO", "Masculino"],
            ["78875792", "SOLIS", "LAPIZ", "VALENTINA", "Femenino"],
            ["78685364", "VALVERDE", "GARCIA", "THIAGO ESMITH", "Masculino"],
            ["78437685", "VIERA", "SANTIAGO", "DAYRON JOSUE", "Masculino"],
            ["78875949", "VIVANCO", "MENDOZA", "DORIS FRANCHESCA LUCERO", "Femenino"],
        ];

        foreach ($estudiantes as [$dni, $ap1, $ap2, $nombres, $genero]) {
            // Capitalización
            $ap1Capital = ucfirst(strtolower($ap1));
            $ap2Capital = ucfirst(strtolower($ap2));
            $nombresCapital = ucwords(strtolower($nombres));
            $primerNombre = explode(' ', $nombresCapital)[0] ?? '';

            // Generar nombre de usuario (ej: Fuenteskc)
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

            // Relación con aula
            DB::table('usuario_aulas')->insert([
                'user_id' => $user_id,
                'aula_id' => 3, // Aula 5C
                'año_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Asignar rol estudiante
            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => $user_id,
            ]);
        }
    }
}
