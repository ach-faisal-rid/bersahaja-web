/**
 * Date Converter Utility untuk Kalender Hijriah Indonesia
 * Menggunakan API UNISA Yogyakarta (Muhammadiyah)
 */

class DateConverter {
  constructor() {
    this.cache = {};
    this.apiBase = 'https://service.unisayogya.ac.id/kalender/api';
  }

  /**
   * Konversi Gregorian ke Hijriah
   */
  async gregorianToHijri(gy, gm, gd) {
    const cacheKey = `g2h-${gy}-${gm}-${gd}`;
    if (this.cache[cacheKey]) return this.cache[cacheKey];

    try {
      const monthStr = String(gm).padStart(2, '0');
      const dayStr = String(gd).padStart(2, '0');
      const response = await fetch(
        `${this.apiBase}/masehi2hijriah/muhammadiyah/${gy}/${monthStr}/${dayStr}`,
        { headers: { Accept: 'application/json' } }
      );

      if (!response.ok) throw new Error(`API error: ${response.status}`);

      const data = await response.json();
      if (!data?.tahun || !data?.bulan || !data?.tanggal) {
        throw new Error('Format response API tidak valid');
      }

      const result = { year: data.tahun, month: data.bulan, day: data.tanggal };
      this.cache[cacheKey] = result;
      return result;
    } catch (error) {
      console.error('Error converting Gregorian to Hijri:', error);
      throw error;
    }
  }

  /**
   * Konversi Hijriah ke Gregorian
   */
  async hijriToGregorian(hy, hm, hd) {
    const cacheKey = `h2g-${hy}-${hm}-${hd}`;
    if (this.cache[cacheKey]) return this.cache[cacheKey];

    try {
      const monthStr = String(hm).padStart(2, '0');
      const dayStr = String(hd).padStart(2, '0');
      const response = await fetch(
        `${this.apiBase}/hijriah2masehi/muhammadiyah/${hy}/${monthStr}/${dayStr}`,
        { headers: { Accept: 'application/json' } }
      );

      if (!response.ok) throw new Error(`API error: ${response.status}`);

      const data = await response.json();
      if (!data?.tahun || !data?.bulan || !data?.tanggal) {
        throw new Error('Format response API tidak valid');
      }

      const result = { year: data.tahun, month: data.bulan, day: data.tanggal };
      this.cache[cacheKey] = result;
      return result;
    } catch (error) {
      console.error('Error converting Hijri to Gregorian:', error);
      throw error;
    }
  }

  /**
   * Tentukan panjang bulan Hijriah (29 atau 30 hari)
   */
  async hijriMonthLength(year, month) {
    const cacheKey = `monthLen-${year}-${month}`;
    if (this.cache[cacheKey]) return this.cache[cacheKey];

    try {
      // Coba konversi tanggal 30
      const day30Greg = await this.hijriToGregorian(year, month, 30);
      const verifyHijri = await this.gregorianToHijri(day30Greg.year, day30Greg.month, day30Greg.day);

      if (verifyHijri.year === year && verifyHijri.month === month && verifyHijri.day === 30) {
        this.cache[cacheKey] = 30;
        return 30;
      }
    } catch (error) {
      // Jika gagal, berarti bulan 29 hari
    }

    // Fallback: hitung selisih hari antara tanggal 1 bulan ini dan bulan berikutnya
    try {
      const firstDay = await this.hijriToGregorian(year, month, 1);
      const nextMonth = month === 12 ? 1 : month + 1;
      const nextYear = month === 12 ? year + 1 : year;
      const firstDayNext = await this.hijriToGregorian(nextYear, nextMonth, 1);

      const diffTime = new Date(firstDayNext.year, firstDayNext.month - 1, firstDayNext.day) -
                       new Date(firstDay.year, firstDay.month - 1, firstDay.day);
      const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));

      const result = (diffDays === 29 || diffDays === 30) ? diffDays : 29;
      this.cache[cacheKey] = result;
      return result;
    } catch (error) {
      this.cache[cacheKey] = 29;
      return 29;
    }
  }

  /**
   * Clear cache
   */
  clearCache() {
    this.cache = {};
  }
}

export default new DateConverter();
