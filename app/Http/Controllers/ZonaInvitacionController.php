<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnlaceTemporal;
use Illuminate\Support\Facades\Auth;

class ZonaInvitacionController extends Controller
{
    public function aceptar($token) {
        $inv = EnlaceTemporal::where('token', $token)
            ->where('usado', false)
            ->firstOrFail();

        if ($inv->expira_en->isPast()) {
            abort(404);
        }

        $zona = $inv->zona;
        $usuario = Auth::user();

        // marcar el enlace como usado
        $inv->update(['usado' => true]);

        if ($zona->requiere_verificacion) {
            // crear la solicitud como 'pendiente'
            $zona->usuarios()->attach($usuario->id, [
                'estado' => 'pendiente',
                'fecha_solicitud' => now(),
            ]);

            return view('zonas.solicitud-enviada', compact('zona'));
        } else {
            // adjuntar directamente como 'aceptado'
            $zona->usuarios()->attach($usuario->id, [
                'estado' => 'aceptado',
                'fecha_respuesta' => now(),
            ]);

            return redirect()->route('zonas.show', $zona);
        }
    }

}
