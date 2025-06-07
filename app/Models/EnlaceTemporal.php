<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnlaceTemporal extends Model
{
    /** @use HasFactory<\Database\Factories\EnlaceTemporalFactory> */
    use HasFactory;

    protected $table = 'enlaces_temporales';

    protected $fillable = [
        'zona_id',
        'token',
        'expira_en',
        'usado',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'usado' => 'boolean',
    ];

    // Relaciones
    public function zona() {
        return $this->belongsTo(Zona::class);
    }
}
