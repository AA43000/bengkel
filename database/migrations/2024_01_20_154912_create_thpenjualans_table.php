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
        Schema::create('thpenjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->integer('id_pelanggan');
            $table->integer('total');
            $table->integer('potongan');
            $table->integer('total_akhir');
            $table->date('tanggal');
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
        Schema::dropIfExists('thpenjualans');
    }
};
