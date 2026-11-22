<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla en la base de datos
    protected $table = 'modules';

    // Campos permitidos al crear o actualizar
    protected $fillable = [
        'codigo',
        'nombre',
    ];

    // UNO A MUCHOS (hasMany): Un módulo (Module) tiene MUCHOS estudiantes (Estudent) usando module_id
    public function estudents(): HasMany
    {
        return $this->hasMany(Estudent::class, 'module_id');
    }

    // MUCHOS A MUCHOS (belongsToMany): Un módulo (Module) tiene MUCHOS docentes (Tacher)
    // Se conecta mediante la tabla intermedia 'module_teachers' usando 'module_id' y 'teacher_id'
    public function tachers(): BelongsToMany
    {
        return $this->belongsToMany(Tacher::class, 'module_teachers', 'module_id', 'teacher_id')
            ->withTimestamps();
    }

    // UNO A MUCHOS (hasMany): Un módulo (Module) tiene MUCHOS registros en la tabla intermedia ModuleTeacher
    public function moduleTeachers(): HasMany
    {
        return $this->hasMany(ModuleTeacher::class, 'module_id');
    }
}