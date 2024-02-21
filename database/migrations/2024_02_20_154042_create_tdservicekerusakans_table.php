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
        Schema::create('tdservicekerusakans', function (Blueprint $table) {
            $table->id();
            $table->integer('idthservice');
            $table->string('bagian')->nullable()->default('');
            $table->text('kerusakan')->nullable()->default('');
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
        Schema::dropIfExists('tdservicekerusakans');
    }
};
