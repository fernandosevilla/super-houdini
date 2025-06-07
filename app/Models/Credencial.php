<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Credencial extends Model
{
    /** @use HasFactory<\Database\Factories\CredencialFactory> */
    use HasFactory;

    protected $table = 'credenciales';

    protected $fillable = [
        'creado_por',
        'zona_id',
        'nombre_sitio',
        'nombre_usuario',
        'contrasenia',
        'url',
        'notas',
        'ultima_consulta',
        'rotacion_cada_dias',
        'fecha_ultima_rotacion',
    ];

    protected $casts = [
        'ultima_consulta' => 'datetime',
        'rotacion_cada_dias' => 'integer',
        'fecha_ultima_rotacion' => 'datetime',
    ];

    // Relaciones
    public function zona() {
        return $this->belongsTo(Zona::class, 'zona_id');
    }

    public function creador() {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function rotaciones() {
        return $this->hasMany(Rotacion::class);
    }

    // helpers
    public function scopeDueForRotation($query) {
        return $query->whereRaw(
            "fecha_ultima_rotacion <= DATE_SUB(NOW(), INTERVAL rotacion_cada_dias DAY)"
        );
    }

    public function getDiasParaRotacionAttribute(): int
    {
        $fechaUltima = $this->fecha_ultima_rotacion->copy();
        $proxima = $fechaUltima->addDays($this->rotacion_cada_dias);

        $hoy = Carbon::today();

        if ($proxima->gt($hoy)) {
            return $hoy->diffInDays($proxima);
        }

        if ($proxima->eq($hoy)) {
            return 0;
        }

        return - $proxima->diffInDays($hoy);
    }
}
