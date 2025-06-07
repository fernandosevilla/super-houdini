<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnlaceTemporal;
use Illuminate\Support\Facades\Auth;

class ZonaInvitacionController extends Controller
{
    public function aceptar($token)
    {
        $inv = EnlaceTemporal::where('token', $token)
            ->whereNotNull('zona_id')
            ->where('expira_en', '>=', now())
            ->firstOrFail();

        $user = Auth::user();

        // añade al pivot zona_usuario sin duplicar
        $inv->zona->usuarios()->syncWithoutDetaching([
            $user->id => [
                'estado' => 'aceptado',
                'fecha_solicitud' => now(),
                'fecha_respuesta' => now(),
            ]
        ]);

        $inv->update(['usado' => true]);

        return redirect()->route('zonas.show', $inv->zona_id);
    }
}
