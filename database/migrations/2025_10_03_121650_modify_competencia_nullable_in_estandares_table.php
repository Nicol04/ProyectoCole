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
        Schema::table('estandares', function (Blueprint $table) {
            $table->unsignedBigInteger('competencia_id')->nullable()->change();
            $table->unsignedBigInteger('competencia_transversal_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('estandares', function (Blueprint $table) {
            $table->unsignedBigInteger('competencia_id')->nullable(false)->change();
            $table->unsignedBigInteger('competencia_transversal_id')->nullable(false)->change();
        });
    }
};
