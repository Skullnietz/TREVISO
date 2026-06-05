<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Cfdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FacturaController extends Controller
{
    public function ingresos(Request $request)
    {
        $cfdis = $this->filtrarCfdis($request)
            ->ingresos()
            ->latest('fecha_emision')
            ->paginate(25);

        return view('cliente.facturas.index', [
            'cfdis' => $cfdis,
            'titulo' => 'Ingresos',
            'categoria_activa' => 'ingresos',
        ]);
    }

    public function egresos(Request $request)
    {
        $cfdis = $this->filtrarCfdis($request)
            ->egresos()
            ->latest('fecha_emision')
            ->paginate(25);

        return view('cliente.facturas.index', [
            'cfdis' => $cfdis,
            'titulo' => 'Egresos',
            'categoria_activa' => 'egresos',
        ]);
    }

    public function notasCredito(Request $request)
    {
        $cfdis = $this->filtrarCfdis($request)
            ->notasCredito()
            ->latest('fecha_emision')
            ->paginate(25);

        return view('cliente.facturas.index', [
            'cfdis' => $cfdis,
            'titulo' => 'Notas de Credito',
            'categoria_activa' => 'notas_credito',
        ]);
    }

    public function banco(Request $request)
    {
        $cfdis = $this->filtrarCfdis($request)
            ->banco()
            ->latest('fecha_emision')
            ->paginate(25);

        return view('cliente.facturas.index', [
            'cfdis' => $cfdis,
            'titulo' => 'Facturas de Banco',
            'categoria_activa' => 'banco',
        ]);
    }

    public function pagos(Request $request)
    {
        $cfdis = $this->filtrarCfdis($request)
            ->complementosPago()
            ->latest('fecha_emision')
            ->paginate(25);

        return view('cliente.pagos.index', compact('cfdis'));
    }

    public function nominas(Request $request)
    {
        $cfdis = $this->filtrarCfdis($request)
            ->nominas()
            ->latest('fecha_emision')
            ->paginate(25);

        return view('cliente.nominas.index', compact('cfdis'));
    }

    public function show(Cfdi $cfdi)
    {
        $this->autorizarAcceso($cfdi);
        $cfdi->load(['observaciones.clienteAuth', 'observaciones.usuarioEmpleado']);
        return view('cliente.facturas.show', compact('cfdi'));
    }

    public function downloadXml(Cfdi $cfdi)
    {
        $this->autorizarAcceso($cfdi);

        if (!Storage::disk('cfdis')->exists($cfdi->xml_path)) {
            abort(404, 'Archivo XML no encontrado.');
        }

        return Storage::disk('cfdis')->download($cfdi->xml_path, $cfdi->uuid . '.xml');
    }

    private function filtrarCfdis(Request $request)
    {
        $clienteId = Auth::user()->cliente_id;
        $query = Cfdi::where('cliente_id', $clienteId);

        if ($request->filled('estatus_pago')) {
            $query->where('estatus_pago', $request->estatus_pago);
        }
        if ($request->filled('fecha_desde')) {
            $query->where('fecha_emision', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_emision', '<=', $request->fecha_hasta);
        }
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where(function ($q) use ($busqueda) {
                $q->where('rfc_emisor', 'like', "%{$busqueda}%")
                  ->orWhere('nombre_emisor', 'like', "%{$busqueda}%")
                  ->orWhere('rfc_receptor', 'like', "%{$busqueda}%")
                  ->orWhere('nombre_receptor', 'like', "%{$busqueda}%")
                  ->orWhere('uuid', 'like', "%{$busqueda}%");
            });
        }

        return $query;
    }

    private function autorizarAcceso(Cfdi $cfdi)
    {
        if ($cfdi->cliente_id !== Auth::user()->cliente_id) {
            abort(403);
        }
    }
}
