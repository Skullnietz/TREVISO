<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXmlsTable extends Migration
{
    public function up()
    {
        Schema::create('cfdis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('uuid', 36)->unique();
            $table->string('rfc_emisor', 13);
            $table->string('nombre_emisor')->nullable();
            $table->string('rfc_receptor', 13);
            $table->string('nombre_receptor')->nullable();
            $table->enum('tipo', ['emitida', 'recibida']);
            $table->enum('categoria', ['factura_ingreso', 'factura_egreso', 'nota_credito', 'complemento_pago', 'nomina', 'traslado']);
            $table->string('tipo_comprobante', 1);
            $table->decimal('monto_total', 18, 2);
            $table->string('moneda', 3)->default('MXN');
            $table->dateTime('fecha_emision');
            $table->dateTime('fecha_timbrado')->nullable();
            $table->string('metodo_pago', 3)->nullable();
            $table->string('forma_pago', 2)->nullable();
            $table->string('serie')->nullable();
            $table->string('folio')->nullable();
            $table->enum('estatus_sat', ['vigente', 'cancelado'])->default('vigente');
            $table->enum('estatus_pago', ['pendiente', 'parcial', 'pagado'])->default('pendiente');
            $table->string('metodo_pago_real')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('referencia_pago')->nullable();
            $table->string('xml_path');
            $table->unsignedBigInteger('solicitud_descarga_id')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->index(['cliente_id', 'categoria']);
            $table->index(['cliente_id', 'fecha_emision']);
            $table->index('rfc_emisor');
            $table->index('rfc_receptor');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cfdis');
    }
}
