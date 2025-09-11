<?php

use Illuminate\Database\Seeder;
use App\Models\IntentoEvaluacion;
use App\Models\RespuestaEstudiante;
use App\Models\Calificacion;
use App\Models\Respuesta_estudiante;
use Carbon\Carbon;

class IntentoRespuestaCalificacionSeeder extends Seeder
{
    public function run()
    {
        // Lista de los user_id proporcionados
        $user_ids = [
            340,
            341,
            342,
            343,
            344,
            345,
            346,
            347,
            348,
            349,
            350,
            351,
            352,
            353,
            354,
            355,
            356,
            357,
            358,
            359,
            360,
            361,
            362,
            363,
            364,
            365,
            366,
            367,
            368
        ];


        // Fechas proporcionadas
        $fecha_inicio = Carbon::create(2025, 6, 5, 0, 34, 3); // fecha de inicio
        $fecha_fin = Carbon::create(2025, 6, 5, 0, 50, 48); // fecha de fin

        // Estado y fechas
        $estado = 'finalizado';
        $revision_vista = 1;
        $fecha_revision_vista = Carbon::create(2025, 6, 5, 0, 55, 48);

        // JSON con las respuestas
        // JSON con las respuestas
        // 18 de 20:
        $respuesta_json = json_encode([
            [
                "pregunta" => "¿Qué es la fotosíntesis?",
                "opciones" => [
                    "a) El proceso de respiración de las plantas",
                    "b) El proceso mediante el cual las plantas fabrican su propio alimento",
                    "c) El proceso de absorción de agua y sales minerales"
                ],
                "respuesta_correcta" => "b",
                "respuesta_seleccionada" => "b",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿Qué absorbe la planta a través de la raíz?",
                "opciones" => [
                    "a) Dióxido de carbono y oxígeno",
                    "b) Savia elaborada",
                    "c) Agua y sales minerales"
                ],
                "respuesta_correcta" => "c",
                "respuesta_seleccionada" => "c",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿Qué gas toman las hojas del aire?",
                "opciones" => [
                    "a) Oxígeno",
                    "b) Dióxido de carbono",
                    "c) Nitrógeno"
                ],
                "respuesta_correcta" => "b",
                "respuesta_seleccionada" => "b",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿Qué se produce cuando la savia bruta se mezcla con dióxido de carbono con la ayuda de la luz?",
                "opciones" => [
                    "a) Savia bruta",
                    "b) Savia elaborada",
                    "c) Oxígeno"
                ],
                "respuesta_correcta" => "b",
                "respuesta_seleccionada" => "b",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿Qué expulsa la planta durante la fotosíntesis?",
                "opciones" => [
                    "a) Dióxido de carbono",
                    "b) Oxígeno",
                    "c) Savia bruta"
                ],
                "respuesta_correcta" => "b",
                "respuesta_seleccionada" => "b",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿A través de qué vasos se reparte la savia elaborada?",
                "opciones" => [
                    "a) Vasos leñosos",
                    "b) Vasos sanguíneos",
                    "c) Vasos liberianos"
                ],
                "respuesta_correcta" => "c",
                "respuesta_seleccionada" => "c",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿Qué es necesario para que las plantas realicen la fotosíntesis?",
                "opciones" => [
                    "a) Exclusivamente agua",
                    "b) Luz del sol, agua y dióxido de carbono",
                    "c) Únicamente dióxido de carbono"
                ],
                "respuesta_correcta" => "b",
                "respuesta_seleccionada" => "b",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿Cuándo ocurre la fotosíntesis?",
                "opciones" => [
                    "a) Durante la noche",
                    "b) Solo con luz solar",
                    "c) Durante todo el día"
                ],
                "respuesta_correcta" => "b",
                "respuesta_seleccionada" => "a", // ❌ incorrecta
                "valor_pregunta" => 2,
                "valor_respuesta" => 0
            ],
            [
                "pregunta" => "¿Por qué es importante la fotosíntesis?",
                "opciones" => [
                    "a) Solo para que las plantas crezcan",
                    "b) Para producir dióxido de carbono",
                    "c) Porque produce el oxígeno que necesitamos para vivir"
                ],
                "respuesta_correcta" => "c",
                "respuesta_seleccionada" => "c",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ],
            [
                "pregunta" => "¿Por qué la fotosíntesis es la base de la vida en la Tierra?",
                "opciones" => [
                    "a) Porque sin plantas habría más agua",
                    "b) Porque sin plantas, no habría alimentos ni aire limpio",
                    "c) Porque sin plantas no habría sales minerales"
                ],
                "respuesta_correcta" => "b",
                "respuesta_seleccionada" => "b",
                "valor_pregunta" => 2,
                "valor_respuesta" => 2
            ]
        ]);


        // Calificaciones
        $puntaje_total = 18.00;
        $puntaje_maximo = 20;

        $puntaje_total_01 = 20.00;
        $puntaje_maximo_01 = 20;

        $puntaje_total_02 = 12.00;
        $puntaje_maximo_02 = 20;

        $puntaje_total_03 = 0.00;
        $puntaje_maximo_04 = 20;


        $porcentaje = ($puntaje_total / $puntaje_maximo) * 100; // Calculamos el porcentaje
        $estado_calificacion = $porcentaje >= 50 ? 'Aprobado' : 'Reprobado'; // Establecemos si el estado es aprobado o reprobado
        $fecha_calificacion = Carbon::create(2025, 6, 5, 0, 35, 48); // Fecha de calificación

        // Recorrer los user_id y generar registros en las tres tablas
        foreach ($user_ids as $user_id) {
            // 1. Crear IntentoEvaluacion
            $intento = IntentoEvaluacion::create([
                'evaluacion_id' => 29,
                'user_id' => $user_id,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'estado' => $estado,
                'revision_vista' => $revision_vista,
            ]);

            // 2. Crear RespuestaEstudiante
            Respuesta_estudiante::create([
                'user_id' => $user_id,
                'examen_pregunta_id' => 47,
                'intento_id' => $intento->id, // Usamos el id del intento creado
                'respuesta_json' => $respuesta_json,
                'fecha_respuesta' => $fecha_calificacion,
            ]);

            // 3. Crear Calificacion
            Calificacion::create([
                'intento_id' => $intento->id, // Usamos el id del intento creado
                'retroalimentacion' => 'Bien hecho, sigue así!', // Retroalimentación predeterminada
                'fecha' => $fecha_calificacion,
                'puntaje_total' => $puntaje_total,
                'puntaje_maximo' => $puntaje_maximo,
                'porcentaje' => $porcentaje,
                'estado' => $estado_calificacion,
            ]);
        }
    }
}