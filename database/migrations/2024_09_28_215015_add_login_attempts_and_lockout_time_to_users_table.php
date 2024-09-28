<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('login_attempts')->default(0); // Para contar intentos fallidos
            $table->timestamp('lockout_time')->nullable();  // Para guardar cuándo expira el bloqueo
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login_attempts');
            $table->dropColumn('lockout_time');
        });
    }
    
};
