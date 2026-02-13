<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'codigo', 'edad_minima', 'edad_maxima',
        'capacidad', 'jornada', 'valor_matricula', 'valor_pension',
        'descripcion', 'activa', 'orden',
    ];

    protected $casts = [
        'valor_matricula' => 'decimal:2',
        'valor_pension' => 'decimal:2',
        'activa' => 'boolean',
    ];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function estudiantesActivos()
    {
        return $this->estudiantes()->where('estado', 'activo');
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'docente_grupo')
            ->withPivot('rol', 'anio')
            ->withTimestamps();
    }

    public function docentesActuales()
    {
        return $this->docentes()->wherePivot('anio', date('Y'));
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function cuposDisponibles(): int
    {
        return $this->capacidad - $this->estudiantesActivos()->count();
    }
}
