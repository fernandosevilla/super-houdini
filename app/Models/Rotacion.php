<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rotacion extends Model
{
    /** @use HasFactory<\Database\Factories\RotacionFactory> */
    use HasFactory;

    protected $table = 'rotaciones';

    protected $fillable = [
        'credencial_id',
        'user_id',
        'fecha_rotacion',
        'notas',
        'old_contrasenia',
        'new_contrasenia',
    ];

    protected $casts = [
        'fecha_rotacion' => 'datetime',
    ];

    // Relaciones
    public function credencial() {
        return $this->belongsTo(Credencial::class, 'credencial_id');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
