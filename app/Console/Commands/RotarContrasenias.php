<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Credencial;
use App\Models\Rotacion;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class RotarContrasenias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rotar-contrasenias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rota las contraseñas según el intervalo definido en cada credencial y registra el histórico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $credenciales = Credencial::dueForRotation()->get();

        if ($credenciales->isEmpty()) {
            $this->info('No hay credenciales para rotar.');
            return;
        }

        $this->info('Rotando contraseñas...');

        foreach ($credenciales as $credencial) {
            $this->info('Rotando contrasenia para ' . $credencial->nombre_sitio);

            $oldContraseniaCifrada = $credencial->contrasenia;
            $newContraseniaPlano = Str::random(16);
            $newContraseniaCifrada = Crypt::encrypt($newContraseniaPlano);

            $credencial->update([
                'contrasenia' => $newContraseniaCifrada,
                'fecha_ultima_rotacion' => now(),
            ]);

            Rotacion::create([
                'credencial_id' => $credencial->id,
                'user_id' => $credencial->creado_por,
                'fecha_rotacion' => now(),
                'old_contrasenia' => $oldContraseniaCifrada,
                'new_contrasenia' => $newContraseniaCifrada,
            ]);
        }

        $this->info('Rotaciones hechas');

        return 0;
    }
}
