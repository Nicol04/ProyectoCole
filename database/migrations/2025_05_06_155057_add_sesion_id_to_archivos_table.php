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
        Schema::table('archivos', function (Blueprint $table) {
            $table->unsignedBigInteger('sesion_id')->nullable();
            $table->foreign('sesion_id')->references('id')->on('sesions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->dropForeign(['sesion_id']);
            $table->dropColumn('sesion_id');
        });
    }
};
