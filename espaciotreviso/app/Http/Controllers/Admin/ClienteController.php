<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Cliente;
use App\ClienteAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('clienteAuth')->orderBy('razon_social')->paginate(20);
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfc' => 'required|string|max:13|unique:clientes,rfc',
            'razon_social' => 'required|string|max:255',
            'regimen_fiscal' => 'nullable|string|max:100',
            'email_acceso' => 'nullable|email|unique:clientes_auth,email',
            'password_acceso' => 'nullable|string|min:8',
        ]);

        $cliente = Cliente::create($request->only('rfc', 'razon_social', 'regimen_fiscal'));

        if ($request->filled('email_acceso') && $request->filled('password_acceso')) {
            ClienteAuth::create([
                'cliente_id' => $cliente->id,
                'email' => $request->input('email_acceso'),
                'password' => Hash::make($request->input('password_acceso')),
            ]);
        }

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    public function edit(Cliente $cliente)
    {
        $cliente->load('clienteAuth');
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'rfc' => 'required|string|max:13|unique:clientes,rfc,' . $cliente->id,
            'razon_social' => 'required|string|max:255',
            'regimen_fiscal' => 'nullable|string|max:100',
        ]);

        $cliente->update($request->only('rfc', 'razon_social', 'regimen_fiscal'));

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $rfc = $cliente->rfc;
        Storage::disk('efirma')->deleteDirectory($rfc);
        Storage::disk('cfdis')->deleteDirectory($rfc);
        $cliente->delete();

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    public function uploadEfirma(Request $request, Cliente $cliente)
    {
        $request->validate([
            'cer_file' => 'required|file|max:50',
            'key_file' => 'required|file|max:50',
            'key_password' => 'required|string',
        ]);

        $rfc = $cliente->rfc;
        $cerPath = $request->file('cer_file')->storeAs($rfc, 'certificado.cer', 'efirma');
        $keyPath = $request->file('key_file')->storeAs($rfc, 'llave.key', 'efirma');

        $cliente->update([
            'cer_path' => $cerPath,
            'key_path' => $keyPath,
            'key_password' => $request->input('key_password'),
            'efirma_uploaded_at' => now(),
        ]);

        return redirect()->route('admin.clientes.edit', $cliente)
            ->with('success', 'e.firma subida exitosamente.');
    }

    public function removeEfirma(Cliente $cliente)
    {
        Storage::disk('efirma')->deleteDirectory($cliente->rfc);

        $cliente->update([
            'cer_path' => null,
            'key_path' => null,
            'key_password' => null,
            'efirma_vigencia' => null,
            'efirma_uploaded_at' => null,
        ]);

        return redirect()->route('admin.clientes.edit', $cliente)
            ->with('success', 'e.firma eliminada.');
    }

    public function crearAcceso(Request $request, Cliente $cliente)
    {
        $request->validate([
            'email_acceso' => 'required|email|unique:clientes_auth,email',
            'password_acceso' => 'required|string|min:8',
        ]);

        $cliente->clienteAuth()->updateOrCreate(
            ['cliente_id' => $cliente->id],
            [
                'email' => $request->input('email_acceso'),
                'password' => Hash::make($request->input('password_acceso')),
                'activo' => true,
            ]
        );

        return redirect()->route('admin.clientes.edit', $cliente)
            ->with('success', 'Acceso al portal creado exitosamente.');
    }
}
