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
        Schema::create('thitemkeluars', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->integer('total');
            $table->date('tanggal');
            $table->text('keterangan');
            $table->integer('created_by')->nullable()->default(0);
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
        Schema::dropIfExists('thitemkeluars');
    }
};
