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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->after('password'); // Menambah kolom 'role' setelah kolom 'password'
        });
        Schema::table('mekaniks', function (Blueprint $table) {
            $table->string('id_user')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role'); // Menghapus kolom 'role' jika rollback migrasi
        });
        Schema::table('mekaniks', function (Blueprint $table) {
            $table->dropColumn('id_user'); // Menghapus kolom 'role' jika rollback migrasi
        });
    }
};
