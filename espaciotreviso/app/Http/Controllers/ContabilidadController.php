<?php
namespace App\Http\Controllers;

use App\Xml;
use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContabilidadController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Xml::with('cliente')
                    ->where(function($q){ $q->where('ContabilizadoXML','N')->orWhereNull('ContabilizadoXML'); });

        if ($user->IDRol != 1) {
            $ids = Cliente::where('IDEmpleado', $user->IDEmpleado)->pluck('IDCliente');
            $query->whereIn('IDCliente', $ids);
        }
        if ($c = $request->cliente) $query->where('IDCliente', $c);

        $xmls     = $query->orderBy('FechaEmisionXML','desc')->paginate(100)->appends($request->all());
        $clientes = $user->IDRol == 1
            ? Cliente::where('ActivoCliente','A')->orderBy('NombreCliente')->get()
            : Cliente::where('IDEmpleado', $user->IDEmpleado)->where('ActivoCliente','A')->orderBy('NombreCliente')->get();

        return view('contabilidad.index', compact('xmls','clientes'));
    }
}