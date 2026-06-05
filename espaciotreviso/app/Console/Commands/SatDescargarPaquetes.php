<?php

namespace App\Console\Commands;

use App\SolicitudDescarga;
use App\Services\Sat\SatDescargaService;
use Illuminate\Console\Command;

class SatDescargarPaquetes extends Command
{
    protected $signature = 'sat:descargar-paquetes';
    protected $description = 'Descarga y procesa paquetes de CFDIs listos del SAT';

    public function handle(SatDescargaService $service)
    {
        $solicitudes = SolicitudDescarga::where('estado', 'lista')
            ->with('cliente')
            ->get();

        $this->info("Descargando paquetes de {$solicitudes->count()} solicitudes");

        foreach ($solicitudes as $solicitud) {
            try {
                $solicitud->update(['estado' => 'descargando']);
                $service->descargarPaquetes($solicitud);
                $solicitud->update([
                    'estado' => 'completada',
                    'completada_at' => now(),
                ]);
                $this->info("  {$solicitud->cliente->rfc}: {$solicitud->cfdis_procesados} CFDIs procesados");
            } catch (\Exception $e) {
                $solicitud->update([
                    'estado' => 'error',
                    'error_mensaje' => $e->getMessage(),
                ]);
                $this->error("  {$solicitud->cliente->rfc}: Error - {$e->getMessage()}");
            }
        }

        $this->info('Descarga completada.');
    }
}
