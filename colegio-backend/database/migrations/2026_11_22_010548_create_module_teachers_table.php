<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla intermedia 'module_teachers' (muchos a muchos entre modules y tachers)[cite: 1]
    public function up(): void
    {
        Schema::create('module_teachers', function (Blueprint $table) {
            // Llave primaria autoincremental (id)[cite: 1]
            $table->id();

            // Llave foránea (FK) hacia 'modules.id'[cite: 1]
            $table->foreignId('module_id')
                ->constrained('modules')
                ->onDelete('cascade');

            // Llave foránea (FK) hacia 'tachers.id'[cite: 1]
            $table->foreignId('teacher_id')
                ->constrained('tachers')
                ->onDelete('cascade');

            // Fechas de creación y actualización
            $table->timestamps();
        });
    }

    // Borra la tabla 'module_teachers' si haces rollback
    public function down(): void
    {
        Schema::dropIfExists('module_teachers');
    }
};