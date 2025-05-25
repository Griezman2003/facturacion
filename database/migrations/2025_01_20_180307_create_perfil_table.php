<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('tipo_persona', ['moral', 'fisica']);
            $table->string('nombre_fiscal');
            $table->string('email')->unique();
            $table->string('telefono');
            $table->enum('tamano_empresa', ['micro', 'pequena', 'mediana', 'grande']);
            $table->unsignedBigInteger('regimen_fiscal');
            $table->string('ocupacion');
            $table->string('nombre_comercial');
            $table->string('codigo_postal');
            $table->string('calle');
            $table->string('numero_exterior');
            $table->string('num_interior');
            $table->string('colonia');
            $table->string('municipio');
            $table->string('estado');
            $table->string('pais');
            // $table->longText('key_file');
            // $table->longText('cer_file');
            // $table->string('key_password', 255);  
            $table->string('rfc', 13);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil');
    }
};
