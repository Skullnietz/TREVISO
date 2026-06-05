<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesDescargaTable extends Migration
{
    public function up()
    {
        Schema::create('solicitudes_descarga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->enum('tipo', ['emitida', 'recibida']);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('request_id')->nullable();
            $table->enum('estado', [
                'pendiente', 'solicitada', 'verificando',
                'lista', 'descargando', 'completada', 'error'
            ])->default('pendiente');
            $table->unsignedInteger('paquetes_total')->default(0);
            $table->unsignedInteger('paquetes_descargados')->default(0);
            $table->unsignedInteger('cfdis_procesados')->default(0);
            $table->text('error_mensaje')->nullable();
            $table->boolean('automatica')->default(false);
            $table->timestamp('solicitada_at')->nullable();
            $table->timestamp('completada_at')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->index(['cliente_id', 'estado']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes_descarga');
    }
}
