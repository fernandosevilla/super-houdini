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
        Schema::create('enlaces_temporales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('credencial_id')->constrained('credenciales')->onDelete('cascade');

            $table->string('hash_seguro', 255)->unique();
            $table->dateTime('expira_en');
            $table->boolean('usado')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enlaces_temporales');
    }
};
