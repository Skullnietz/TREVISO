<?php

namespace App\Console\Commands;

use App\Cliente;
use App\SolicitudDescarga;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SatSolicitarDescargas extends Command
{
    protected $signature = 'sat:solicitar-descargas {--fecha= : Fecha especifica YYYY-MM-DD}';
    protected $description = 'Solicita descarga de CFDIs del SAT para todos los clientes con e.firma activa';

    public function handle()
    {
        $fecha = $this->option('fecha')
            ? Carbon::parse($this->option('fecha'))
            : Carbon::yesterday();

        $clientes = Cliente::where('activo', true)
            ->whereNotNull('cer_path')
            ->where('efirma_vigencia', '>', now())
            ->get();

        $this->info("Procesando {$clientes->count()} clientes para fecha {$fecha->format('Y-m-d')}");

        foreach ($clientes as $cliente) {
            foreach (['emitida', 'recibida'] as $tipo) {
                $existe = SolicitudDescarga::where('cliente_id', $cliente->id)
                    ->where('tipo', $tipo)
                    ->where('fecha_inicio', $fecha)
                    ->where('fecha_fin', $fecha)
                    ->exists();

                if ($existe) {
                    $this->line("  Saltando {$cliente->rfc} ({$tipo}) - ya existe solicitud");
                    continue;
                }

                SolicitudDescarga::create([
                    'cliente_id' => $cliente->id,
                    'tipo' => $tipo,
                    'fecha_inicio' => $fecha,
                    'fecha_fin' => $fecha,
                    'estado' => 'pendiente',
                    'automatica' => true,
                ]);

                $this->info("  Creada solicitud: {$cliente->rfc} ({$tipo})");
            }
        }

        $this->info('Proceso completado.');
    }
}
