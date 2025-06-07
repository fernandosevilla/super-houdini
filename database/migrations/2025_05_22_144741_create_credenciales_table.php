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
        Schema::create('credenciales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('creado_por')->constrained('users')->onDelete('cascade');
            $table->foreignId('zona_id')->constrained('zonas')->onDelete('cascade');

            $table->string('nombre_sitio')->nullable();
            $table->string('nombre_usuario')->nullable();
            $table->text('contrasenia');
            $table->string('url', 255)->nullable();
            $table->text('notas')->nullable();

            $table->dateTime('ultima_consulta')->nullable();
            $table->integer('rotacion_cada_dias')->nullable();
            $table->dateTime('fecha_ultima_rotacion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credenciales');
    }
};
