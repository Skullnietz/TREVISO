<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('rfc', 13)->unique();
            $table->string('razon_social');
            $table->string('regimen_fiscal')->nullable();
            $table->string('cer_path')->nullable();
            $table->string('key_path')->nullable();
            $table->text('key_password')->nullable();
            $table->date('efirma_vigencia')->nullable();
            $table->timestamp('efirma_uploaded_at')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
