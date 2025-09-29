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
        Schema::create('sesion_momentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesions')->onDelete('cascade');
            $table->enum('momento', ['Inicio', 'Desarrollo', 'Cierre']);
            $table->text('estrategia')->nullable(); // lo que genera IA o escribe docente
            $table->text('descripcion_actividad')->nullable(); // detalle de la actividad
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion_momentos');
    }
};
