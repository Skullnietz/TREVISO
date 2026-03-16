<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\UsuarioEmpleado;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $nick     = $request->input('login');
        $password = $request->input('password');

        $user = UsuarioEmpleado::where('NickUsuarioEmpleado', $nick)
                               ->where('ActivoUsuarioEmpleado', 'A')
                               ->first();

        if (!$user) {
            return back()->withErrors(['login' => 'Credenciales incorrectas.'])->withInput();
        }

        $storedPass = $user->PassUsuarioEmpleado;

        // Migracion transparente: texto plano -> bcrypt en el primer login
        // strpos compatible con PHP 7.x
        if (strpos($storedPass, '$2y$') !== 0) {
            if ($storedPass !== $password) {
                return back()->withErrors(['login' => 'Credenciales incorrectas.'])->withInput();
            }
            $user->PassUsuarioEmpleado = Hash::make($password);
            $user->save();
        } else {
            if (!Hash::check($password, $storedPass)) {
                return back()->withErrors(['login' => 'Credenciales incorrectas.'])->withInput();
            }
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}