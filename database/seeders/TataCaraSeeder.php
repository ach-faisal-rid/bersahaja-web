<?php

namespace Database\Seeders;

use App\Models\TataCara;
use App\Models\GerakanShalat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TataCaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil gerakan shalat
        $niatGerakan = GerakanShalat::where('nama_gerakan', 'Niat')->first();
        $takbirGerakan = GerakanShalat::where('nama_gerakan', 'Takbir Ihram')->first();
        $fatihaGerakan = GerakanShalat::where('nama_gerakan', 'Membaca Al-Fatihah')->first();
        $rukuGerakan = GerakanShalat::where('nama_gerakan', 'Ruku\'')->first();
        $itidialGerakan = GerakanShalat::where('nama_gerakan', 'I\'tidal')->first();
        $sujudGerakan = GerakanShalat::where('nama_gerakan', 'Sujud')->first();
        $dudukGerakan = GerakanShalat::where('nama_gerakan', 'Duduk di Antara Dua Sujud')->first();
        $tasyahuGerakan = GerakanShalat::where('nama_gerakan', 'Tasyahud Awal')->first();
        $tasyahuAkhirGerakan = GerakanShalat::where('nama_gerakan', 'Tasyahud Akhir')->first();
        $salamGerakan = GerakanShalat::where('nama_gerakan', 'Salam')->first();

        $tataCara = [
            // Langkah 1: Niat
            [
                'nama_langkah' => 'Niat',
                'urutan' => 1,
                'deskripsi' => 'Pertama-tama, niatkan dalam hati untuk melaksanakan shalat yang akan dikerjakan. Niat adalah menghendaki suatu perbuatan dengan hati, tanpa perlu diucapkan dengan lisan.',
                'gerakan_id' => $niatGerakan?->id,
                'bacaan_arab' => 'نَوَيْتُ أَنْ أُصَلِّيَ فَرْضَ الْعَصْرِ أَرْبَعَ رَكَعَاتٍ مُوَجِّهًا لِوَجْهِ اللَّهِ تَعَالَى',
                'transliterasi' => 'Nawaitu an ushalliya fardha al-\'ashr arba\'a raka\'at muwaajjihan li wajhillahi ta\'ala',
                'terjemahan' => 'Saya niatkan untuk mengerjakan shalat wajib ashar empat rakaat dengan menghadapkan diri kepada Allah Ta\'ala',
            ],

            // Langkah 2: Takbir Ihram
            [
                'nama_langkah' => 'Takbir Ihram',
                'urutan' => 2,
                'deskripsi' => 'Angkat kedua tangan setinggi telinga atau bahu sambil mengucapkan takbir. Ini adalah tanda dimulainya shalat dan memasuki keadaan ihram shalat.',
                'gerakan_id' => $takbirGerakan?->id,
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ',
                'transliterasi' => 'Allahu Akbar',
                'terjemahan' => 'Allah Maha Besar',
            ],

            // Langkah 3: Membaca Doa Iftitah
            [
                'nama_langkah' => 'Doa Iftitah',
                'urutan' => 3,
                'deskripsi' => 'Setelah takbir, bacalah doa iftitah (doa pembukaan). Ini adalah doa yang diucapkan pada awal shalat untuk memulai percakapan dengan Allah.',
                'gerakan_id' => null,
                'bacaan_arab' => 'سُبْحَـانَكَ اللَّهُمَّ وَبِحَمْدِكَ وَتَبَارَكَ اسْمُكَ وَتَعَالَى جَدُّكَ وَلَا إِلَهَ غَيْرُكَ',
                'transliterasi' => 'Subhanaka allahumma wa bihamdika wa tabaraka asmuka wa ta\'ala jadduka wa la ilaha ghairuk',
                'terjemahan' => 'Maha Suci Engkau ya Allah beserta pujian bagimu, berkah nama-Mu dan Mahatuah kebesaranMu dan tidak ada sesembahan selain Engkau',
            ],

            // Langkah 4: Membaca Al-Fatihah
            [
                'nama_langkah' => 'Membaca Al-Fatihah',
                'urutan' => 4,
                'deskripsi' => 'Al-Fatihah atau Surah Al-Hamdulillah adalah surah pertama dalam Al-Quran dan wajib dibaca dalam setiap rakaat shalat. Bacakan dengan taroji (perlahan dan jelas).',
                'gerakan_id' => $fatihaGerakan?->id,
                'bacaan_arab' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ الرَّحْمَٰنِ الرَّحِيمِ مَالِكِ يَوْمِ الدِّينِ
إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ
اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
                'transliterasi' => 'Bismillah ar-rahman ar-rahim. Al-hamdu lillahi rabbi l-\'alamin. Ar-rahman ar-rahim. Maliki yawmi d-din. Iyyaka na\'budu wa iyyaka nasta\'in. Ihdina s-sirat al-mustaqim. Sirat alladhina an\'amta \'alayhim ghayri l-maghdubi \'alayhim wa la d-dallin',
                'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang. Puji syukur bagi Allah, Tuhan semesta alam. Yang Maha Pengasih lagi Maha Penyayang. Penguasa di Hari Pembalasan. Hanya Engkaulah yang kami sembah dan hanya kepada Engkaulah kami memohon pertolongan. Tunjukkanlah kami jalan yang lurus. Yaitu jalan orang-orang yang telah Engkau beri nikmat kepada mereka, bukan jalan orang-orang yang dimurkai dan bukan pula jalan orang-orang yang sesat',
            ],

            // Langkah 5: Membaca Surah Setelah Al-Fatihah
            [
                'nama_langkah' => 'Membaca Surah Setelah Al-Fatihah',
                'urutan' => 5,
                'deskripsi' => 'Setelah membaca Al-Fatihah, bacalah surah atau ayat dari Al-Quran. Sunnah untuk membaca surah melalui pada rakaat pertama dan kedua, dan singkat pada rakaat ketiga dan keempat.',
                'gerakan_id' => null,
                'bacaan_arab' => 'قُلْ هُوَ اللَّهُ أَحَدٌ اللَّهُ الصَّمَدُ لَمْ يَلِدْ وَلَمْ يُولَدْ وَلَمْ يَكُن لَّهُ كُفُوًا أَحَدٌ',
                'transliterasi' => 'Qul huwa Allahu ahad. Allah as-samad. Lam yalid wa lam yulad. Wa lam yakun lahu kufuwan ahad',
                'terjemahan' => 'Katakanlah: Dia-lah Allah, Yang Satu. Allah adalah Tuhan yang bergantung kepada-Nya segala sesuatu. Dia tiada melahirkan dan tiada dilahirkan. Dan tidak ada seorang pun yang setara dengan Dia',
            ],

            // Langkah 6: Ruku\'
            [
                'nama_langkah' => 'Ruku\'',
                'urutan' => 6,
                'deskripsi' => 'Membungkuk dengan membuat sudut 90 derajat sehingga tangan menyentuh lutut atau menggenggam lutut, dan kepala lurus dengan punggung. Ucapkan takbir sambil membungkuk.',
                'gerakan_id' => $rukuGerakan?->id,
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ',
                'transliterasi' => 'Allahu Akbar',
                'terjemahan' => 'Allah Maha Besar',
            ],

            // Langkah 7: Tasbih di Ruku\'
            [
                'nama_langkah' => 'Tasbih di Ruku\'',
                'urutan' => 7,
                'deskripsi' => 'Pada posisi ruku\', bacakan tasbih (pujian) kepada Allah. Minimal tiga kali, tetapi sunnah untuk membaca lima kali atau lebih.',
                'gerakan_id' => $rukuGerakan?->id,
                'bacaan_arab' => 'سُبْحَانَ رَبِّيَ الْعَظِيمِ',
                'transliterasi' => 'Subhana rabbi al-\'azim',
                'terjemahan' => 'Maha Suci Tuhanku Yang Maha Agung',
            ],

            // Langkah 8: I\'tidal
            [
                'nama_langkah' => 'I\'tidal (Berdiri Tegak)',
                'urutan' => 8,
                'deskripsi' => 'Berdiri tegak dari posisi ruku\' sambil mengangkat tangan dan mengucapkan takbir. Dalam posisi ini, bacakan doa pujian kepada Allah.',
                'gerakan_id' => $itidialGerakan?->id,
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ',
                'transliterasi' => 'Allahu Akbar',
                'terjemahan' => 'Allah Maha Besar',
            ],

            // Langkah 9: Doa setelah I\'tidal
            [
                'nama_langkah' => 'Doa Setelah I\'tidal',
                'urutan' => 9,
                'deskripsi' => 'Setelah berdiri tegak dari ruku\', bacalah doa yang mengungkapkan rasa syukur atas nikmat Allah.',
                'gerakan_id' => $itidialGerakan?->id,
                'bacaan_arab' => 'رَبَّنَا وَلَكَ الْحَمْدُ حَمْدًا كَثِيرًا طَيِّبًا مُبَارَكًا فِيهِ',
                'transliterasi' => 'Rabbana wa laka al-hamdu hamdan kathiran tayyiban mubarakan fih',
                'terjemahan' => 'Ya Rabb kami, dan milik-Mu segala puji dengan pujian yang banyak, baik dan penuh berkah',
            ],

            // Langkah 10: Sujud
            [
                'nama_langkah' => 'Sujud',
                'urutan' => 10,
                'deskripsi' => 'Sujud adalah posisi di mana tujuh anggota tubuh menyentuh tanah: dahi, hidung, kedua tangan, kedua lutut, dan kedua ujung kaki. Ucapkan takbir saat hendak sujud.',
                'gerakan_id' => $sujudGerakan?->id,
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ',
                'transliterasi' => 'Allahu Akbar',
                'terjemahan' => 'Allah Maha Besar',
            ],

            // Langkah 11: Tasbih di Sujud
            [
                'nama_langkah' => 'Tasbih di Sujud',
                'urutan' => 11,
                'deskripsi' => 'Pada posisi sujud, bacakan tasbih kepada Allah. Minimal tiga kali pujian, tetapi sunnah untuk lebih banyak lagi.',
                'gerakan_id' => $sujudGerakan?->id,
                'bacaan_arab' => 'سُبْحَانَ رَبِّيَ الْأَعْلَى',
                'transliterasi' => 'Subhana rabbi al-a\'la',
                'terjemahan' => 'Maha Suci Tuhanku Yang Maha Tinggi',
            ],

            // Langkah 12: Duduk di Antara Dua Sujud
            [
                'nama_langkah' => 'Duduk di Antara Dua Sujud',
                'urutan' => 12,
                'deskripsi' => 'Setelah sujud pertama, duduklah dengan santai (i\'tidal) sebelum melakukan sujud yang kedua. Ucapkan takbir saat duduk.',
                'gerakan_id' => $dudukGerakan?->id,
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ',
                'transliterasi' => 'Allahu Akbar',
                'terjemahan' => 'Allah Maha Besar',
            ],

            // Langkah 13: Doa di Antara Dua Sujud
            [
                'nama_langkah' => 'Doa di Antara Dua Sujud',
                'urutan' => 13,
                'deskripsi' => 'Pada posisi duduk di antara dua sujud, bacakan doa permohonan kepada Allah untuk pengampunan dan petunjuknya.',
                'gerakan_id' => $dudukGerakan?->id,
                'bacaan_arab' => 'اللَّهُمَّ اغْفِرْ لِي وَارْحَمْنِي وَاهْدِنِي وَعَافِنِي وَارْزُقْنِي',
                'transliterasi' => 'Allahumma ighfir li warhamni wahdini wa\'afini warzuqni',
                'terjemahan' => 'Ya Allah, ampunilah aku, sayangilah aku, tunjukilah aku, selamatkan aku, dan berikanlah rezeki kepadaku',
            ],

            // Langkah 14: Sujud Kedua
            [
                'nama_langkah' => 'Sujud Kedua',
                'urutan' => 14,
                'deskripsi' => 'Lakukan sujud yang kedua sama seperti sujud pertama. Ucapkan takbir saat hendak sujud dan tasbih selama sujud.',
                'gerakan_id' => $sujudGerakan?->id,
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ',
                'transliterasi' => 'Allahu Akbar',
                'terjemahan' => 'Allah Maha Besar',
            ],

            // Langkah 15: Tasbih di Sujud Kedua
            [
                'nama_langkah' => 'Tasbih di Sujud Kedua',
                'urutan' => 15,
                'deskripsi' => 'Bacakan tasbih yang sama seperti pada sujud pertama dengan minimal tiga kali.',
                'gerakan_id' => $sujudGerakan?->id,
                'bacaan_arab' => 'سُبْحَانَ رَبِّيَ الْأَعْلَى',
                'transliterasi' => 'Subhana rabbi al-a\'la',
                'terjemahan' => 'Maha Suci Tuhanku Yang Maha Tinggi',
            ],

            // Langkah 16: Tasyahud Awal (Rakaat Kedua Selesai)
            [
                'nama_langkah' => 'Tasyahud Awal',
                'urutan' => 16,
                'deskripsi' => 'Setelah menyelesaikan rakaat kedua atau ketiga (untuk shalat dengan lebih dari 2 rakaat), duduklah dan bacakan tasyahud awal (saksi bahwa tidak ada tuhan selain Allah).',
                'gerakan_id' => $tasyahuGerakan?->id,
                'bacaan_arab' => 'التَّحِيَّاتُ لِلَّهِ وَالصَّلَوَاتُ وَالطَّيِّبَاتُ السَّلَامُ عَلَيْكَ أَيُّهَا النَّبِيُّ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ السَّلَامُ عَلَيْنَا وَعَلَى عِبَادِ اللَّهِ الصَّالِحِينَ أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا عَبْدُهُ وَرَسُولُهُ',
                'transliterasi' => 'At-tahiyyatu lillahi wa as-salawatu wa at-tayyibat. As-salam \'alayka ayyuha an-nabi wa rahmatullahi wa barakatuhu. As-salam \'alayna wa \'ala \'ibadi-lillahi as-salihin. Ashhadu an la ilaha illallahu wa ashhadu anna muhammadan \'abduhu wa rasuluh',
                'terjemahan' => 'Segala puji-pujian, doa-doa dan perbuatan terbaik adalah milik Allah. Semoga kesejahteraan terlimpah kepada Anda wahai Nabi, beserta rahmat Allah dan berkah-berkahnya. Semoga kesejahteraan juga untuk kami dan seluruh hamba-hamba Allah yang shalih. Aku bersaksi bahwa tidak ada tuhan selain Allah, dan aku bersaksi bahwa Muhammad adalah hamba-Nya dan Rasul-Nya',
            ],

            // Langkah 17: Tasyahud Akhir
            [
                'nama_langkah' => 'Tasyahud Akhir',
                'urutan' => 17,
                'deskripsi' => 'Pada akhir shalat (setelah rakaat terakhir), bacakan tasyahud akhir yang lebih lengkap termasuk selawat kepada Nabi Muhammad dan doa permohonan.',
                'gerakan_id' => $tasyahuAkhirGerakan?->id,
                'bacaan_arab' => 'التَّحِيَّاتُ لِلَّهِ وَالصَّلَوَاتُ وَالطَّيِّبَاتُ السَّلَامُ عَلَيْكَ أَيُّهَا النَّبِيُّ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ السَّلَامُ عَلَيْنَا وَعَلَى عِبَادِ اللَّهِ الصَّالِحِينَ أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا عَبْدُهُ وَرَسُولُهُ. اللَّهُمَّ صَلِّ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا صَلَّيْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ إِنَّكَ حَمِيدٌ مَجِيدٌ وَبَارِكْ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا بَارَكْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ إِنَّكَ حَمِيدٌ مَجِيدٌ',
                'transliterasi' => 'At-tahiyyatu lillahi wa as-salawatu wa at-tayyibat. As-salam \'alayka ayyuha an-nabi wa rahmatullahi wa barakatuhu. As-salam \'alayna wa \'ala \'ibadi-lillahi as-salihin. Ashhadu an la ilaha illallahu wa ashhadu anna muhammadan \'abduhu wa rasuluh. Allahumma salli \'ala muhammadin wa \'ala ali muhammadin kama sallayta \'ala ibrahima wa \'ala ali ibrahima innaka hamidun majid. Wa barik \'ala muhammadin wa \'ala ali muhammadin kama barakta \'ala ibrahima wa \'ala ali ibrahima innaka hamidun majid.',
                'terjemahan' => 'Segala puji-pujian, doa-doa dan perbuatan terbaik adalah milik Allah. Semoga kesejahteraan terlimpah kepada Anda wahai Nabi, beserta rahmat Allah dan berkah-berkahnya. Semoga kesejahteraan juga untuk kami dan seluruh hamba-hamba Allah yang shalih. Aku bersaksi bahwa tidak ada tuhan selain Allah, dan aku bersaksi bahwa Muhammad adalah hamba-Nya dan Rasul-Nya. Ya Allah, curahkanlah shalawat kepada Muhammad dan keluarga Muhammad, sebagaimana Engkau curahkan shalawat kepada Ibrahim dan keluarga Ibrahim. Sesungguhnya Engkau Maha Terpuji lagi Maha Agung. Dan berkahilah Muhammad dan keluarga Muhammad, sebagaimana Engkau berkahkan Ibrahim dan keluarga Ibrahim. Sesungguhnya Engkau Maha Terpuji lagi Maha Agung.',
            ],

            // Langkah 18: Doa Akhir Shalat
            [
                'nama_langkah' => 'Doa Permohonan',
                'urutan' => 18,
                'deskripsi' => 'Sebelum menutup shalat dengan salam, Anda dapat memohon kepada Allah dengan doa-doa yang Anda inginkan (doa akhir shalat).',
                'gerakan_id' => null,
                'bacaan_arab' => 'اللَّهُمَّ إِنِّي أَسْأَلُكَ الْعَفْوَ وَالْعَافِيَةَ',
                'transliterasi' => 'Allahumma inni as\'aluka al-\'afwa wa al-\'afiyah',
                'terjemahan' => 'Ya Allah, sesungguhnya aku memohon kepada-Mu pengampunan dan kesehatan',
            ],

            // Langkah 19: Salam
            [
                'nama_langkah' => 'Salam',
                'urutan' => 19,
                'deskripsi' => 'Salam adalah penutup shalat. Miringkan wajah ke kanan dan ke kiri sambil mengucapkan salam yang merupakan doa untuk keselamatan.',
                'gerakan_id' => $salamGerakan?->id,
                'bacaan_arab' => 'السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ',
                'transliterasi' => 'As-salam alaikum wa rahmatullahi wa barakatuh',
                'terjemahan' => 'Semoga kesejahteraan, rahmat dan berkah Allah terlimpah kepada kalian',
            ],

            // Langkah 20: Doa Setelah Shalat
            [
                'nama_langkah' => 'Doa Setelah Shalat',
                'urutan' => 20,
                'deskripsi' => 'Setelah menyelesaikan shalat dengan salam, bacakan doa-doa yang telah diajarkan oleh Nabi Muhammad untuk memperkuat hubungan dengan Allah.',
                'gerakan_id' => null,
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ اللَّهُ أَكْبَرُ لَا إِلَهَ إِلَّا اللَّهُ وَاللَّهُ أَكْبَرُ اللَّهُ أَكْبَرُ وَلِلَّهِ الْحَمْدُ',
                'transliterasi' => 'Allahu Akbar Allahu Akbar la ilaha illallahu wa Allahu Akbar Allahu Akbar wa lillahi al-hamd',
                'terjemahan' => 'Allah Maha Besar, Allah Maha Besar, tidak ada tuhan selain Allah, dan Allah Maha Besar, Allah Maha Besar, dan segala puji milik Allah',
            ],
        ];

        foreach ($tataCara as $step) {
            TataCara::create($step);
        }
    }
}
