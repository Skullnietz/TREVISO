<?php
namespace App\Http\Controllers;

use App\Slide;
use App\Xml;
use App\Cliente;
use App\SolicitudEdicion;
use App\SolicitudEdicionObjeto;
use App\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $esAdmin = ($user->IDRol == 1);

        // ── Scoping: admin ve todo, colaborador solo sus clientes ──
        if ($esAdmin) {
            $xmlQuery    = Xml::query();
            $clienteIds  = null; // all
            $totalClientes = Cliente::where('ActivoCliente','A')->count();
        } else {
            $clienteIds = Cliente::where('IDEmpleado', $user->IDEmpleado)
                                 ->where('ActivoCliente','A')
                                 ->pluck('IDCliente');
            $xmlQuery    = Xml::whereIn('IDCliente', $clienteIds);
            $totalClientes = $clienteIds->count();
        }

        // ── Stat cards ──
        $totalXml        = (clone $xmlQuery)->count();
        $pendientesConta = (clone $xmlQuery)->where(function($q){
            $q->where('ContabilizadoXML','N')->orWhereNull('ContabilizadoXML');
        })->count();

        if ($esAdmin) {
            $solicitudes = SolicitudEdicion::where('Atendida','N')->count()
                         + SolicitudEdicionObjeto::where('Atendida','N')->count();
        } else {
            $solicitudes = SolicitudEdicion::where('IDEmpleado',$user->IDEmpleado)->where('Atendida','N')->count()
                         + SolicitudEdicionObjeto::where('IDEmpleado',$user->IDEmpleado)->where('Atendida','N')->count();
        }

        // ── CHART 1: XMLs por mes últimos 6 meses ──
        $meses6 = DB::select("
            SELECT DATE_FORMAT(FechaEmisionXML,'%b %Y') as mes,
                   DATE_FORMAT(FechaEmisionXML,'%Y-%m') as mes_ord,
                   COUNT(*) as total
            FROM xml
            WHERE FechaEmisionXML >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(FechaEmisionXML,'%Y-%m'), DATE_FORMAT(FechaEmisionXML,'%b %Y')
            ORDER BY mes_ord ASC
        ");
        $chart1Labels = array_column($meses6,'mes');
        $chart1Data   = array_map('intval', array_column($meses6,'total'));

        // ── CHART 2: Tipo XML ──
        $tipoMap = ['e'=>'Egresos','i'=>'Ingresos','n'=>'Nómina','o'=>'Otros'];
        $tipoRaw = DB::select("SELECT TipoXML, COUNT(*) as total FROM xml GROUP BY TipoXML ORDER BY total DESC");
        $chart2Labels = [];
        $chart2Data   = [];
        foreach ($tipoRaw as $t) {
            $chart2Labels[] = isset($tipoMap[$t->TipoXML]) ? $tipoMap[$t->TipoXML] : strtoupper($t->TipoXML);
            $chart2Data[]   = (int)$t->total;
        }

        // ── CHART 3: Depósitos vs Reembolsos por mes ──
        $mesesDep = DB::select("
            SELECT DATE_FORMAT(FechaDeposito,'%b %Y') as mes,
                   DATE_FORMAT(FechaDeposito,'%Y-%m') as mes_ord,
                   SUM(TotalDeposito) as total
            FROM depositoscliente
            WHERE FechaDeposito >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
              AND FechaDeposito <= NOW()
            GROUP BY DATE_FORMAT(FechaDeposito,'%Y-%m'), DATE_FORMAT(FechaDeposito,'%b %Y')
            ORDER BY mes_ord ASC
        ");
        $mesesReem = DB::select("
            SELECT DATE_FORMAT(FechaReembolso,'%b %Y') as mes,
                   DATE_FORMAT(FechaReembolso,'%Y-%m') as mes_ord,
                   SUM(TotalReembolso) as total
            FROM reembolsoscliente
            WHERE FechaReembolso >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
              AND FechaReembolso <= NOW()
            GROUP BY DATE_FORMAT(FechaReembolso,'%Y-%m'), DATE_FORMAT(FechaReembolso,'%b %Y')
            ORDER BY mes_ord ASC
        ");

        // Unify labels
        $labelsOp = array_unique(array_merge(
            array_column($mesesDep,'mes'),
            array_column($mesesReem,'mes')
        ));
        $depMap   = array_column($mesesDep,  'total','mes');
        $reemMap  = array_column($mesesReem, 'total','mes');
        $chart3Labels   = array_values($labelsOp);
        $chart3Deposits = array_map(function($m) use($depMap){  return round((float)($depMap[$m]  ?? 0),2); }, $chart3Labels);
        $chart3Reembolsos = array_map(function($m) use($reemMap){ return round((float)($reemMap[$m] ?? 0),2); }, $chart3Labels);

        // ── CHART 4: Clientes por empleado (only admin) ──
        $chart4Labels = [];
        $chart4Data   = [];
        if ($esAdmin) {
            $cliEmp = DB::select("
                SELECT e.NombreEmpleado as nombre, COUNT(c.IDCliente) as total
                FROM cliente c JOIN empleado e ON c.IDEmpleado=e.IDEmpleado
                WHERE c.ActivoCliente='A'
                GROUP BY e.IDEmpleado, e.NombreEmpleado
                ORDER BY total DESC LIMIT 8
            ");
            $chart4Labels = array_column($cliEmp,'nombre');
            $chart4Data   = array_map('intval', array_column($cliEmp,'total'));
        }

        // ── Top 5 clientes por XMLs ──
        $topClientes = DB::select("
            SELECT c.NombreCliente, COUNT(x.IDXML) as total
            FROM xml x JOIN cliente c ON x.IDCliente=c.IDCliente
            GROUP BY x.IDCliente, c.NombreCliente
            ORDER BY total DESC LIMIT 5
        ");

        // ── Notificaciones recientes ──
        $notificaciones = Notificacion::orderBy('FechaNotificacion','desc')->take(5)->get();

        return view('dashboard.index', compact(
            'totalXml','totalClientes','pendientesConta','solicitudes',
            'chart1Labels','chart1Data',
            'chart2Labels','chart2Data',
            'chart3Labels','chart3Deposits','chart3Reembolsos',
            'chart4Labels','chart4Data',
            'topClientes','notificaciones',
            'esAdmin'
        ));
    }
}