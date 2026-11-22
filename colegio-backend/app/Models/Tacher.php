<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tacher extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla en la base de datos
    protected $table = 'tachers';

    // Campos permitidos al crear o actualizar
    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'cedula',
    ];

    // MUCHOS A MUCHOS (belongsToMany): Un docente (Tacher) tiene MUCHOS módulos (Module)
    // Se conecta mediante la tabla intermedia 'module_teachers' usando 'teacher_id' y 'module_id'
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'module_teachers', 'teacher_id', 'module_id')
            ->withTimestamps();
    }

    // UNO A MUCHOS (hasMany): Un docente (Tacher) tiene MUCHOS registros en la tabla intermedia ModuleTeacher
    public function moduleTeachers(): HasMany
    {
        return $this->hasMany(ModuleTeacher::class, 'teacher_id');
    }
}