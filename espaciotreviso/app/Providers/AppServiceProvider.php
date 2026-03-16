<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Cliente;
use App\Xml;
use App\DepositosCliente;
use App\ReembolsosCliente;
use App\OperacionesCliente;

class AppServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        // Inyectar contadores de navbar en todas las vistas que extienden layouts.app
        View::composer('layouts.app', function ($view) {
            if (!Auth::check()) {
                $view->with('navCounts', []);
                return;
            }

            $user    = Auth::user();
            $esAdmin = $user->IDRol == 1;

            if ($esAdmin) {
                $clienteIds = Cliente::where('ActivoCliente', 'A')->pluck('IDCliente');
            } else {
                $clienteIds = Cliente::where('IDEmpleado', $user->IDEmpleado)
                                     ->where('ActivoCliente', 'A')
                                     ->pluck('IDCliente');
            }

            $xmlPendientes  = Xml::whereIn('IDCliente', $clienteIds)
                                 ->where(function($q){ $q->where('ContabilizadoXML','N')->orWhereNull('ContabilizadoXML'); })
                                 ->count();
            $depPendientes  = DepositosCliente::whereIn('IDCliente', $clienteIds)
                                              ->where('Contabilizado','N')->where('Activo','S')->count();
            $reemPendientes = ReembolsosCliente::whereIn('IDCliente', $clienteIds)
                                               ->where('Contabilizado','N')->where('Activo','S')->count();
            $ncfdiPendientes = OperacionesCliente::whereIn('IDCliente', $clienteIds)
                                                 ->where('Contabilizado','N')->count();
            $noSaldados     = Xml::whereIn('IDCliente', $clienteIds)->where('SaldadoXML','N')->count();

            $view->with('navCounts', [
                'xmlPendientes'      => $xmlPendientes,
                'depPendientes'      => $depPendientes,
                'reemPendientes'     => $reemPendientes,
                'ncfdiPendientes'    => $ncfdiPendientes,
                'noSaldados'         => $noSaldados,
                'totalPendientes'    => $xmlPendientes + $depPendientes + $reemPendientes + $ncfdiPendientes,
                'pendientesDeposito' => $depPendientes,
                'pendientesReembolso'=> $reemPendientes,
            ]);
        });
    }
}