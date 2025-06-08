<?php

namespace App\Console\Commands;

use App\Models\EnlaceTemporal;
use Illuminate\Console\Command;

class EliminarEnlacesExpirados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:eliminar-enlaces-expirados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina los enlaces temporales expirados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = EnlaceTemporal::where('expira_en', '<', now())->delete();
        $this->info("Se han eliminado {$deleted} enlaces expirados.");
    }
}
