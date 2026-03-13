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
            'login' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('password');
        $loginField = $request->input('login');

        // Allow logging in with either username (NickUsuarioEmpleado) or email (if it existed, though mainly Nick in this db).
        // Let's assume login field corresponds to NickUsuarioEmpleado
        $user = UsuarioEmpleado::where('NickUsuarioEmpleado', $loginField)->first();

        if ($user) {
            // Check if the current stored password is NOT hashed (Bcrypt hashes start with $2y$)
            if (!str_starts_with($user->PassUsuarioEmpleado, '$2y$')) {
                // If it evaluates to plain text, check plain text equality
                if ($user->PassUsuarioEmpleado === $request->input('password')) {
                    // It's a match! Securely hash it and update the DB transparently
                    $user->PassUsuarioEmpleado = Hash::make($request->input('password'));
                    $user->save();
                    
                    // Now log them in
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->intended('dashboard');
                }
            } else {
                // The password is already securely hashed, attempt standard Auth flow
                if (Hash::check($request->input('password'), $user->PassUsuarioEmpleado)) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->intended('dashboard');
                }
            }
        }

        return back()->withErrors(['login' => 'Credenciales incorrectas.'])->withInput();
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
