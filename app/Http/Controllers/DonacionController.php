<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donacion;
use Illuminate\Support\Facades\Http;


class DonacionController extends Controller
{
 
    //Muestro la vista del formulario
    public function formulario()
    {
        return view('FormularioDonacion');
    }

    // Proceso los datos del formulario
        public function procesar(Request $request)
        {
            $validated = $request->validate([
                'nombre'          => 'required|string|max:255',
                'apellido'        => 'required|string|max:255',
                'correo'          => 'required|email',
                'telefono'        => 'required|string|max:20',
                'monto'           => 'required|numeric|min:1',
                'moneda'          => 'required|in:GTQ,USD',
                'mensaje'         => 'nullable|string',
                'card_number'     => 'required',
                'card_expiration' => 'required',
                'card_cvv'        => 'required',
            ]);

            // 1. Crear cliente en QPayPro
            $clientePayload = [
                'x_login'           => config('qpaypro.login'),
                'x_private_key'     => config('qpaypro.private_key'),
                'x_api_secret'      => config('qpaypro.api_secret'),
                'x_first_name'      => $validated['nombre'],
                'x_last_name'       => $validated['apellido'],
                'x_email'           => $validated['correo'],
                'x_personal_phone'  => $validated['telefono'],
                'x_country'         => 'Guatemala',
                'x_state'           => 'Guatemala',
                'x_city'            => 'Ciudad',
                'x_zip'             => '01001',
                'x_address'         => 'Dirección no especificada',
            ];

            $clienteResponse = Http::post('https://devbilling.qpaypro.com/api/client/create', $clientePayload);
            $clienteData = $clienteResponse->json();

            if ($clienteData['result'] != 1) {
                return back()->withErrors(['error' => 'Error al crear cliente: ' . $clienteData['responseText']]);
            }

            $clienteId = $clienteData['idClient'];

            // 2. Asociar tarjeta
            [$mes, $anio] = explode('/', $validated['card_expiration']);

            $tarjetaPayload = [
                'x_login'          => config('qpaypro.login'),
                'x_private_key'    => config('qpaypro.private_key'),
                'x_api_secret'     => config('qpaypro.api_secret'),
                'x_client_id'      => $clienteId,
                'cc_number'        => $validated['card_number'],
                'cc_type'          => '001', // Visa
                'cc_cvv'           => $validated['card_cvv'],
                'cc_expire_month'  => $mes,
                'cc_expire_year'   => '20' . $anio, // convertir YY → 20YY
            ];

            $tarjetaResponse = Http::post('https://devbilling.qpaypro.com/api/associate_credit_card', $tarjetaPayload);
            $tarjetaData = $tarjetaResponse->json();

            if ($tarjetaData['result'] != 1) {
                return back()->withErrors(['error' => 'Error al asociar tarjeta: ' . $tarjetaData['responseText']]);
            }

            $ccToken = $tarjetaData['token'];

            // 3. Procesar el pago
            $pagoPayload = [
                'x_login'              => config('qpaypro.login'),
                'x_private_key'        => config('qpaypro.private_key'),
                'x_api_secret'         => config('qpaypro.api_secret'),
                'x_client_id'          => $clienteId,
                'cc_token'             => $ccToken,
                'cc_amount'            => $validated['monto'],
                'x_currency'           => $validated['moneda'],
                'notificacion_factura' => $validated['correo'],
            ];

            $pagoResponse = Http::post('https://devbilling.qpaypro.com/api/payment_token', $pagoPayload);
            $pagoData = $pagoResponse->json();

            // 4. Guardar donación
            $donacion = Donacion::create([
                'nombre_completo'      => $validated['nombre'] . ' ' . $validated['apellido'],
                'correo'               => $validated['correo'],
                'telefono'             => $validated['telefono'],
                'monto'                => $validated['monto'],
                'mensaje'              => $validated['mensaje'] ?? null,
                'moneda'               => $validated['moneda'],
                'estado_pago'          => $pagoData['result'] == 1 ? 'exitoso' : 'fallido',
                'cliente_id'           => $clienteId,
                'cc_token'             => $ccToken,
                'respuesta_qpaypro'    => $pagoData,
            ]);

            return redirect()
                ->back()
                ->with('mensaje', 'Gracias por tu donación. Estado del pago: ' . strtoupper($donacion->estado_pago));
        }

    public function mostrarFormulario(Request $request)
    {
        $monto = $request->query('monto');
         $moneda = $request->query('moneda', 'GTQ');        
        return view('FormularioDonacion', compact('monto', 'moneda'));
    }

}
