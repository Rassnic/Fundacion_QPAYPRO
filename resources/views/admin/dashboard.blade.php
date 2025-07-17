<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Donaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 30px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .dashboard {
            max-width: 1100px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f0f2f5;
            font-weight: bold;
            color: #34495e;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .exitoso {
            color: green;
            font-weight: bold;
        }

        .fallido {
            color: red;
            font-weight: bold;
        }

        .pendiente {
            color: orange;
            font-weight: bold;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination nav {
            display: inline-block;
        }
    </style>
</head>
<body>

<h1>Dashboard de Donaciones</h1>

<div class="dashboard">
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
                    <td>
                        {{ $donacion->moneda === 'USD' ? '$' : 'Q' }}
                        {{ number_format($donacion->monto, 2) }}
                    </td>
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

    <div class="pagination">
        {{ $donaciones->links() }}
    </div>
</div>

</body>
</html>
