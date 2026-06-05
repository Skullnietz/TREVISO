@extends('layouts.admin')
@section('title', 'Agregar Cliente')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.clientes.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Datos del Cliente</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">RFC</label>
                    <input name="rfc" type="text" required maxlength="13" value="{{ old('rfc') }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50 uppercase" placeholder="XAXX010101000"/>
                    @error('rfc') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Razon Social</label>
                    <input name="razon_social" type="text" required value="{{ old('razon_social') }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50" placeholder="Nombre o razon social"/>
                    @error('razon_social') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Regimen Fiscal</label>
                    <input name="regimen_fiscal" type="text" value="{{ old('regimen_fiscal') }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50" placeholder="601 - General de Ley"/>
                    @error('regimen_fiscal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Acceso al Portal (Opcional)</h2>
            <p class="text-sm text-accent mb-4">Crea credenciales para que el cliente acceda a su portal de facturas.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email de Acceso</label>
                    <input name="email_acceso" type="email" value="{{ old('email_acceso') }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50" placeholder="cliente@email.com"/>
                    @error('email_acceso') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contrasena</label>
                    <input name="password_acceso" type="password" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50" placeholder="Minimo 8 caracteres"/>
                    @error('password_acceso') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                <span class="material-symbols-outlined text-lg">save</span>
                Guardar Cliente
            </button>
            <a href="{{ route('admin.clientes.index') }}" class="px-6 py-2.5 text-gray-600 hover:text-gray-900 text-sm font-medium">Cancelar</a>
        </div>
    </form>
</div>
@endsection
