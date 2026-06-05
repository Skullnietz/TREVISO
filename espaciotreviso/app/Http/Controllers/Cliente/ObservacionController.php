<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Cfdi;
use App\Observacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObservacionController extends Controller
{
    public function index()
    {
        $clienteId = Auth::user()->cliente_id;

        $observaciones = Observacion::whereHas('cfdi', function ($q) use ($clienteId) {
            $q->where('cliente_id', $clienteId);
        })
        ->with('cfdi')
        ->latest()
        ->paginate(20);

        return view('cliente.observaciones.index', compact('observaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cfdi_id' => 'required|exists:cfdis,id',
            'mensaje' => 'required|string|max:2000',
        ]);

        $cfdi = Cfdi::findOrFail($request->cfdi_id);

        if ($cfdi->cliente_id !== Auth::user()->cliente_id) {
            abort(403);
        }

        Observacion::create([
            'cfdi_id' => $cfdi->id,
            'cliente_auth_id' => Auth::id(),
            'mensaje' => $request->mensaje,
            'tipo' => 'cliente',
        ]);

        return redirect()->route('cliente.facturas.show', $cfdi)
            ->with('success', 'Observacion enviada al contador.');
    }
}
