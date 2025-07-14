<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donacion;


class DonacionController extends Controller
{
    public function formulario()
    {
        return view('FormularioDonacion');
    }

    public function procesar(Request $request)
    {
         $validated = $request->validate([
        'nombre_completo' => 'required|string|max:255',
        'correo'          => 'required|email',
        'telefono'        => 'required|string|max:20',
        'monto'           => 'required|numeric|min:1',
        'mensaje'         => 'nullable|string',
    ]);

    $donacion = Donacion::create([
        'nombre_completo' => $validated['nombre_completo'],
        'correo'          => $validated['correo'],
        'telefono'        => $validated['telefono'],
        'monto'           => $validated['monto'],
        'mensaje'         => $validated['mensaje'] ?? null,
        'moneda'          => 'GTQ',
        'estado_pago'     => 'pendiente',
    ]);

    // Simula cliente y token (serán reales después)
    $clienteId = '59';
    $ccToken   = '66938888841863848040081';

    $respuesta = $this->procesarPagoQPayPro(
        $clienteId,
        $ccToken,
        $donacion->monto,
        $donacion->moneda,
        $donacion->correo
    );

    // Actualiza el estado según respuesta
    $donacion->estado_pago = $respuesta['result'] == 1 ? 'exitoso' : 'fallido';
    $donacion->cliente_id = $clienteId;
    $donacion->cc_token = $ccToken;
    $donacion->respuesta_qpaypro = $respuesta;
    $donacion->save();

    return redirect()
        ->back()
        ->with('mensaje', 'Gracias por tu donación. Estado del pago: ' . strtoupper($donacion->estado_pago));
    }


    private function procesarPagoQPayPro($clienteId, $ccToken, $monto, $moneda = 'GTQ', $correo = null)
    {
        $payload = [
            'x_login'              => config('qpaypro.login'),
            'x_private_key'        => config('qpaypro.private_key'),
            'x_api_secret'         => config('qpaypro.api_secret'),
            'x_client_id'          => $clienteId,
            'cc_token'             => $ccToken,
            'cc_amount'            => $monto,
            'x_currency'           => $moneda,
            'notificacion_factura' => $correo,
        ];

        $response = \Illuminate\Support\Facades\Http::post(config('qpaypro.endpoint'), $payload);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'result' => 0,
                'title' => 'ERROR',
                'responseText' => 'No se pudo contactar con QPayPro',
                'debug' => $response->body(),
            ];
        }
    }

    public function mostrarFormulario(Request $request)
    {
        $monto = $request->query('monto');
        return view('FormularioDonacion', compact('monto'));
    }

}
