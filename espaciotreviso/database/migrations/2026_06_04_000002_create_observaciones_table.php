<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionesTable extends Migration
{
    public function up()
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cfdi_id');
            $table->unsignedBigInteger('cliente_auth_id')->nullable();
            $table->unsignedBigInteger('usuario_empleado_id')->nullable();
            $table->text('mensaje');
            $table->enum('tipo', ['cliente', 'contador']);
            $table->boolean('leida')->default(false);
            $table->timestamps();

            $table->foreign('cfdi_id')->references('id')->on('cfdis')->onDelete('cascade');
            $table->foreign('cliente_auth_id')->references('id')->on('clientes_auth')->onDelete('set null');
            $table->index(['cfdi_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('observaciones');
    }
}
