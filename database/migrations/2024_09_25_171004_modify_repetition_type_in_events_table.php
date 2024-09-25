<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('repetition_type')->change();  // Cambia el tipo de la columna a VARCHAR
        });
    }
    
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('repetition_type')->change();  // Opción para revertir el cambio
        });
    }
    
};
