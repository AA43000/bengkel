<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Membuat pengguna admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'id_cabang' => 1
        ]);

        // DB::statement("INSERT INTO cabangs (id, nama, telephone, alamat, created_at, updated_at) VALUES (2, 'Bengkel A', '', '', NOW(), NOW())");
        DB::table('cabangs')->insert([
            'nama' => 'Bengkel A',
            'telephone' => '',
            'alamat' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Admin user created!');
    }
}
