<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_item');
            $table->string('kode_barcode');
            $table->string('nama_item');
            $table->string('jenis');
            $table->string('kategori');
            $table->integer('stok');
            $table->string('satuan');
            $table->string('rak');
            $table->integer('harga_pokok');
            $table->integer('harga_jual');
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
};
