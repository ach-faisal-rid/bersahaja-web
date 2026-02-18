<?php

namespace Database\Seeders;

use App\Models\GerakanShalat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GerakanShalatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gerakans = [
            [
                'nama_gerakan' => 'Niat',
                'urutan_global' => 1,
                'deskripsi_singkat' => 'Membaca niat untuk melaksanakan shalat',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Takbir Ihram',
                'urutan_global' => 2,
                'deskripsi_singkat' => 'Mengangkat tangan dan mengucapkan Allahu Akbar',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Berdiri Tegak',
                'urutan_global' => 3,
                'deskripsi_singkat' => 'Berdiri tegak dengan khusyu\' menghadap kiblat',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Membaca Al-Fatihah',
                'urutan_global' => 4,
                'deskripsi_singkat' => 'Membaca surat Al-Fatihah dengan tartil',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Membaca Surah Setelah Al-Fatihah',
                'urutan_global' => 5,
                'deskripsi_singkat' => 'Membaca surah atau ayat-ayat Al-Quran setelah Al-Fatihah',
                'kategori' => 'Sunnah',
            ],
            [
                'nama_gerakan' => 'Ruku\'',
                'urutan_global' => 6,
                'deskripsi_singkat' => 'Membungkuk hingga tangan menyentuh lutut sambil mengucapkan tasbih',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'I\'tidal',
                'urutan_global' => 7,
                'deskripsi_singkat' => 'Berdiri tegak kembali setelah ruku\' sambil mengucapkan doa',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Sujud',
                'urutan_global' => 8,
                'deskripsi_singkat' => 'Meletakkan dahi, hidung di tanah sambil mengucapkan tasbih',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Duduk di Antara Dua Sujud',
                'urutan_global' => 9,
                'deskripsi_singkat' => 'Duduk istirahat di antara dua sujud',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Tasyahud Awal',
                'urutan_global' => 10,
                'deskripsi_singkat' => 'Membaca tasyahud pada akhir rakaat kedua',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Tasyahud Akhir',
                'urutan_global' => 11,
                'deskripsi_singkat' => 'Membaca tasyahud dan selawat pada akhir shalat',
                'kategori' => 'Wajib',
            ],
            [
                'nama_gerakan' => 'Salam',
                'urutan_global' => 12,
                'deskripsi_singkat' => 'Mengucapkan salam ke kanan dan ke kiri',
                'kategori' => 'Wajib',
            ],
        ];

        foreach ($gerakans as $gerakan) {
            GerakanShalat::create($gerakan);
        }
    }
}
