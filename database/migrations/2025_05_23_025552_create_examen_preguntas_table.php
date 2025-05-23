<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examen_preguntas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluacion_id');
            $table->string('tipo_pregunta')->default('opcion_multiple');
            $table->text('pregunta');
            $table->text('opcion_a')->nullable();
            $table->text('opcion_b')->nullable();
            $table->text('opcion_c')->nullable();
            $table->char('respuesta_correcta', 1)->nullable();
            $table->timestamps();

            $table->foreign('evaluacion_id')->references('id')->on('evaluacions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_preguntas');
    }
};
