<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fundación Esperanza</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background-image: url('https://images.pexels.com/photos/7142500/pexels-photo-7142500.jpeg?_gl=1*1wlq6xp*_ga*NjA5MDY2ODM0LjE3NTI0NzA1MDM.*_ga_8JE65Q40S6*czE3NTI0NzA1MDMkbzEkZzEkdDE3NTI0NzA2MTQkajkkbDAkaDA.');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
            padding: 6rem 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            text-shadow: 0 2px 4px rgba(0,0,0,0.6);
        }
        .donation-box {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .animate-scroll {
            font-size: 1.2rem;
            animation: pulse 2s infinite;
            opacity: 0.9;
        }

        .arrow-down {
            width: 24px;
            height: 24px;
            border-left: 4px solid white;
            border-bottom: 4px solid white;
            transform: rotate(-45deg);
            margin: 10px auto 0;
            animation: bounce 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }

        @keyframes bounce {
            0%, 100% {
                transform: rotate(-45deg) translateY(0);
            }
            50% {
                transform: rotate(-45deg) translateY(8px);
            }
}
    </style>
</head>
<script>
    function cambiarSimbolo() {
        const moneda = document.getElementById('moneda').value;
        const simbolo = moneda === 'USD' ? '$' : 'Q';
        document.getElementById('currency-symbol').innerText = simbolo;
    }
</script>
<body class="bg-light">

    <div class="hero">
        <h1 class="display-4 fw-bold">100% de tu donación apoya a quienes más lo necesitan</h1>
        <p class="lead">Tu ayuda transforma vidas en comunidades vulnerables de Guatemala.</p>
        <p class="mb-1">⬇ Desliza para hacer tu donación</p>
        <div class="arrow-down"></div>
    </div>

    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="donation-box">
                    <h4 class="mb-3">Haz tu Donación</h4>

                    <form action="/FormularioDonacion" method="GET" class="mb-4" style="max-width: 400px; margin: auto;">
                        <div class="mb-3">
                            <label for="monto">Monto de donación:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="currency-symbol">Q</span>
                                <input type="number" name="monto" id="monto" class="form-control" step="0.01" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="moneda">Moneda:</label>
                            <select name="moneda" id="moneda" class="form-select" required onchange="cambiarSimbolo()">
                                <option value="GTQ" selected>Quetzales (GTQ)</option>
                                <option value="USD">Dólares (USD)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Donar Ahora</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <h3>Nuestra Misión</h3>
                <p>Contribuir al desarrollo integral de comunidades vulnerables mediante programas de salud, educación y alimentación.</p>

                <h5 class="mt-4">¿Cómo puedes ayudar?</h5>
                <ul>
                    <li>Donaciones económicas</li>
                    <li>Voluntariado</li>
                    <li>Compartiendo nuestras campañas</li>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
