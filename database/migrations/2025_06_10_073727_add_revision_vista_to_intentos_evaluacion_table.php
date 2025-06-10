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
        Schema::table('intentos_evaluacion', function (Blueprint $table) {
            $table->boolean('revision_vista')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('intentos_evaluacion', function (Blueprint $table) {
            $table->dropColumn('revision_vista');
        });
    }
};
