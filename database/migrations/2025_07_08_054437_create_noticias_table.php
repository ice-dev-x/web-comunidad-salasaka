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
        Schema::create('noticias', function (Blueprint $table) {
        $table->id(); // ID autoincremental
        $table->string('titulo');
        $table->text('contenido');
        $table->string('autor')->nullable();
        $table->string('imagen')->nullable(); // ruta de imagen
        $table->boolean('publicado')->default(true);
        $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
