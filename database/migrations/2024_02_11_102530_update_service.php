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
        Schema::table('thservices', function (Blueprint $table) {
            // Hapus kolom total dan potongan
            $table->dropColumn(['total', 'potongan']);

            // Tambahkan kolom pembayaran, total_bayar, dan kembalian
            $table->string('pembayaran')->nullable();
            $table->integer('total_bayar')->default(0);
            $table->integer('kembalian')->default(0);
            $table->integer('id_user')->default(0);
        });

        Schema::table('tdservices', function (Blueprint $table) {
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
        Schema::table('thSERVICEs', function (Blueprint $table) {
            // Kembalikan kolom total dan potongan
            $table->integer('total')->default(0);
            $table->integer('potongan')->default(0);

            // Hapus kolom pembayaran, total_bayar, dan kembalian
            $table->dropColumn(['pembayaran', 'total_bayar', 'kembalian', 'id_user']);
        });

        Schema::table('tdSERVICEs', function (Blueprint $table) {
            // Hapus kolom potongan dan grand total
            $table->dropColumn(['potongan', 'grand_total']);
        });
    }
};
