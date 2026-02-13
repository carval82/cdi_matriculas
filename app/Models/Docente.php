<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres', 'apellidos', 'tipo_documento', 'documento',
        'celular', 'telefono', 'email', 'direccion',
        'especialidad', 'titulo', 'foto', 'fecha_ingreso',
        'activo', 'observaciones', 'user_id',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'activo' => 'boolean',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'docente_grupo')
            ->withPivot('rol', 'anio')
            ->withTimestamps();
    }

    public function gruposActuales()
    {
        return $this->grupos()->wherePivot('anio', date('Y'));
    }
}
