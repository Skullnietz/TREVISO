<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Mejora de seguridad: amplía Pass_Usuario de varchar(16) a varchar(255)
 * para almacenar hashes bcrypt. Las contraseñas en texto plano se
 * rehashean automáticamente en el primer login (ver AuthController).
 * NOTA: Ya ejecutada directamente vía PDO al aplicar este cambio.
 */
class UpgradePassUsuarioBcrypt extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE usuario MODIFY COLUMN Pass_Usuario VARCHAR(255) NOT NULL');
    }

    public function down()
    {
        // No revertir: reducir a varchar(16) eliminaría los hashes bcrypt existentes
    }
}
