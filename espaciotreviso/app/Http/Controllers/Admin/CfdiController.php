<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Cfdi;
use App\Cliente;
use App\Observacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CfdiController extends Controller
{
    public function index(Request $request)
    {
        $query = Cfdi::with('cliente');

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
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
                $q->where('uuid', 'like', "%{$busqueda}%")
                  ->orWhere('rfc_emisor', 'like', "%{$busqueda}%")
                  ->orWhere('rfc_receptor', 'like', "%{$busqueda}%")
                  ->orWhere('nombre_emisor', 'like', "%{$busqueda}%")
                  ->orWhere('nombre_receptor', 'like', "%{$busqueda}%");
            });
        }

        $cfdis = $query->latest('fecha_emision')->paginate(25);
        $clientes = Cliente::where('activo', true)->orderBy('razon_social')->get();

        return view('admin.facturas.index', compact('cfdis', 'clientes'));
    }

    public function show(Cfdi $cfdi)
    {
        $cfdi->load(['cliente', 'observaciones.clienteAuth', 'observaciones.usuarioEmpleado']);
        return view('admin.facturas.show', compact('cfdi'));
    }

    public function actualizarPago(Request $request, Cfdi $cfdi)
    {
        $request->validate([
            'estatus_pago' => 'required|in:pendiente,parcial,pagado',
            'metodo_pago_real' => 'nullable|string|max:100',
            'fecha_pago' => 'nullable|date',
            'referencia_pago' => 'nullable|string|max:100',
        ]);

        $cfdi->update($request->only('estatus_pago', 'metodo_pago_real', 'fecha_pago', 'referencia_pago'));

        return redirect()->route('admin.facturas.show', $cfdi)
            ->with('success', 'Estado de pago actualizado.');
    }

    public function responderObservacion(Request $request, Cfdi $cfdi)
    {
        $request->validate([
            'mensaje' => 'required|string|max:2000',
        ]);

        Observacion::create([
            'cfdi_id' => $cfdi->id,
            'usuario_empleado_id' => Auth::guard('admin')->id(),
            'mensaje' => $request->mensaje,
            'tipo' => 'contador',
        ]);

        return redirect()->route('admin.facturas.show', $cfdi)
            ->with('success', 'Respuesta enviada.');
    }

    public function downloadXml(Cfdi $cfdi)
    {
        if (!Storage::disk('cfdis')->exists($cfdi->xml_path)) {
            abort(404, 'Archivo XML no encontrado.');
        }

        return Storage::disk('cfdis')->download($cfdi->xml_path, $cfdi->uuid . '.xml');
    }
}
