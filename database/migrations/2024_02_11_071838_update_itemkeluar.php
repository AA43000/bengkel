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
        Schema::table('tditemkeluars', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->default('');
        });
        Schema::table('thitemkeluars', function (Blueprint $table) {
            $table->dropColumn(['created_by']);

            $table->integer('total_qty')->nullable();
            $table->integer('id_user')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tditemkeluars', function (Blueprint $table) {
            $table->dropColumn(['keterangan']);
        });
        Schema::table('thitemkeluars', function (Blueprint $table) {
            $table->dropColumn(['total_qty', 'id_user']);

            $table->integer('created_by')->default(0);
        });
    }
};
