<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('facturas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->string('IdFactura');
        $table->string('folio');
        $table->string('uuid');
        $table->string('rfc_emisor');
        $table->string('rfc_receptor');
        $table->decimal('subtotal', 10, 2);
        $table->decimal('total', 10, 2);
        $table->string('pdf_path');
        $table->string('xml_path');
        $table->string('status');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
