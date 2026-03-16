<?php
namespace App\Http\Controllers;

use App\Xml;
use App\ComplementoPago;
use App\NotaCredito;
use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CfdiController extends Controller
{
    private function clientesDelUsuario()
    {
        $user = Auth::user();
        if ($user->IDRol == 1) {
            return Cliente::where('ActivoCliente', 'A')->orderBy('NombreCliente')->get();
        }
        return Cliente::where('IDEmpleado', $user->IDEmpleado)
                      ->where('ActivoCliente', 'A')
                      ->orderBy('NombreCliente')->get();
    }

    public function index(Request $request)
    {
        $clientes  = $this->clientesDelUsuario();
        $clienteId = $request->get('cliente');
        $mes       = $request->get('mes');
        $anio      = $request->get('anio', date('Y'));
        $tipo      = $request->get('tipo');  // i=ingresos, e=egresos, n=nomina

        $xmls = collect();

        if ($clienteId) {
            $query = Xml::where('IDCliente', $clienteId);
            if ($mes)  $query->whereMonth('FechaEmisionXML', $mes);
            if ($anio) $query->whereYear('FechaEmisionXML', $anio);
            if ($tipo) $query->where('TipoXML', $tipo);
            $xmls = $query->orderBy('FechaEmisionXML', 'desc')->paginate(50)->appends($request->all());
        }

        return view('cfdi.index', compact('clientes','xmls','clienteId','mes','anio','tipo'));
    }

    public function show($id)
    {
        $xml = Xml::with('cliente')->findOrFail($id);
        return view('cfdi.show', compact('xml'));
    }
}