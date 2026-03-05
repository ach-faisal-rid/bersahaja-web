<?php

namespace Database\Seeders;

use App\Models\DoaSetelahSholat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoaSetelahSholatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DoaSetelahSholat::create([
            'judul' => 'Doa Istighfar Setelah Sholat',
            'teks_arab' => "أستغفر الله العظيم الذي لا إله إلا هو الحي القيوم وأتوب إليه",
            'transliterasi' => "Astaghfirullahal 'adzhim alladzi la ilaha illa huwal hayyul qayyum wa atubu ilaih",
            'terjemahan' => "Aku memohon ampun kepada Allah Yang Maha Agung, yang tiada Tuhan selain Dia, Yang Maha Hidup, Yang Maha Berdiri Sendiri, dan aku bertaubat kepada-Nya.",
        ]);

        DoaSetelahSholat::create([
            'judul' => 'Doa Tasbih Setelah Sholat',
            'teks_arab' => "سبحان الله والحمد لله ولا إله إلا الله والله أكبر",
            'transliterasi' => "Subhanallah walhamdulillah wa la ilaha illallah wallahu akbar",
            'terjemahan' => "Maha Suci Allah, segala puji bagi Allah, tiada Tuhan selain Allah, Allah Maha Besar.",
        ]);
    }
}
