<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UsuarioEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = UsuarioEmpleado::where('NickUsuarioEmpleado', $request->input('login'))->first();

        if ($user) {
            if (!str_starts_with($user->PassUsuarioEmpleado, '$2y$')) {
                if ($user->PassUsuarioEmpleado === $request->input('password')) {
                    $user->PassUsuarioEmpleado = Hash::make($request->input('password'));
                    $user->save();
                    Auth::guard('admin')->login($user);
                    $request->session()->regenerate();
                    return redirect()->intended(route('admin.dashboard'));
                }
            } else {
                if (Hash::check($request->input('password'), $user->PassUsuarioEmpleado)) {
                    Auth::guard('admin')->login($user);
                    $request->session()->regenerate();
                    return redirect()->intended(route('admin.dashboard'));
                }
            }
        }

        return back()->withErrors(['login' => 'Credenciales incorrectas.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
