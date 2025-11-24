@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Solicitar Cita</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-700 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('citas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nombre Completo</label>
                <input type="text" name="nombre" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('nombre') }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Teléfono</label>
                <input type="tel" name="telefono" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('telefono') }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tipo de Consulta</label>
                <select name="tipo_consulta" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Selecciona un tipo</option>
                    <option value="asesoría legal">Asesoría Legal</option>
                    <option value="trámite administrativo">Trámite Administrativo</option>
                    <option value="defensa penal">Defensa Penal</option>
                    <option value="derechos laborales">Derechos Laborales</option>
                    <option value="familia">Familia</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Descripción del Caso</label>
                <textarea name="descripcion" required rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Documento de Identidad (Opcional)</label>
                <input type="text" name="documento_identidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('documento_identidad') }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Ubicación (Opcional)</label>
                <input type="text" name="ubicacion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('ubicacion') }}">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">
                Solicitar Cita
            </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-6">
            Nos contactaremos a la brevedad para confirmar tu cita
        </p>
    </div>
</div>
@endsection
