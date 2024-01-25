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
        Schema::create('cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telephone');
            $table->string('alamat');
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('produks', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('kendaraans', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('mekaniks', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('pelanggans', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('thitemkeluars', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('thpembelians', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });
        
        Schema::table('thpenjualans', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('thservices', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('tditemkeluars', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('tdpembelians', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });
        
        Schema::table('tdpenjualans', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });

        Schema::table('tdservices', function (Blueprint $table) {
            $table->integer('id_cabang')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
