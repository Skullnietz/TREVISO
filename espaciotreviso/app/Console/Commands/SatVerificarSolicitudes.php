<?php

namespace App\Console\Commands;

use App\SolicitudDescarga;
use App\Services\Sat\SatDescargaService;
use Illuminate\Console\Command;

class SatVerificarSolicitudes extends Command
{
    protected $signature = 'sat:verificar-solicitudes';
    protected $description = 'Verifica el estado de las solicitudes de descarga pendientes en el SAT';

    public function handle(SatDescargaService $service)
    {
        $solicitudes = SolicitudDescarga::whereIn('estado', ['solicitada', 'verificando'])
            ->with('cliente')
            ->get();

        $this->info("Verificando {$solicitudes->count()} solicitudes pendientes");

        foreach ($solicitudes as $solicitud) {
            try {
                $service->verificarSolicitud($solicitud);
                $this->info("  {$solicitud->cliente->rfc}: {$solicitud->estado}");
            } catch (\Exception $e) {
                $solicitud->update([
                    'estado' => 'error',
                    'error_mensaje' => $e->getMessage(),
                ]);
                $this->error("  {$solicitud->cliente->rfc}: Error - {$e->getMessage()}");
            }
        }

        $this->info('Verificacion completada.');
    }
}
