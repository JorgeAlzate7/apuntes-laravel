<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla 'modules' en la base de datos[cite: 1]
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            // Llave primaria autoincremental (id)[cite: 1]
            $table->id();

            // Código del módulo: string y 'unique()' para que no se repitan códigos[cite: 1]
            $table->string('codigo')->unique();

            // Nombre del módulo[cite: 1]
            $table->string('nombre');

            // Crea automáticamente las columnas 'created_at' y 'updated_at'
            $table->timestamps();
        });
    }

    // Borra la tabla 'modules' si haces rollback
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};