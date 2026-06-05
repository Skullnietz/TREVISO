<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaquetesDescargaTable extends Migration
{
    public function up()
    {
        Schema::create('paquetes_descarga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_descarga_id');
            $table->string('id_paquete');
            $table->enum('estado', ['pendiente', 'descargado', 'procesado', 'error'])->default('pendiente');
            $table->string('zip_path')->nullable();
            $table->unsignedInteger('cfdis_count')->default(0);
            $table->text('error_mensaje')->nullable();
            $table->timestamps();

            $table->foreign('solicitud_descarga_id')->references('id')->on('solicitudes_descarga')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('paquetes_descarga');
    }
}
