<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla 'tachers' en la base de datos[cite: 1]
    public function up(): void
    {
        Schema::create('tachers', function (Blueprint $table) {
            // Llave primaria autoincremental (id)[cite: 1]
            $table->id();

            // Nombre del docente[cite: 1]
            $table->string('nombre');

            // Apellido del docente[cite: 1]
            $table->string('apellido');

            // Teléfono del docente[cite: 1]
            $table->string('telefono');

            // Cédula del docente: 'unique()' para que no existan dos docentes con la misma cédula[cite: 1]
            $table->string('cedula')->unique();

            // Fechas de creación y actualización
            $table->timestamps();
        });
    }

    // Borra la tabla 'tachers' si haces rollback
    public function down(): void
    {
        Schema::dropIfExists('tachers');
    }
};