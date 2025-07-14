<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Donación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        label { display: block; margin-top: 15px; }
        input, textarea, button, select {
            width: 100%; padding: 10px; margin-top: 5px;
            border-radius: 5px; border: 1px solid #ccc;
        }
        button { background-color: #28a745; color: white; font-weight: bold; border: none; }
        .alert { background: #d4edda; padding: 15px; margin-bottom: 20px; border-left: 5px solid #28a745; }
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>

    <h1>Haz tu Donación</h1>

    @if(session('mensaje'))
        <div class="alert">
            {{ session('mensaje') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert" style="background: #f8d7da; border-left-color: #dc3545;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('donacion.procesar') }}" method="POST">
        @csrf

        <label for="nombre_completo">Nombre completo</label>
        <input type="text" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required>

        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required>

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" required>

        <label for="Donación">Donación</label>
        <input 
            type="number" 
            step="0.01" 
            id="monto" 
            name="monto" 
            value="{{ old('monto', $monto ?? '') }}" 
            required
        >

        <label for="mensaje">Mensaje (opcional)</label>
        <textarea id="mensaje" name="mensaje" rows="3">{{ old('mensaje') }}</textarea>

        <button type="submit">Donar Ahora</button>
    </form>

</body>
</html>
