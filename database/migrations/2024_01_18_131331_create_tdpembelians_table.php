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
        Schema::create('tdpembelians', function (Blueprint $table) {
            $table->id();
            $table->integer('idthpembelian');
            $table->integer('id_produk');
            $table->string('pesan')->nullable()->default('');
            $table->integer('qty');
            $table->integer('harga');
            $table->integer('subtotal');
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
        Schema::dropIfExists('tdpembelians');
    }
};
