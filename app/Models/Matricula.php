<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'estudiante_id', 'estancia_id', 'acudiente_id',
        'anio', 'periodo', 'fecha_matricula', 'valor_matricula',
        'valor_pension', 'descuento', 'tipo_descuento', 'estado',
        'jornada', 'observaciones', 'created_by',
    ];

    protected $casts = [
        'fecha_matricula' => 'date',
        'valor_matricula' => 'decimal:2',
        'valor_pension' => 'decimal:2',
        'descuento' => 'decimal:2',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function estancia()
    {
        return $this->belongsTo(Estancia::class);
    }

    public function acudiente()
    {
        return $this->belongsTo(Acudiente::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generarCodigo(int $anio): string
    {
        $ultimo = static::where('anio', $anio)->max('id') ?? 0;
        return sprintf('MAT-%d-%03d', $anio, $ultimo + 1);
    }
}
