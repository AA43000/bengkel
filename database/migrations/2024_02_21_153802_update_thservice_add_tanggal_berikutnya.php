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
            $table->date('tanggal_berikutnya')->nullable();
            $table->integer('km_berikutnya')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thservices', function (Blueprint $table) {
            $table->dropColumn(['tanggal_berikutnya', 'km_berikutnya']);
        });
    }
};
