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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->string('rfc', 13)->unique();
            $table->string('servidorBDD', 255);
            $table->string('baseDatos', 100)->unique();
            $table->string('estructura')->nullable();
            $table->enum('valores', ['numericos', 'alfanumericos'])->default('numericos');
            $table->enum('tipo_periodo', ['Mensual', 'Trimestral', 'Anual']);
            $table->integer('periodos_ejercicio')->default(12);
            $table->boolean('periodos_abiertos')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
