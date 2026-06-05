<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Cfdi;
use App\Cliente;
use App\Observacion;
use App\SolicitudDescarga;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clientes' => Cliente::where('activo', true)->count(),
            'efirma_activas' => Cliente::where('activo', true)
                ->whereNotNull('cer_path')
                ->where('efirma_vigencia', '>', now())
                ->count(),
            'efirma_vencidas' => Cliente::where('activo', true)
                ->whereNotNull('cer_path')
                ->where('efirma_vigencia', '<=', now())
                ->count(),
            'cfdis_mes' => Cfdi::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'observaciones_pendientes' => Observacion::where('tipo', 'cliente')
                ->where('leida', false)
                ->count(),
        ];

        $solicitudes_recientes = SolicitudDescarga::with('cliente')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'solicitudes_recientes'));
    }
}
