<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Donaciones</title>
    <style>
        body { font-family: sans-serif; margin: 30px; }
        h1 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f8f8f8; }
        .exitoso { color: green; font-weight: bold; }
        .fallido { color: red; font-weight: bold; }
        .pendiente { color: orange; font-weight: bold; }
    </style>
</head>
<body>

<h1>Listado de Donaciones</h1>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Monto</th>
            <th>Moneda</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @forelse($donaciones as $donacion)
            <tr>
                <td>{{ $donacion->nombre_completo }}</td>
                <td>{{ $donacion->correo }}</td>
                <td>{{ $donacion->telefono }}</td>
                <td>Q{{ number_format($donacion->monto, 2) }}</td>
                <td>{{ $donacion->moneda }}</td>
                <td class="{{ $donacion->estado_pago }}">
                    {{ ucfirst($donacion->estado_pago) }}
                </td>
                <td>{{ $donacion->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No hay donaciones registradas aún.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $donaciones->links() }}

</body>
</html>
