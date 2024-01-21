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
        Schema::create('tditemkeluars', function (Blueprint $table) {
            $table->id();
            $table->integer('idthitemkeluar');
            $table->integer('id_produk');
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
        Schema::dropIfExists('tditemkeluars');
    }
};
