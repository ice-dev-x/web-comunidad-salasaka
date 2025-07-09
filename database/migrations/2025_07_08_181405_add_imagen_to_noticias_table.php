<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('noticias', function (Blueprint $table) {
            // Solo agregar la columna si no existe
            if (!Schema::hasColumn('noticias', 'imagen')) {
                $table->string('imagen')->nullable()->after('contenido');
            }
        });
    }

    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table) {
            // Solo eliminar si existe (para evitar errores en rollback)
            if (Schema::hasColumn('noticias', 'imagen')) {
                $table->dropColumn('imagen');
            }
        });
    }
};

