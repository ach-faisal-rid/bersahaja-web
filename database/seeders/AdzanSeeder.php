<?php

namespace Database\Seeders;

use App\Models\Adzan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdzanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teksArab = "الله أكبر الله أكبر\nالله أكبر الله أكبر\nأشهد أن لا إله إلا الله\nأشهد أن لا إله إلا الله\nأشهد أن محمداً رسول الله\nأشهد أن محمداً رسول الله\nحي على الصلاة\nحي على الصلاة\nحي على الفلاح\nحي على الفلاح\nالله أكبر الله أكبر\nلا إله إلا الله";

        $transliterasi = "Allahu Akbar Allahu Akbar\nAllahu Akbar Allahu Akbar\nAsyhadu an la ilaha illallah\nAsyhadu an la ilaha illallah\nAsyhadu anna Muhammadar rasulullah\nAsyhadu anna Muhammadar rasulullah\nHayya 'alas shalah\nHayya 'alas shalah\nHayya 'alal falah\nHayya 'alal falah\nAllahu Akbar Allahu Akbar\nLa ilaha illallah";

        $terjemahan = "Allah Maha Besar Allah Maha Besar\nAllah Maha Besar Allah Maha Besar\nAku bersaksi bahwa tiada Tuhan selain Allah\nAku bersaksi bahwa tiada Tuhan selain Allah\nAku bersaksi bahwa Muhammad adalah utusan Allah\nAku bersaksi bahwa Muhammad adalah utusan Allah\nMarilah sholat\nMarilah sholat\nMarilah menuju kebaikan\nMarilah menuju kebaikan\nAllah Maha Besar Allah Maha Besar\nTiada Tuhan selain Allah";

        $waktus = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];

        foreach ($waktus as $waktu) {
            Adzan::create([
                'waktu' => $waktu,
                'teks_arab' => $teksArab,
                'transliterasi' => $transliterasi,
                'terjemahan' => $terjemahan,
            ]);
        }
    }
}
