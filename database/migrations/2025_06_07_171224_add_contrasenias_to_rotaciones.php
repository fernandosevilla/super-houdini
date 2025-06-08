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
        Schema::table('rotaciones', function (Blueprint $table) {
            $table->text('old_contrasenia')->nullable()->after('credencial_id');
            $table->text('new_contrasenia')->nullable()->after('old_contrasenia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rotaciones', function (Blueprint $table) {
            $table->dropColumn(['old_contrasenia', 'new_contrasenia']);
        });
    }
};
