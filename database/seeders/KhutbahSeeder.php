<?php

namespace Database\Seeders;

use App\Models\Khutbah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KhutbahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Khutbah::create([
            'judul' => 'Khutbah Jumat Singkat',
            'teks_arab' => "الحمد لله نحمده ونستعينه ونستغفره ونعوذ بالله من شرور أنفسنا ومن سيئات أعمالنا من يهده الله فلا مضل له ومن يضلل فلا هادي له وأشهد أن لا إله إلا الله وحده لا شريك له وأشهد أن محمداً عبده ورسوله\n\nأما بعد: فإن أصدق الحديث كتاب الله وأحسن الهدى هدى محمد صلى الله عليه وسلم وشر الأمور محدثاتها وكل محدثة بدعة وكل بدعة ضلالة\n\nفاتقوا الله عباد الله واستمسكوا بدينكم واتبعوا سنة نبيكم محمد صلى الله عليه وسلم",
            'transliterasi' => "Alhamdulillahi nahmaduhu wanasta'inuhu wanastaghfiruhu wa na'udzu billahi min syururi anfusina wa min sayyi'ati a'malina man yahdihillahu fala mudilla lahu wa man yudlil fala hadiya lahu wa asyhadu an la ilaha illallah wahdahu la syarika lahu wa asyhadu anna Muhammadan 'abduhu wa rasuluhu\n\nAmma ba'du: Fa inna ashadqa alhaditsi kitabullah wa ahsana alhuda huda Muhammadin shallallahu 'alaihi wa sallam wa syarra al'umuri muhdatsatuha wa kulla muhdatsatin bid'ah wa kulla bid'atin dalalah\n\nFattaqullaha 'ibadallah wa istamsiku bidinikum wattabi'u sunnata nabiyyikum Muhammadin shallallahu 'alaihi wa sallam",
            'terjemahan' => "Segala puji bagi Allah, kami memuji-Nya, memohon pertolongan kepada-Nya, memohon ampunan kepada-Nya, dan berlindung kepada Allah dari kejahatan diri kami dan dari keburukan amal kami. Barangsiapa yang diberi petunjuk oleh Allah maka tidak ada yang dapat menyesatkannya, dan barangsiapa yang disesatkan oleh Allah maka tidak ada yang dapat memberinya petunjuk. Aku bersaksi bahwa tidak ada Tuhan selain Allah Yang Maha Esa, tidak ada sekutu bagi-Nya, dan aku bersaksi bahwa Muhammad adalah hamba dan utusan-Nya.\n\nAmma ba'du: Sesungguhnya sebenar-benar perkataan adalah Kitabullah, sebaik-baik petunjuk adalah petunjuk Muhammad shallallahu 'alaihi wa sallam, seburuk-buruk perkara adalah yang diada-adakan, setiap yang diada-adakan adalah bid'ah, dan setiap bid'ah adalah kesesatan.\n\nMaka bertakwalah kepada Allah wahai hamba-hamba Allah, berpegang teguhlah pada agamamu, dan ikutilah sunnah Nabi kalian Muhammad shallallahu 'alaihi wa sallam.",
        ]);
    }
}
