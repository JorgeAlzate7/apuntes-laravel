<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla 'estudents' en la base de datos[cite: 1]
    public function up(): void
    {
        Schema::create('estudents', function (Blueprint $table) {
            // Llave primaria autoincremental (id)[cite: 1]
            $table->id();

            // Llave foránea (FK): conecta cada estudiante con un módulo de 'modules'[cite: 1]
            // constrained('modules') obliga a que el module_id exista en 'modules'
            // onDelete('cascade') borra los estudiantes del módulo si se elimina ese módulo
            $table->foreignId('module_id')
                ->constrained('modules')
                ->onDelete('cascade');

            // Nombre del estudiante[cite: 1]
            $table->string('nombre');

            // Apellidos del estudiante[cite: 1]
            $table->string('apellidos');

            // Fecha de nacimiento en formato fecha (YYYY-MM-DD)[cite: 1]
            $table->date('fecha_nacimiento');

            // Expediente: guarda el enlace (URL) que devuelve Cloudinary[cite: 1]
            $table->string('expediente');

            // Fechas de creación y actualización
            $table->timestamps();
        });
    }

    // Borra la tabla 'estudents' si haces rollback
    public function down(): void
    {
        Schema::dropIfExists('estudents');
    }
};