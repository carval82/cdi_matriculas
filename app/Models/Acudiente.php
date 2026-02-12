<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acudiente extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento', 'documento', 'nombres', 'apellidos',
        'parentesco', 'telefono', 'celular', 'email',
        'direccion', 'barrio', 'ocupacion', 'empresa_trabajo',
        'telefono_trabajo', 'eps', 'observaciones', 'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
