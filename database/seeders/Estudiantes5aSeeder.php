<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Estudiantes5aSeeder extends Seeder
{
    public function run()
    {
        $estudiantes = [
            ["78695078", "ARISMENDIZ", "NAVARRO", "MARIA PAZ ISABELLA", "Femenino"],
            ["78966727", "ATIAJA", "CORDOVA", "BRITHANY MARIA PIA", "Femenino"],
            ["78943552", "CAMPOS", "LOZANO", "ALEJANDRO MATEO", "Masculino"],
            ["79062387", "ELORRIETA", "MOSCOL", "DIANA ANGÉLICA", "Femenino"],
            ["20163808910058", "ESPINOZA", "OLIVA", "PATRICK ALI", "Masculino"],
            ["78679895", "ESPINOZA", "PALACIOS", "JHANNA MILETT", "Femenino"],
            ["78645183", "ESPINOZA", "RIMAYCUNA", "LIAM ABBÍ", "Masculino"],
            ["78591640", "FLORES", "GRANJA", "MIA VALESKA ZASHARY", "Femenino"],
            ["78855939", "GARCES", "MORAN", "DAVID BENJAMÍN", "Masculino"],
            ["78666267", "GARCES", "VIERA", "JULIETTE ANTONELLA", "Femenino"],
            ["78917802", "GARRIDO", "CASTRO", "JOSEPH HAZUR", "Masculino"],
            ["78894540", "GIRON", "MUNARRIZ", "DARIEL HUMBERTO", "Masculino"],
            ["78668000", "GUTIERREZ", "OTINIANO", "JIREH JASSIEL", "Femenino"],
            ["78842389", "HERRERA", "SILVA", "BRYAN ANTHONY", "Masculino"],
            ["79022808", "LAUREANO", "GUTIERREZ", "LIAN MATEO", "Masculino"],
            ["78819474", "MECHATO", "TOCTO", "MAYKEL ABDIEL", "Masculino"],
            ["78878057", "MELENDEZ", "CUEVA", "RENATO ANDRES", "Masculino"],
            ["78680478", "MENA", "TABOADA", "LUIS ANTONIO", "Masculino"],
            ["78999018", "MERINO", "TIMANA", "ALVARO GONZALO", "Masculino"],
            ["79066934", "MONTALBAN", "PALACIOS", "ERICKSON JHOSUE", "Masculino"],
            ["78612600", "NAVARRO", "POLO", "JOSUÉ CALEB", "Masculino"],
            ["78989629", "NIZAMA", "VIERA", "MATEO RAFAEL", "Masculino"],
            ["78623225", "OLIVARES", "VIERA", "THIAGO ALONZO", "Masculino"],
            ["78824876", "PACHERREZ", "PAICO", "NICOLAS JUNIOR LIONELL", "Masculino"],
            ["78737866", "PALACIOS", "MOGOLLON", "BRITHANY MICHEL", "Femenino"],
            ["78818469", "PANTA", "CORDOVA", "GRACIA ABIGAIL", "Femenino"],
            ["78876782", "PERALES", "GALLO", "ORBIL ETHAN", "Masculino"],
            ["79124335", "RIVERA", "MOSCOL", "THIAGO RICARDO", "Masculino"],
            ["79048048", "RODRIGUEZ", "RAMIREZ", "ROY EDUARDO", "Masculino"],
            ["78975827", "ROJAS", "VALDIVIEZO", "JOSÉ ANTONIO", "Masculino"],
            ["78601571", "RUGEL", "PAZO", "JENNIFER MILAGROS", "Femenino"],
            ["78799304", "SANDOVAL", "ROMERO", "ADRIAN SMITH", "Masculino"],
            ["78612629", "VIERA", "LIVIAPOMA", "SALVADOR ALBERTO", "Masculino"],
            ["78563719", "YAMUNAQUE", "PANTALEON", "MIGUEL ANGEL", "Masculino"],
            ["78827269", "ALVARADO", "CARREÑO", "CARLOS ANDRÉ", "Masculino"],
            ["78706874", "AVALO", "CARRASCO", "ANDREA BRUNELA KILLARI", "Femenino"],
            ["78639233", "CARRASCO", "ZAPATA", "BRIANNA MICHELL", "Femenino"],
            ["78752702", "CLEMENT", "BENITES", "KRISTEL MARIEL", "Femenino"],
            ["78524991", "GARCIA", "BELLIDO", "FELIPE FERNANDO", "Masculino"],
            ["79056032", "GUERRERO", "JABO", "AMARA KRISTEL", "Femenino"],
        ];

        foreach ($estudiantes as [$dni, $ap1, $ap2, $nombres, $genero]) {
            $ap1Capital = ucfirst(strtolower($ap1));
            $ap2Capital = ucfirst(strtolower($ap2));
            $nombresCapital = ucwords(strtolower($nombres));

            $primerNombre = explode(' ', $nombresCapital)[0] ?? '';
            $username = $ap1Capital . strtolower(($primerNombre[0] ?? '') . ($ap2Capital[0] ?? ''));
            $avatar = $genero === 'Masculino' || $genero === 'Hombre' ? 2 : 3;

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
                'aula_id' => 1,
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
