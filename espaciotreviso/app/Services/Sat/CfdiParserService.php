<?php

namespace App\Services\Sat;

class CfdiParserService
{
    public function parsearXml(string $xmlContent): array
    {
        $xml = simplexml_load_string($xmlContent);
        $xml->registerXPathNamespace('cfdi', 'http://www.sat.gob.mx/cfd/4');
        $xml->registerXPathNamespace('cfdi3', 'http://www.sat.gob.mx/cfd/3');
        $xml->registerXPathNamespace('tfd', 'http://www.sat.gob.mx/TimbreFiscalDigital');
        $xml->registerXPathNamespace('nomina', 'http://www.sat.gob.mx/nomina12');
        $xml->registerXPathNamespace('pago20', 'http://www.sat.gob.mx/Pagos20');
        $xml->registerXPathNamespace('pago10', 'http://www.sat.gob.mx/Pagos');

        $attrs = $xml->attributes();
        $emisor = $xml->Emisor->attributes();
        $receptor = $xml->Receptor->attributes();

        $timbre = $xml->xpath('//tfd:TimbreFiscalDigital');
        $uuid = $timbre ? (string) $timbre[0]->attributes()['UUID'] : null;

        $tipoComprobante = (string) $attrs['TipoDeComprobante'];
        $categoria = $this->clasificar($tipoComprobante, $xml);

        return [
            'uuid' => $uuid,
            'rfc_emisor' => (string) $emisor['Rfc'],
            'nombre_emisor' => (string) ($emisor['Nombre'] ?? ''),
            'rfc_receptor' => (string) $receptor['Rfc'],
            'nombre_receptor' => (string) ($receptor['Nombre'] ?? ''),
            'tipo_comprobante' => $tipoComprobante,
            'categoria' => $categoria,
            'monto_total' => (float) $attrs['Total'],
            'moneda' => (string) ($attrs['Moneda'] ?? 'MXN'),
            'fecha_emision' => (string) $attrs['Fecha'],
            'metodo_pago' => (string) ($attrs['MetodoPago'] ?? null),
            'forma_pago' => (string) ($attrs['FormaPago'] ?? null),
            'serie' => (string) ($attrs['Serie'] ?? null),
            'folio' => (string) ($attrs['Folio'] ?? null),
        ];
    }

    private function clasificar(string $tipoComprobante, \SimpleXMLElement $xml): string
    {
        switch ($tipoComprobante) {
            case 'I':
                return 'factura_ingreso';
            case 'E':
                return 'factura_egreso';
            case 'P':
                return 'complemento_pago';
            case 'N':
                return 'nomina';
            case 'T':
                return 'traslado';
            default:
                return 'factura_ingreso';
        }
    }
}
