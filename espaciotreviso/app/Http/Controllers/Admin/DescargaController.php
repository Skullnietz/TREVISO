<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Cliente;
use App\SolicitudDescarga;
use Illuminate\Http\Request;

class DescargaController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudDescarga::with('cliente')
            ->latest()
            ->paginate(20);

        $clientes = Cliente::where('activo', true)
            ->whereNotNull('cer_path')
            ->orderBy('razon_social')
            ->get();

        return view('admin.descargas.index', compact('solicitudes', 'clientes'));
    }

    public function solicitar(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:emitida,recibida',
        ]);

        $cliente = Cliente::findOrFail($request->cliente_id);

        if (!$cliente->tieneEfirmaValida()) {
            return back()->with('error', 'El cliente no tiene una e.firma valida.');
        }

        SolicitudDescarga::create([
            'cliente_id' => $request->cliente_id,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'pendiente',
            'automatica' => false,
        ]);

        return redirect()->route('admin.descargas.index')
            ->with('success', 'Solicitud de descarga creada. Se procesara en breve.');
    }
}
