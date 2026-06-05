@extends('layouts.admin')
@section('title', 'Editar Cliente - ' . $cliente->razon_social)

@section('content')
<div class="max-w-3xl space-y-8">
    <!-- Datos del cliente -->
    <form method="POST" action="{{ route('admin.clientes.update', $cliente) }}" class="bg-white rounded-xl border border-gray-200 p-6">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Datos del Cliente</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">RFC</label>
                <input name="rfc" type="text" required maxlength="13" value="{{ old('rfc', $cliente->rfc) }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50 uppercase"/>
                @error('rfc') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Razon Social</label>
                <input name="razon_social" type="text" required value="{{ old('razon_social', $cliente->razon_social) }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50"/>
                @error('razon_social') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Regimen Fiscal</label>
                <input name="regimen_fiscal" type="text" value="{{ old('regimen_fiscal', $cliente->regimen_fiscal) }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50"/>
            </div>
        </div>
        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
            <span class="material-symbols-outlined text-lg">save</span>
            Guardar Cambios
        </button>
    </form>

    <!-- e.firma -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">e.firma (FIEL)</h2>

        @if($cliente->cer_path)
            <div class="mb-4 p-4 rounded-lg {{ $cliente->tieneEfirmaValida() ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined {{ $cliente->tieneEfirmaValida() ? 'text-green-500' : 'text-red-500' }}">
                        {{ $cliente->tieneEfirmaValida() ? 'verified' : 'gpp_maybe' }}
                    </span>
                    <div>
                        <p class="font-medium {{ $cliente->tieneEfirmaValida() ? 'text-green-700' : 'text-red-700' }}">
                            e.firma {{ $cliente->tieneEfirmaValida() ? 'vigente' : 'vencida' }}
                        </p>
                        <p class="text-sm {{ $cliente->tieneEfirmaValida() ? 'text-green-600' : 'text-red-600' }}">
                            Vigencia: {{ $cliente->efirma_vigencia ? $cliente->efirma_vigencia->format('d/m/Y') : 'No disponible' }}
                            @if($cliente->efirma_uploaded_at)
                                | Subida: {{ $cliente->efirma_uploaded_at->format('d/m/Y H:i') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.clientes.efirma.remove', $cliente) }}" class="mb-6" onsubmit="return confirm('Eliminar la e.firma de este cliente?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 border border-red-300 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors">
                    <span class="material-symbols-outlined text-lg">delete</span>
                    Eliminar e.firma
                </button>
            </form>
        @endif

        <form method="POST" action="{{ route('admin.clientes.efirma.upload', $cliente) }}" enctype="multipart/form-data">
            @csrf
            <p class="text-sm text-accent mb-4">{{ $cliente->cer_path ? 'Reemplazar' : 'Subir' }} archivos de e.firma (.cer y .key)</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Certificado (.cer)</label>
                    <input name="cer_file" type="file" accept=".cer" required class="form-input w-full rounded-lg border-gray-300 text-sm"/>
                    @error('cer_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Llave privada (.key)</label>
                    <input name="key_file" type="file" accept=".key" required class="form-input w-full rounded-lg border-gray-300 text-sm"/>
                    @error('key_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contrasena de la llave</label>
                    <input name="key_password" type="password" required class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50"/>
                    @error('key_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                <span class="material-symbols-outlined text-lg">upload</span>
                Subir e.firma
            </button>
        </form>
    </div>

    <!-- Acceso al portal -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Acceso al Portal del Cliente</h2>

        @if($cliente->clienteAuth)
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700">
                    <span class="font-medium">Email:</span> {{ $cliente->clienteAuth->email }}
                    @if($cliente->clienteAuth->ultimo_acceso)
                        | <span class="font-medium">Ultimo acceso:</span> {{ $cliente->clienteAuth->ultimo_acceso->format('d/m/Y H:i') }}
                    @endif
                </p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.clientes.acceso', $cliente) }}">
            @csrf
            <p class="text-sm text-accent mb-4">{{ $cliente->clienteAuth ? 'Actualizar' : 'Crear' }} credenciales de acceso al portal.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input name="email_acceso" type="email" required value="{{ old('email_acceso', optional($cliente->clienteAuth)->email) }}" class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50"/>
                    @error('email_acceso') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contrasena</label>
                    <input name="password_acceso" type="password" required class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/50" placeholder="Minimo 8 caracteres"/>
                    @error('password_acceso') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                <span class="material-symbols-outlined text-lg">person_add</span>
                {{ $cliente->clienteAuth ? 'Actualizar Acceso' : 'Crear Acceso' }}
            </button>
        </form>
    </div>
</div>
@endsection
