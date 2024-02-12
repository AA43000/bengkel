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
        Schema::table('thpembelians', function (Blueprint $table) {
            // Hapus kolom total dan potongan
            $table->dropColumn(['total', 'potongan']);

            
            $table->string('no_pesanan')->nullable();
            $table->string('pembayaran')->nullable();
            $table->integer('total_bayar')->default(0);
            $table->integer('sisa_bayar')->default(0);
            $table->integer('id_user')->default(0);
        });

        Schema::table('tdpembelians', function (Blueprint $table) {
            // Tambahkan kolom potongan dan grand total
            $table->integer('potongan')->default(0);
            $table->integer('grand_total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thpembelians', function (Blueprint $table) {
            // Kembalikan kolom total dan potongan
            $table->integer('total')->default(0);
            $table->integer('potongan')->default(0);

            $table->dropColumn(['no_pesanan', 'pembayaran', 'total_bayar', 'sisa_bayar', 'id_user']);
        });

        Schema::table('tdpembelians', function (Blueprint $table) {
            // Hapus kolom potongan dan grand total
            $table->dropColumn(['potongan', 'grand_total']);
        });
    }
};
