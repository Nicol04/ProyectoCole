<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unidad_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidad_id')->constrained('unidades')->onDelete('cascade');

            // Contenido completo por cursos y competencias
            $table->json('contenido')->nullable();

            /*
            Estructura esperada del JSON "contenido":
            {
                "cursos": [
                {
                    "nombre": "Comunicación",
                    "competencias": [
                    {
                        "nombre": "SE COMUNICA ORALMENTE EN SU LENGUA MATERNA",
                        "capacidades": [...],
                        "desempenos": [...],
                        "criterios": [...],
                        "evidencias": [...],
                        "instrumentos": [...]
                    }
                    ]
                }
                ]
            }
            */

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unidad_detalles');
    }
};
