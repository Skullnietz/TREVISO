<?php
namespace App\Http\Controllers;

use App\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificacionesController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $hoy   = date('Y-m-d');
        $notificaciones = Notificacion::where('IDUsuarioEmpleadoDestinatario', $user->IDUsuarioEmpleado)
                            ->where('CaducidadFechaNotificacion', '>=', $hoy)
                            ->orderBy('FechaNotificacion', 'desc')->get();
        return view('notificaciones.index', compact('notificaciones'));
    }
}