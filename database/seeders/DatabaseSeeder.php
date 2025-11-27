<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create users
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Guru Pembimbing',
            'username' => 'guru',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);

        User::create([
            'nama' => 'Ramdhani Siswa',
            'username' => 'ramdhani',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);

        // Create categories
        $kategoris = ['Berita Sekolah', 'Prestasi', 'Kegiatan', 'Pengumuman', 'Tips Belajar'];
        foreach ($kategoris as $kategori) {
            Kategori::create(['nama_kategori' => $kategori]);
        }
    }
}