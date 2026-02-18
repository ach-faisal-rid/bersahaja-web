<?php

namespace Database\Seeders;

use App\Models\Bacaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BacaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bacaans = [
            [
                'nama_bacaan' => 'Niat Shalat',
                'kategori' => 'Niat',
                'bacaan_arab' => 'نَوَيْتُ أَنْ أُصَلِّيَ فَرْضَ الْعَصْرِ أَرْبَعَ رَكَعَاتٍ مُوَجِّهًا لِوَجْهِ اللَّهِ تَعَالَى',
                'transliterasi' => 'Nawaitu an ushalliya fardha al-\'ashr arba\'a raka\'at muwaajjihan li wajhillahi ta\'ala',
                'terjemahan' => 'Saya niatkan untuk mengerjakan shalat wajib ashar empat rakaat dengan menghadapkan diri kepada Allah Ta\'ala',
                'deskripsi' => 'Niat adalah langkah pertama dalam shalat, penghendakan dengan hati untuk melaksanakan shalat.',
            ],
            [
                'nama_bacaan' => 'Al-Fatihah',
                'kategori' => 'Surah',
                'bacaan_arab' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ الرَّحْمَٰنِ الرَّحِيمِ مَالِكِ يَوْمِ الدِّينِ إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
                'transliterasi' => 'Bismillah ar-rahman ar-rahim. Al-hamdu lillahi rabbi l-\'alamin. Ar-rahman ar-rahim. Maliki yawmi d-din. Iyyaka na\'budu wa iyyaka nasta\'in. Ihdina s-sirat al-mustaqim. Sirat alladhina an\'amta \'alayhim ghayri l-maghdubi \'alayhim wa la d-dallin',
                'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang. Puji syukur bagi Allah, Tuhan semesta alam. Yang Maha Pengasih lagi Maha Penyayang. Penguasa di Hari Pembalasan. Hanya Engkaulah yang kami sembah dan hanya kepada Engkaulah kami memohon pertolongan. Tunjukkanlah kami jalan yang lurus. Yaitu jalan orang-orang yang telah Engkau beri nikmat kepada mereka, bukan jalan orang-orang yang dimurkai dan bukan pula jalan orang-orang yang sesat',
                'deskripsi' => 'Surah Al-Fatihah adalah surah pertama Al-Quran dan wajib dibaca di setiap rakaat shalat.',
            ],
            [
                'nama_bacaan' => 'Doa Iftitah',
                'kategori' => 'Doa',
                'bacaan_arab' => 'سُبْحَـانَكَ اللَّهُمَّ وَبِحَمْدِكَ وَتَبَارَكَ اسْمُكَ وَتَعَالَى جَدُّكَ وَلَا إِلَهَ غَيْرُكَ',
                'transliterasi' => 'Subhanaka allahumma wa bihamdika wa tabaraka asmuka wa ta\'ala jadduka wa la ilaha ghairuk',
                'terjemahan' => 'Maha Suci Engkau ya Allah beserta pujian bagimu, berkah nama-Mu dan Mahatuah kebesaranMu dan tidak ada sesembahan selain Engkau',
                'deskripsi' => 'Doa pembukaan shalat yang dibaca setelah takbir ihram.',
            ],
            [
                'nama_bacaan' => 'Tasbih Ruku\'',
                'kategori' => 'Tasbih',
                'bacaan_arab' => 'سُبْحَانَ رَبِّيَ الْعَظِيمِ',
                'transliterasi' => 'Subhana rabbi al-\'azim',
                'terjemahan' => 'Maha Suci Tuhanku Yang Maha Agung',
                'deskripsi' => 'Tasbih yang dibaca pada saat ruku\'. Minimal tiga kali, sunnah lima kali atau lebih.',
            ],
            [
                'nama_bacaan' => 'Doa Setelah I\'tidal',
                'kategori' => 'Doa',
                'bacaan_arab' => 'رَبَّنَا وَلَكَ الْحَمْدُ حَمْدًا كَثِيرًا طَيِّبًا مُبَارَكًا فِيهِ',
                'transliterasi' => 'Rabbana wa laka al-hamdu hamdan kathiran tayyiban mubarakan fih',
                'terjemahan' => 'Ya Rabb kami, dan milik-Mu segala puji dengan pujian yang banyak, baik dan penuh berkah',
                'deskripsi' => 'Doa yang dibaca setelah berdiri tegak dari ruku\'.',
            ],
            [
                'nama_bacaan' => 'Tasbih Sujud',
                'kategori' => 'Tasbih',
                'bacaan_arab' => 'سُبْحَانَ رَبِّيَ الْأَعْلَى',
                'transliterasi' => 'Subhana rabbi al-a\'la',
                'terjemahan' => 'Maha Suci Tuhanku Yang Maha Tinggi',
                'deskripsi' => 'Tasbih yang dibaca pada saat sujud. Minimal tiga kali, sunnah lima kali atau lebih.',
            ],
            [
                'nama_bacaan' => 'Doa di Antara Dua Sujud',
                'kategori' => 'Doa',
                'bacaan_arab' => 'اللَّهُمَّ اغْفِرْ لِي وَارْحَمْنِي وَاهْدِنِي وَعَافِنِي وَارْزُقْنِي',
                'transliterasi' => 'Allahumma ighfir li warhamni wahdini wa\'afini warzuqni',
                'terjemahan' => 'Ya Allah, ampunilah aku, sayangilah aku, tunjukilah aku, selamatkan aku, dan berikanlah rezeki kepadaku',
                'deskripsi' => 'Doa permohonan yang dibaca pada posisi duduk di antara dua sujud.',
            ],
            [
                'nama_bacaan' => 'Tasyahud Awal',
                'kategori' => 'Doa',
                'bacaan_arab' => 'التَّحِيَّاتُ لِلَّهِ وَالصَّلَوَاتُ وَالطَّيِّبَاتُ السَّلَامُ عَلَيْكَ أَيُّهَا النَّبِيُّ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ السَّلَامُ عَلَيْنَا وَعَلَى عِبَادِ اللَّهِ الصَّالِحِينَ أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا عَبْدُهُ وَرَسُولُهُ',
                'transliterasi' => 'At-tahiyyatu lillahi wa as-salawatu wa at-tayyibat. As-salam \'alayka ayyuha an-nabi wa rahmatullahi wa barakatuhu. As-salam \'alayna wa \'ala \'ibadi-lillahi as-salihin. Ashhadu an la ilaha illallahu wa ashhadu anna muhammadan \'abduhu wa rasuluh',
                'terjemahan' => 'Segala puji-pujian, doa-doa dan perbuatan terbaik adalah milik Allah. Semoga kesejahteraan terlimpah kepada Anda wahai Nabi, beserta rahmat Allah dan berkah-berkahnya. Semoga kesejahteraan juga untuk kami dan seluruh hamba-hamba Allah yang shalih. Aku bersaksi bahwa tidak ada tuhan selain Allah, dan aku bersaksi bahwa Muhammad adalah hamba-Nya dan Rasul-Nya',
                'deskripsi' => 'Tasyahud awal dibaca setelah rakaat kedua atau tengah shalat.',
            ],
            [
                'nama_bacaan' => 'Selawat dan Tasyahud Akhir',
                'kategori' => 'Doa',
                'bacaan_arab' => 'اللَّهُمَّ صَلِّ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا صَلَّيْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ إِنَّكَ حَمِيدٌ مَجِيدٌ وَبَارِكْ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا بَارَكْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ إِنَّكَ حَمِيدٌ مَجِيدٌ',
                'transliterasi' => 'Allahumma salli \'ala muhammadin wa \'ala ali muhammadin kama sallayta \'ala ibrahima wa \'ala ali ibrahima innaka hamidun majid. Wa barik \'ala muhammadin wa \'ala ali muhammadin kama barakta \'ala ibrahima wa \'ala ali ibrahima innaka hamidun majid.',
                'terjemahan' => 'Ya Allah, curahkanlah shalawat kepada Muhammad dan keluarga Muhammad, sebagaimana Engkau curahkan shalawat kepada Ibrahim dan keluarga Ibrahim. Sesungguhnya Engkau Maha Terpuji lagi Maha Agung. Dan berkahilah Muhammad dan keluarga Muhammad, sebagaimana Engkau berkahkan Ibrahim dan keluarga Ibrahim. Sesungguhnya Engkau Maha Terpuji lagi Maha Agung.',
                'deskripsi' => 'Selawat dan berkah yang dibaca dalam tasyahud akhir (akhir shalat).',
            ],
            [
                'nama_bacaan' => 'Doa Akhir Sebelum Salam',
                'kategori' => 'Doa',
                'bacaan_arab' => 'اللَّهُمَّ إِنِّي أَسْأَلُكَ الْعَفْوَ وَالْعَافِيَةَ',
                'transliterasi' => 'Allahumma inni as\'aluka al-\'afwa wa al-\'afiyah',
                'terjemahan' => 'Ya Allah, sesungguhnya aku memohon kepada-Mu pengampunan dan kesehatan',
                'deskripsi' => 'Doa permohonan yang dapat dibaca setelah tasyahud akhir dan sebelum mengucapkan salam.',
            ],
            [
                'nama_bacaan' => 'Salam',
                'kategori' => 'Salam',
                'bacaan_arab' => 'السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ',
                'transliterasi' => 'As-salam alaikum wa rahmatullahi wa barakatuh',
                'terjemahan' => 'Semoga kesejahteraan, rahmat dan berkah Allah terlimpah kepada kalian',
                'deskripsi' => 'Salam adalah penutup shalat yang diucapkan ke kanan dan ke kiri.',
            ],
            [
                'nama_bacaan' => 'Takbir dan Tasbih Setelah Shalat',
                'kategori' => 'Tasbih',
                'bacaan_arab' => 'اللَّهُ أَكْبَرُ اللَّهُ أَكْبَرُ لَا إِلَهَ إِلَّا اللَّهُ وَاللَّهُ أَكْبَرُ اللَّهُ أَكْبَرُ وَلِلَّهِ الْحَمْدُ',
                'transliterasi' => 'Allahu Akbar Allahu Akbar la ilaha illallahu wa Allahu Akbar Allahu Akbar wa lillahi al-hamd',
                'terjemahan' => 'Allah Maha Besar, Allah Maha Besar, tidak ada tuhan selain Allah, dan Allah Maha Besar, Allah Maha Besar, dan segala puji milik Allah',
                'deskripsi' => 'Takbir dan tasbih yang dibaca setelah shalat sebagai bentuk pujian kepada Allah.',
            ],
        ];

        foreach ($bacaans as $bacaan) {
            Bacaan::create($bacaan);
        }
    }
}
