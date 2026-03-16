<?php
namespace App\Http\Controllers;

use App\Empleado;
use App\UsuarioEmpleado;
use App\Cliente;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function empleados()
    {
        $empleados = Empleado::with('usuario')->where('ActivoEmpleado','A')->orderBy('NombreEmpleado')->get();
        return view('admin.empleados', compact('empleados'));
    }

    public function clientes()
    {
        $clientes = Cliente::with('empleado')->orderBy('NombreCliente')->paginate(50);
        return view('admin.clientes', compact('clientes'));
    }
}