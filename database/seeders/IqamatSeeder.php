<?php

namespace Database\Seeders;

use App\Models\Iqamat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IqamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teksArab = "الله أكبر الله أكبر\nأشهد أن لا إله إلا الله\nأشهد أن لا إله إلا الله\nأشهد أن محمداً رسول الله\nأشهد أن محمداً رسول الله\nحي على الصلاة\nحي على الصلاة\nحي على الفلاح\nحي على الفلاح\nالله أكبر الله أكبر\nلا إله إلا الله\nقد قامت الصلاة\nقد قامت الصلاة";

        $transliterasi = "Allahu Akbar Allahu Akbar\nAsyhadu an la ilaha illallah\nAsyhadu an la ilaha illallah\nAsyhadu anna Muhammadar rasulullah\nAsyhadu anna Muhammadar rasulullah\nHayya 'alas shalah\nHayya 'alas shalah\nHayya 'alal falah\nHayya 'alal falah\nAllahu Akbar Allahu Akbar\nLa ilaha illallah\nQad qamatis shalah\nQad qamatis shalah";

        $terjemahan = "Allah Maha Besar Allah Maha Besar\nAku bersaksi bahwa tiada Tuhan selain Allah\nAku bersaksi bahwa tiada Tuhan selain Allah\nAku bersaksi bahwa Muhammad adalah utusan Allah\nAku bersaksi bahwa Muhammad adalah utusan Allah\nMarilah sholat\nMarilah sholat\nMarilah menuju kebaikan\nMarilah menuju kebaikan\nAllah Maha Besar Allah Maha Besar\nTiada Tuhan selain Allah\nSholat telah didirikan\nSholat telah didirikan";

        $waktus = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];

        foreach ($waktus as $waktu) {
            Iqamat::create([
                'waktu' => $waktu,
                'teks_arab' => $teksArab,
                'transliterasi' => $transliterasi,
                'terjemahan' => $terjemahan,
            ]);
        }
    }
}
