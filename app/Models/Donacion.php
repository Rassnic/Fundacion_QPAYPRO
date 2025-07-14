<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    protected $fillable = [
        'nombre_completo',
        'correo',
        'telefono',
        'monto',
        'moneda',
        'mensaje',
        'estado_pago',
        'cliente_id',
        'cc_token',
        'respuesta_qpaypro',
    ];

    protected $casts = [
        'respuesta_qpaypro' => 'array',
    ];
}
