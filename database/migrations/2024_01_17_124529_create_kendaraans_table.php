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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('no_polisi');
            $table->string('pemilik');
            $table->text('alamat');
            $table->string('merk');
            $table->string('tipe');
            $table->string('jenis');
            $table->integer('tahun_buat');
            $table->integer('tahun_rakit');
            $table->string('silinder');
            $table->string('warna');
            $table->string('no_rangka');
            $table->string('no_mesin');
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
        Schema::dropIfExists('kendaraans');
    }
};
