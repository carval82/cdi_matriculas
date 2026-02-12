<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'tipo_documento', 'documento', 'nombres', 'apellidos',
        'fecha_nacimiento', 'lugar_nacimiento', 'genero', 'rh', 'eps',
        'foto', 'alergias', 'condiciones_medicas', 'medicamentos',
        'contacto_emergencia', 'telefono_emergencia',
        'acudiente_id', 'acudiente_secundario_id', 'estancia_id',
        'estado', 'fecha_ingreso', 'fecha_retiro', 'observaciones',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'fecha_retiro' => 'date',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function getEdadAttribute(): string
    {
        $nacimiento = $this->fecha_nacimiento;
        if (!$nacimiento) return '';

        $anios = $nacimiento->age;
        $meses = $nacimiento->diffInMonths(now()) % 12;

        if ($anios > 0) {
            return "{$anios} año" . ($anios > 1 ? 's' : '') . " {$meses} mes" . ($meses != 1 ? 'es' : '');
        }
        return "{$meses} mes" . ($meses != 1 ? 'es' : '');
    }

    public function getEdadMesesAttribute(): int
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->diffInMonths(now()) : 0;
    }

    public function acudiente()
    {
        return $this->belongsTo(Acudiente::class);
    }

    public function acudienteSecundario()
    {
        return $this->belongsTo(Acudiente::class, 'acudiente_secundario_id');
    }

    public function estancia()
    {
        return $this->belongsTo(Estancia::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function matriculaActiva()
    {
        return $this->hasOne(Matricula::class)->where('estado', 'activa')->latest();
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
