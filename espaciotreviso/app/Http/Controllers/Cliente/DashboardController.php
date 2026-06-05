<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Cfdi;
use App\Observacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $clienteId = Auth::user()->cliente_id;

        $stats = [
            'total_facturas' => Cfdi::where('cliente_id', $clienteId)->count(),
            'pendientes' => Cfdi::where('cliente_id', $clienteId)->where('estatus_pago', 'pendiente')->count(),
            'pagadas' => Cfdi::where('cliente_id', $clienteId)->where('estatus_pago', 'pagado')->count(),
            'monto_pendiente' => Cfdi::where('cliente_id', $clienteId)
                ->where('estatus_pago', '!=', 'pagado')
                ->where('categoria', 'factura_ingreso')
                ->sum('monto_total'),
        ];

        $facturas_por_mes = Cfdi::where('cliente_id', $clienteId)
            ->where('fecha_emision', '>=', now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(fecha_emision, '%Y-%m') as mes"),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(monto_total) as monto')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $observaciones_recientes = Observacion::whereHas('cfdi', function ($q) use ($clienteId) {
            $q->where('cliente_id', $clienteId);
        })->with('cfdi')->latest()->take(5)->get();

        return view('cliente.dashboard.index', compact('stats', 'facturas_por_mes', 'observaciones_recientes'));
    }
}
