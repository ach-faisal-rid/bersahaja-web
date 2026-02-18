<?php

namespace Database\Seeders;

use App\Models\Wudu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WuduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wudus = [
            [
                'nama_langkah' => 'Niat',
                'urutan' => 1,
                'deskripsi' => 'Berniat dalam hati untuk berwudu. Niat adalah penghendakan layak dan tujuan melakukan sesuatu perbuatan.',
                'doa_arab' => 'نَوَيْتُ الْوُضُوءَ',
                'transliterasi' => 'Nawaitu al-wudhu\'',
                'terjemahan' => 'Saya niatkan untuk berwudu',
                'tips_penting' => 'Niat harus dalam hati, tidak perlu diucapkan dengan lisan. Pastikan niat murni untuk mentaati perintah Allah.',
            ],
            [
                'nama_langkah' => 'Cuci Tangan',
                'urutan' => 2,
                'deskripsi' => 'Cuci kedua tangan sampai pergelangan tangan tiga kali. Pastikan air membasahi seluruh permukaan tangan termasuk sela-sela jari.',
                'doa_arab' => 'بِسْمِ اللَّهِ',
                'transliterasi' => 'Bismillah',
                'terjemahan' => 'Dengan nama Allah',
                'tips_penting' => 'Basahi seluruh permukaan tangan termasuk sela-sela jari. Boleh dimulai dari tangan kanan terlebih dahulu, tetapi tidak wajib.',
            ],
            [
                'nama_langkah' => 'Berkumur',
                'urutan' => 3,
                'deskripsi' => 'Ambil air di mulut, berkumur dan buang airnya. Lakukan ini tiga kali untuk membersihkan rongga mulut dari sisa makanan dan kotoran.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Pastikan air menjangkau seluruh rongga mulut. Lakukan dengan hati-hati agar tidak sampai masuk ke tenggorokan.',
            ],
            [
                'nama_langkah' => 'Istinsyaq',
                'urutan' => 4,
                'deskripsi' => 'Masukkan air ke dalam hidung dengan tangan dan keluarkan airnya. Ini untuk membersihkan saluran hidung.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Untuk pria yang bukan sedang berpuasa, sunnah menghisap air dengan kuat. Untuk yang berpuasa, lakukan dengan lembut.',
            ],
            [
                'nama_langkah' => 'Cuci Muka',
                'urutan' => 5,
                'deskripsi' => 'Cuci muka dengan kedua tangan dari dahi sampai dagu dan dari satu telinga ke telinga lainnya. Lakukan ini tiga kali.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Pastikan air membasahi seluruh wajah termasuk area antara mata, hidung, dan mulut. Wajib tiga kali untuk bagian wudu ini.',
            ],
            [
                'nama_langkah' => 'Cuci Tangan Kanan Sampai Siku',
                'urutan' => 6,
                'deskripsi' => 'Cuci tangan kanan dari ujung jari sampai siku termasuk siku. Lakukan ini tiga kali.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Mulai dari jari-jari, lalu ke pergelangan tangan, lalu ke lengan, dan terakhir siku. Jangan lewatkan sela-sela jari.',
            ],
            [
                'nama_langkah' => 'Cuci Tangan Kiri Sampai Siku',
                'urutan' => 7,
                'deskripsi' => 'Cuci tangan kiri dari ujung jari sampai siku termasuk siku, sama seperti tangan kanan. Lakukan ini tiga kali.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Gunakan tangan kanan untuk mengusap tangan kiri. Pastikan semua bagian terbasahi air, termasuk jari-jari dan sela-selanya.',
            ],
            [
                'nama_langkah' => 'Usap Kepala',
                'urutan' => 8,
                'deskripsi' => 'Usap seluruh kepala dengan air basah. Dapat dilakukan dengan mengusap dari dahi ke belakang kepala atau sebaliknya.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Cukup sekali saja untuk mengusap kepala (berbeda dengan anggota lain yang tiga kali). Usap hingga mencapai bagian belakang kepala.',
            ],
            [
                'nama_langkah' => 'Usap Telinga',
                'urutan' => 9,
                'deskripsi' => 'Usap bagian dalam dan luar kedua telinga dengan jari telunjuk dan ibu jari menggunakan air sisa dari mengusap kepala.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Gunakan air sisa dari mengusap kepala. Usap telinga dari dalam keluar dan jangan lupa bagian luar telinga.',
            ],
            [
                'nama_langkah' => 'Cuci Kaki Kanan Sampai Mata Kaki',
                'urutan' => 10,
                'deskripsi' => 'Cuci kaki kanan dari ujung jari sampai mata kaki (bagian atas kaki di atas tumit) tiga kali. Pastikan air membasahi sela-sela jari kaki.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Jangan lupa membersihkan sela-sela jari kaki. Usap pula bagian belakang mata kaki. Lakukan dengan teliti dan menyeluruh.',
            ],
            [
                'nama_langkah' => 'Cuci Kaki Kiri Sampai Mata Kaki',
                'urutan' => 11,
                'deskripsi' => 'Cuci kaki kiri dari ujung jari sampai mata kaki (bagian atas kaki di atas tumit) tiga kali, sama seperti kaki kanan.',
                'doa_arab' => null,
                'transliterasi' => null,
                'terjemahan' => null,
                'tips_penting' => 'Bersihkan dengan menyeluruh, termasuk sela-sela jari kaki dan bagian belakang mata kaki. Pastikan tidak ada bagian yang terlewat.',
            ],
            [
                'nama_langkah' => 'Doa Setelah Wudu',
                'urutan' => 12,
                'deskripsi' => 'Setelah menyelesaikan wudu, bacakan doa setelah wudu untuk memohon kepada Allah agar menerima wudu kita.',
                'doa_arab' => 'أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ، وَأَشْهَدُ أَنَّ مُحَمَّدًا عَبْدُهُ وَرَسُولُهُ. اللَّهُمَّ اجْعَلْنِي مِنَ التَّوَّابِينَ وَاجْعَلْنِي مِنَ الْمُتَطَهِّرِينَ',
                'transliterasi' => 'Ashhadu an la ilaha illallahu wa ashhadu anna muhammadan \'abduhu wa rasuluh. Allahumma ij\'alni minat-tawwabin waj\'alni minal-mutathohirin',
                'terjemahan' => 'Aku bersaksi bahwa tidak ada sesembahan yang berhak disembah melainkan Allah dan aku bersaksi bahwa Muhammad adalah hamba dan Rasul-Nya. Ya Allah, jadikanlah aku termasuk orang-orang yang taubat dan jadikanlah aku termasuk orang-orang yang bersih.',
                'tips_penting' => 'Doa ini disyariatkan untuk menutup wudu. Bacakan dengan khusyu\' dan ikhlas.',
            ],
        ];

        foreach ($wudus as $wudu) {
            Wudu::create($wudu);
        }
    }
}
