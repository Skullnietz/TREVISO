<?php
namespace App\Http\Controllers;

use App\Xml;
use App\DepositosCliente;
use App\ReembolsosCliente;
use App\OperacionesCliente;
use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mes  = $request->get('mes',  date('m'));
        $anio = $request->get('anio', date('Y'));

        $ids = $user->IDRol == 1
            ? Cliente::where('ActivoCliente','A')->pluck('IDCliente')
            : Cliente::where('IDEmpleado', $user->IDEmpleado)->where('ActivoCliente','A')->pluck('IDCliente');

        $xmlsMes       = Xml::whereIn('IDCliente',$ids)->whereYear('FechaEmisionXML',$anio)->whereMonth('FechaEmisionXML',$mes)->count();
        $montoMes      = Xml::whereIn('IDCliente',$ids)->whereYear('FechaEmisionXML',$anio)->whereMonth('FechaEmisionXML',$mes)->sum('MontoPagoXML');
        $depositosMes  = DepositosCliente::whereIn('IDCliente',$ids)->whereYear('FechaDeposito',$anio)->whereMonth('FechaDeposito',$mes)->sum('TotalDeposito');
        $reembolsosMes = ReembolsosCliente::whereIn('IDCliente',$ids)->whereYear('FechaReembolso',$anio)->whereMonth('FechaReembolso',$mes)->sum('TotalReembolso');

        $porCliente = Xml::select('IDCliente', DB::raw('COUNT(*) as total'), DB::raw('SUM(MontoPagoXML) as monto'))
            ->whereIn('IDCliente',$ids)->whereYear('FechaEmisionXML',$anio)->whereMonth('FechaEmisionXML',$mes)
            ->groupBy('IDCliente')->with('cliente')->get();

        return view('reportes.index', compact('mes','anio','xmlsMes','montoMes','depositosMes','reembolsosMes','porCliente'));
    }
}