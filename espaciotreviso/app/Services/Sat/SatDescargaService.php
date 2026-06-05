<?php

namespace App\Services\Sat;

use App\Cfdi;
use App\Cliente;
use App\PaqueteDescarga;
use App\SolicitudDescarga;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SatDescargaService
{
    private SatAuthService $authService;
    private CfdiParserService $parser;

    public function __construct(SatAuthService $authService, CfdiParserService $parser)
    {
        $this->authService = $authService;
        $this->parser = $parser;
    }

    public function solicitarDescarga(Cliente $cliente, Carbon $inicio, Carbon $fin, string $tipo): SolicitudDescarga
    {
        $solicitud = SolicitudDescarga::create([
            'cliente_id' => $cliente->id,
            'tipo' => $tipo,
            'fecha_inicio' => $inicio,
            'fecha_fin' => $fin,
            'estado' => 'pendiente',
        ]);

        // TODO: Integrate with phpcfdi/sat-ws-descarga-masiva
        // 1. Authenticate with SAT
        // 2. Create download request
        // 3. Store request_id
        // 4. Update estado to 'solicitada'

        return $solicitud;
    }

    public function verificarSolicitud(SolicitudDescarga $solicitud): void
    {
        // TODO: Integrate with phpcfdi/sat-ws-descarga-masiva
        // 1. Call verify endpoint with request_id
        // 2. Update paquetes_total
        // 3. Create PaqueteDescarga records
        // 4. Update estado
    }

    public function descargarPaquetes(SolicitudDescarga $solicitud): void
    {
        $paquetes = $solicitud->paquetes()->where('estado', 'pendiente')->get();

        foreach ($paquetes as $paquete) {
            $this->descargarPaquete($solicitud, $paquete);
        }
    }

    private function descargarPaquete(SolicitudDescarga $solicitud, PaqueteDescarga $paquete): void
    {
        // TODO: Integrate with phpcfdi/sat-ws-descarga-masiva
        // 1. Download ZIP package
        // 2. Save to storage
        // 3. Extract XMLs
        // 4. Parse and save each CFDI
    }

    public function procesarZip(SolicitudDescarga $solicitud, string $zipPath): int
    {
        $zip = new \ZipArchive();
        $count = 0;

        if ($zip->open($zipPath) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $xmlContent = $zip->getFromIndex($i);
                if (!$xmlContent) continue;

                try {
                    $datos = $this->parser->parsearXml($xmlContent);
                    $this->guardarCfdi($solicitud, $datos, $xmlContent);
                    $count++;
                } catch (\Exception $e) {
                    continue;
                }
            }
            $zip->close();
        }

        return $count;
    }

    private function guardarCfdi(SolicitudDescarga $solicitud, array $datos, string $xmlContent): void
    {
        $cliente = $solicitud->cliente;
        $fecha = Carbon::parse($datos['fecha_emision']);
        $xmlPath = sprintf('%s/%s/%s/%s.xml', $cliente->rfc, $fecha->format('Y'), $fecha->format('m'), $datos['uuid']);

        Storage::disk('cfdis')->put($xmlPath, $xmlContent);

        Cfdi::updateOrCreate(
            ['uuid' => $datos['uuid']],
            [
                'cliente_id' => $cliente->id,
                'rfc_emisor' => $datos['rfc_emisor'],
                'nombre_emisor' => $datos['nombre_emisor'],
                'rfc_receptor' => $datos['rfc_receptor'],
                'nombre_receptor' => $datos['nombre_receptor'],
                'tipo' => $solicitud->tipo === 'emitida' ? 'emitida' : 'recibida',
                'categoria' => $datos['categoria'],
                'tipo_comprobante' => $datos['tipo_comprobante'],
                'monto_total' => $datos['monto_total'],
                'moneda' => $datos['moneda'],
                'fecha_emision' => $datos['fecha_emision'],
                'metodo_pago' => $datos['metodo_pago'],
                'forma_pago' => $datos['forma_pago'],
                'serie' => $datos['serie'],
                'folio' => $datos['folio'],
                'xml_path' => $xmlPath,
                'solicitud_descarga_id' => $solicitud->id,
            ]
        );
    }
}
