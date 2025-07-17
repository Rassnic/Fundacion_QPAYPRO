<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Donación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
        }
        .form-container {
            background-color: white;
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: #333;
        }
        label {
            margin-top: 15px;
            font-weight: 500;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #198754;
            background: #d1e7dd;
        }
        .alert.error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .btn-submit {
            margin-top: 25px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Haz tu Donación</h1>

    @if(session('mensaje'))
        <div class="alert">
            {{ session('mensaje') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('donacion.procesar') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                       value="{{ old('nombre', 'Juan') }}" required>
            </div>

            <div class="col-md-6">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control"
                       value="{{ old('apellido', 'Pérez') }}" required>
            </div>
        </div>

        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo" class="form-control"
               value="{{ old('correo', 'juanperez@example.com') }}" required>

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" class="form-control"
               value="{{ old('telefono', '12345678') }}" required>

        <div class="row">
            <div class="col-md-6">
                <label for="monto">Monto de Donación</label>
                <input type="number" step="0.01" id="monto" name="monto" class="form-control"
                       value="{{ old('monto', $monto ?? '50') }}" required>
            </div>
            <div class="col-md-6">
                <label for="moneda">Moneda</label>
                <select id="moneda" name="moneda" class="form-select" required>
                    <option value="GTQ" {{ old('moneda', $moneda ?? '') == 'GTQ' ? 'selected' : '' }}>Quetzales (GTQ)</option>
                    <option value="USD" {{ old('moneda', $moneda ?? '') == 'USD' ? 'selected' : '' }}>Dólares (USD)</option>
                </select>
            </div>
        </div>

        <label for="mensaje">Mensaje (opcional)</label>
        <textarea id="mensaje" name="mensaje" class="form-control" rows="3">{{ old('mensaje', 'Apoyando a la causa') }}</textarea>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <label for="card_number">Número de tarjeta</label>
                <input type="text" id="card_number" name="card_number" class="form-control"
                       value="4111111111111111" >
            </div>
            <div class="col-md-3">
                <label for="card_expiration">Expiración (MM/YY)</label>
                <input type="text" id="card_expiration" name="card_expiration" class="form-control"
                       value="12/27" >
            </div>
            <div class="col-md-3">
                <label for="card_cvv">CVV</label>
                <input type="text" id="card_cvv" name="card_cvv" class="form-control"
                       value="123" >
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg w-100 btn-submit">Donar Ahora</button>
    </form>
</div>

</body>
</html>
