<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ZonaUsuario extends Pivot
{
    protected $table = 'zona_usuario';

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_respuesta' => 'datetime',
    ];
}
