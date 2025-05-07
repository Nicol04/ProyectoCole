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
        Schema::table('evaluacions', function (Blueprint $table) {
            $table->unsignedBigInteger('archivo_id');
            $table->foreign('archivo_id')->references('id')->on('archivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluacions', function (Blueprint $table) {
            $table->dropForeign(['archivo_id']);
            $table->dropColumn('archivo_id');
        });
    }
};
