<?php
namespace App\Http\Middleware;

use Closure;

class EsAdmin
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->IDRol == 1) {
            return $next($request);
        }
        return redirect()->route('dashboard')->with('error', 'Acceso restringido al administrador.');
    }
}