<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tablas del sistema legacy. Se crean solo si no existen,
 * para no fallar en entornos ya instalados.
 */
class CreateLegacySystemTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('empleado')) {
            Schema::create('empleado', function (Blueprint $table) {
                $table->integer('ID_Empleado')->autoIncrement()->primary();
                $table->string('Nombre_Empleado', 120);
                $table->string('Apellido_P_Empleado', 120);
                $table->string('Apellido_M_Empleado', 120);
                $table->char('Status_Empleado', 1)->default('A');
            });
        }

        if (!Schema::hasTable('usuario')) {
            Schema::create('usuario', function (Blueprint $table) {
                $table->integer('ID_Usuario')->autoIncrement()->primary();
                $table->string('Nombre_Usuario', 8);
                $table->string('Pass_Usuario', 255);
                $table->char('Status_Usuario', 1)->default('A');
                $table->integer('ID_Empleado');
                $table->integer('ID_Rol');
            });
        }

        if (!Schema::hasTable('rol')) {
            Schema::create('rol', function (Blueprint $table) {
                $table->integer('ID_Rol')->autoIncrement()->primary();
                $table->string('Descripcion_Rol', 120);
                $table->integer('ID_Usuario')->nullable();
            });
        }

        if (!Schema::hasTable('actividad')) {
            Schema::create('actividad', function (Blueprint $table) {
                $table->integer('ID_Actividad')->autoIncrement()->primary();
                $table->string('Descripcion_Actividad', 120);
                $table->integer('ID_Rol');
            });
        }

        if (!Schema::hasTable('empresa')) {
            Schema::create('empresa', function (Blueprint $table) {
                $table->integer('ID_Empresa')->autoIncrement()->primary();
                $table->string('Nombre_Empresa', 200);
                $table->integer('ID_Empleado');
                $table->char('Status_Empresa', 1)->default('A');
            });
        }

        if (!Schema::hasTable('extra_anio')) {
            Schema::create('extra_anio', function (Blueprint $table) {
                $table->integer('ID_Extra_Anio')->autoIncrement()->primary();
                $table->text('Extra_Anio');
                $table->integer('ID_Empleado');
            });
        }

        if (!Schema::hasTable('extra_mes')) {
            Schema::create('extra_mes', function (Blueprint $table) {
                $table->integer('ID_Extra_Mes')->autoIncrement()->primary();
                $table->integer('Extra_Mes');
                $table->integer('ID_Empleado')->nullable();
            });
        }

        if (!Schema::hasTable('reporte_usuario')) {
            Schema::create('reporte_usuario', function (Blueprint $table) {
                $table->integer('ID_Reporte_Usuario')->autoIncrement()->primary();
                $table->date('Fecha_Reporte_Usuario');
                $table->string('Comentario_Reporte_Usuario', 200);
                $table->integer('Mes_Reporte');
                $table->text('Anio_Reporte')->nullable();
                $table->integer('ID_Usuario');
                $table->integer('ID_Empresa');
                $table->integer('ID_Actividad');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('reporte_usuario');
        Schema::dropIfExists('extra_mes');
        Schema::dropIfExists('extra_anio');
        Schema::dropIfExists('empresa');
        Schema::dropIfExists('actividad');
        Schema::dropIfExists('rol');
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('empleado');
    }
}
