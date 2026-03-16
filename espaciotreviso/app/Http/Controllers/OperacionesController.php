<?php
namespace App\Http\Controllers;

use App\DepositosCliente;
use App\ReembolsosCliente;
use App\OperacionesCliente;
use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperacionesController extends Controller
{
    private function misClientes()
    {
        $user = Auth::user();
        if ($user->IDRol == 1) return Cliente::where('ActivoCliente','A')->pluck('IDCliente');
        return Cliente::where('IDEmpleado', $user->IDEmpleado)->where('ActivoCliente','A')->pluck('IDCliente');
    }

    public function index(Request $request)
    {
        $ids   = $this->misClientes();
        $query = OperacionesCliente::with('cliente')->whereIn('IDCliente', $ids);
        if ($c = $request->cliente) $query->where('IDCliente', $c);
        $operaciones = $query->orderBy('FechaOperacionN','desc')->paginate(50)->appends($request->all());
        $clientes    = Cliente::whereIn('IDCliente', $ids)->orderBy('NombreCliente')->get();
        return view('operaciones.index', compact('operaciones','clientes'));
    }

    public function depositos(Request $request)
    {
        $ids  = $this->misClientes();
        $query = DepositosCliente::with('cliente')->whereIn('IDCliente', $ids);
        if ($c = $request->cliente) $query->where('IDCliente', $c);
        $depositos = $query->orderBy('FechaDeposito','desc')->paginate(50)->appends($request->all());
        $clientes  = Cliente::whereIn('IDCliente', $ids)->orderBy('NombreCliente')->get();
        return view('operaciones.depositos', compact('depositos','clientes'));
    }

    public function reembolsos(Request $request)
    {
        $ids  = $this->misClientes();
        $query = ReembolsosCliente::with('cliente')->whereIn('IDCliente', $ids);
        if ($c = $request->cliente) $query->where('IDCliente', $c);
        $reembolsos = $query->orderBy('FechaReembolso','desc')->paginate(50)->appends($request->all());
        $clientes   = Cliente::whereIn('IDCliente', $ids)->orderBy('NombreCliente')->get();
        return view('operaciones.reembolsos', compact('reembolsos','clientes'));
    }
}