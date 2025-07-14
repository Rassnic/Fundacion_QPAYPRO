<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donacions', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_completo');
        $table->string('correo');
        $table->string('telefono');
        $table->decimal('monto', 10, 2);
        $table->string('moneda', 3)->default('GTQ');
        $table->text('mensaje')->nullable();
        $table->string('estado_pago')->default('pendiente');
        $table->string('cliente_id')->nullable(); // QPayPro
        $table->string('cc_token')->nullable();   // QPayPro
        $table->json('respuesta_qpaypro')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donacions');
    }
};
