@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Contáctanos</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-700 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contacto.store') }}" method="POST" class="space-y-4">
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
                <label class="block text-gray-700 font-semibold mb-2">Teléfono (Opcional)</label>
                <input type="tel" name="telefono" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('telefono') }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Asunto</label>
                <input type="text" name="asunto" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ old('asunto') }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Mensaje</label>
                <textarea name="mensaje" required rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('mensaje') }}</textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">
                Enviar Mensaje
            </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-6">
            Responderemos tu mensaje en las próximas 24 horas
        </p>
    </div>
</div>
@endsection
