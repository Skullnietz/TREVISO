<?php
namespace App\Http\Controllers;

use App\Cliente;
use App\Xml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $clientes = $user->IDRol == 1
            ? Cliente::with('empleado')->where('ActivoCliente','A')->orderBy('NombreCliente')->paginate(50)
            : Cliente::with('empleado')->where('IDEmpleado', $user->IDEmpleado)->where('ActivoCliente','A')->orderBy('NombreCliente')->paginate(50);
        return view('clientes.index', compact('clientes'));
    }

    public function show($id)
    {
        $cliente = Cliente::with(['empleado','bancos'])->findOrFail($id);
        $xmlsRecientes = Xml::where('IDCliente',$id)->orderBy('FechaEmisionXML','desc')->limit(20)->get();
        return view('clientes.show', compact('cliente','xmlsRecientes'));
    }
}