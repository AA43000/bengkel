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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->string('alamat');
            $table->string('kota');
            $table->string('provinsi');
            $table->integer('kode_pos');
            $table->string('negara');
            $table->string('telephone');
            $table->string('fax');
            $table->string('bank');
            $table->string('no_account');
            $table->string('atas_nama');
            $table->string('kontak_person');
            $table->string('email');
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
        Schema::dropIfExists('suppliers');
    }
};
