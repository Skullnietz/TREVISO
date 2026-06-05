<?php

namespace App\Services\Sat;

use Carbon\Carbon;

class EfirmaService
{
    public function validar(string $cerPath, string $keyPath, string $password): array
    {
        $cerContent = file_get_contents($cerPath);

        if (!$cerContent) {
            return ['valid' => false, 'error' => 'No se pudo leer el certificado.'];
        }

        $certData = openssl_x509_parse("-----BEGIN CERTIFICATE-----\n" . chunk_split(base64_encode($cerContent), 64, "\n") . "-----END CERTIFICATE-----\n");

        if (!$certData) {
            return ['valid' => false, 'error' => 'Certificado invalido.'];
        }

        $keyContent = file_get_contents($keyPath);
        $pkeyResource = openssl_pkey_get_private($keyContent, $password);

        if (!$pkeyResource) {
            $derKey = $this->convertDerToPem($keyContent, $password);
            if (!$derKey) {
                return ['valid' => false, 'error' => 'Contrasena incorrecta o llave invalida.'];
            }
        }

        $rfc = $this->extraerRfc($certData);
        $nombre = $certData['subject']['O'] ?? $certData['subject']['CN'] ?? '';
        $vigencia = Carbon::createFromTimestamp($certData['validTo_time_t']);

        return [
            'valid' => true,
            'rfc' => $rfc,
            'nombre' => $nombre,
            'vigencia' => $vigencia,
        ];
    }

    private function extraerRfc(array $certData): string
    {
        $serialNumber = $certData['subject']['serialNumber'] ?? '';

        if (preg_match('/[A-Z&Ñ]{3,4}\d{6}[A-Z0-9]{3}/', $serialNumber, $matches)) {
            return $matches[0];
        }

        $uniqueId = $certData['subject']['x500UniqueIdentifier'] ?? '';
        if (preg_match('/[A-Z&Ñ]{3,4}\d{6}[A-Z0-9]{3}/', $uniqueId, $matches)) {
            return $matches[0];
        }

        return $serialNumber;
    }

    private function convertDerToPem(string $derContent, string $password)
    {
        $pkcs8 = @openssl_pkey_get_private(
            "-----BEGIN ENCRYPTED PRIVATE KEY-----\n" .
            chunk_split(base64_encode($derContent), 64, "\n") .
            "-----END ENCRYPTED PRIVATE KEY-----\n",
            $password
        );

        return $pkcs8 ?: null;
    }
}
