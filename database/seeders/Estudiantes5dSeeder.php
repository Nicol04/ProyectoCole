<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class Estudiantes5dSeeder extends Seeder
{
    public function run()
    {
        $estudiantes = [
            ["78690147", "ALBURQUEQUE", "VIERA", "KENDRA MILETT", "Femenino"],
            ["20171514300038", "ALVARADO", "AGURTO", "ALITZA AYELETH", "Femenino"],
            ["78950919", "APONTE", "MARTINEZ", "KEVIN NEYDEL", "Masculino"],
            ["79148704", "ATOCHE", "PALACIOS", "MIA ABIGAIL", "Femenino"],
            ["78976169", "AVILA", "GUZMAN", "LIAM ALONSO", "Masculino"],
            ["79060199", "CASTILLO", "CHUNGA", "LIAM JOSEPH", "Masculino"],
            ["78687560", "CASTILLO", "RELAIZA", "MIA LUCIANA AZNAILA", "Femenino"],
            ["78697680", "CHECA", "GUERRERO", "LUHANA YUVETH", "Femenino"],
            ["81429490", "DAVILA", "GARCIA", "GUILLERMO", "Masculino"],
            ["78758740", "DIAZ", "GARCES", "BRITHANY BRIGGITH", "Femenino"],
            ["78600541", "DOMINGUEZ", "FERNANDEZ", "JONATHAN JOSUE", "Masculino"],
            ["78852569", "DOMINGUEZ", "MANRIQUE", "ANGELLY CRISTEL", "Femenino"],
            ["79320538", "DURAND", "VIERA", "JHEYKO VALENTINO NIKOLAY", "Masculino"],
            ["78618333", "FLORES", "CASTILLO", "NATHALY KYLLARI", "Femenino"],
            ["78562938", "FLORES", "REYES", "DALESKA MARIEL", "Femenino"],
            ["79004902", "JIMENEZ", "CAMIZAN", "CARLOS JUAN DIEGO", "Masculino"],
            ["78665088", "NEYRA", "SOLANO", "PIERO ALESSANDRO", "Masculino"],
            ["79042642", "NIZAMA", "YARLEQUE", "JESÚS ADRIAN", "Masculino"],
            ["79027985", "OLAYA", "MORE", "STEFANO MARTIN", "Masculino"],
            ["78541792", "PACHERRE", "OCAMPOS", "THIAGO MIGUEL", "Masculino"],
            ["78471985", "PALACIOS", "JUMBO", "ADRIANA JAMILÉ", "Femenino"],
            ["78732049", "PRIETO", "VILLEGAS", "LIAN FABRICIO", "Masculino"],
            ["78773207", "QUINDE", "RUGEL", "FLAVIA ANTONELLA", "Femenino"],
            ["78574907", "REMAYCUNA", "HUAMAN", "CRISTHIAN", "Masculino"],
            ["78705918", "RENTERIA", "ALAMA", "GUIA BRITTANY", "Femenino"],
            ["78737073", "RIOS", "NIZAMA", "DIEGO NATANAEL", "Masculino"],
            ["79978203", "RODRIGUEZ", "MACAZANA", "YONNIER MATEO", "Masculino"],
            ["78789314", "SAGUMA", "LOPEZ", "BRIANA BALESKA", "Femenino"],
            ["78624929", "SALDARRIAGA", "CASTRO", "DERCY DALESKA", "Femenino"],
            ["23101724300060", "SANDOVAL", "MOROCHO", "ADRIANA ISABELLA", "Femenino"],
            ["78325802", "SEMINARIO", "MACALUPU", "STEVEN ALEXANDER", "Masculino"],
            ["78685570", "SILVA", "REQUENA", "DARIANA ZOÉ", "Femenino"],
            ["78824087", "SILVA", "SERNAQUE", "THIAGO SMITH", "Masculino"],
            ["77116483", "SOLANO", "VEGA", "PERRY ARTURO", "Masculino"],
            ["78760999", "TENORIO", "GIRON", "SOFÍA VALESKA", "Femenino"],
            ["78552640", "VILCHEZ", "DIAZ", "MANUEL ALEJANDRO", "Masculino"],
            ["78680348", "VILLAVICENCIO", "JIMENEZ", "ANDERSON ELIEL", "Masculino"],
            ["78696251", "YARLEQUE", "CHARLES", "LEONARDO FABRICIO", "Masculino"],
        ];

        foreach ($estudiantes as [$dni, $ap1, $ap2, $nombres, $genero]) {
            $ap1Capital = ucfirst(strtolower($ap1));
            $ap2Capital = ucfirst(strtolower($ap2));
            $nombresCapital = ucwords(strtolower($nombres));
            $primerNombre = explode(' ', $nombresCapital)[0] ?? '';

            // Nombre de usuario: Apellido1 + inicial nombre + inicial apellido2
            $username = $ap1Capital . strtolower(($primerNombre[0] ?? '') . ($ap2Capital[0] ?? ''));

            $avatar = $genero === 'Masculino' ? 2 : 3;

            $persona_id = DB::table('personas')->insertGetId([
                'nombre' => $nombresCapital,
                'apellido' => "$ap1Capital $ap2Capital",
                'dni' => $dni,
                'genero' => $genero,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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

            DB::table('usuario_aulas')->insert([
                'user_id' => $user_id,
                'aula_id' => 4, // Aula 5D
                'año_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => $user_id,
            ]);
        }
    }
}
