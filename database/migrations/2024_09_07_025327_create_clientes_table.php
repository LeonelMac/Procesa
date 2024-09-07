<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre'); // Nombre del cliente
            $table->string('apellido')->nullable(); // Apellido del cliente
            $table->string('email')->unique(); // Correo electrónico único
            $table->string('telefono')->nullable(); // Teléfono del cliente
            $table->string('direccion')->nullable(); // Dirección del cliente
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
