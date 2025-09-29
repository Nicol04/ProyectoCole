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
        Schema::create('rubrica_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rubrica_id')->constrained('rubricas')->onDelete('cascade');
            $table->enum('nivel', ['Inicio', 'Proceso', 'Logro esperado', 'Destacado']);
            $table->text('descriptor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubrica_detalles');
    }
};
