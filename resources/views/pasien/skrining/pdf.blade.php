<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Hasil Skrining - Ruang Pulih</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: 'Times New Roman', Times, serif; color: #333; line-height: 1.5; font-size: 12pt; }

        /* Letterhead / Kop Surat */
        .kop-surat { border-bottom: 3px double #005c34; padding-bottom: 10px; margin-bottom: 25px; }
        .kop-table { margin: 0 auto; border-collapse: collapse; }
        .kop-logo { width: 130px; height: 130px; }
        .kop-detail { text-align: center; padding-left: 20px; }
        .kop-title { font-family: 'Times New Roman', Times, serif; font-size: 24px; font-weight: bold; color: #005c34; margin-bottom: 5px; text-transform: uppercase; }
        .kop-subtitle { font-size: 11px; color: #555; margin-bottom: 3px; }
        .kop-contact { font-size: 10px; color: #777; font-style: italic; }

        .nomor-surat { margin-bottom: 20px; font-weight: bold; }
        .tanggal-surat { text-align: right; margin-bottom: 20px; }
        
        .tujuan-surat { margin-bottom: 25px; }
        .tujuan-surat p { margin: 0; }
        
        .judul-laporan { text-align: center; font-size: 14pt; font-weight: bold; text-decoration: underline; margin-bottom: 25px; text-transform: uppercase; }
        
        .section-title { font-weight: bold; text-decoration: underline; margin-bottom: 10px; margin-top: 20px; display: block; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table td { padding: 5px 0; vertical-align: top; }
        .data-label { width: 160px; }
        .data-separator { width: 15px; text-align: center; }
        
        .hasil-box { background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .hasil-utama { font-size: 13pt; font-weight: bold; color: #005c34; margin-bottom: 10px; }
        
        .rekomendasi { border: 1px dashed #005c34; padding: 15px; margin-top: 20px; background-color: #f0fdf4; }

        .footer-ttd { margin-top: 50px; float: right; width: 250px; text-align: center; }
        .ttd-space { height: 80px; }
        
        .clear { clear: both; }
        
        .watermark { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 9pt; color: #aaa; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td>
                    <img src="{{ public_path('assets/images/logo.png') }}" class="kop-logo">
                </td>
                <td class="kop-detail">
                    <div class="kop-title">RUANG PULIH KESEHATAN MENTAL</div>
                    <div class="kop-subtitle">Platform Layanan Kesehatan Mental & Konseling Digital</div>
                    <div class="kop-subtitle">Izin Operasional Layanan Kesehatan Digital No: 123/RP/HEALTH/2026</div>
                    <div class="kop-contact">Website: ruangpulih.id | Email: support@ruangpulih.id | Telp: (021) 888-9999</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="tanggal-surat">
        Jember, {{ $hasil->tanggal_skrining->translatedFormat('d F Y') }}
    </div>

    <div class="tujuan-surat">
        <p>Yth.</p>
        <p><strong>Tenaga Kesehatan / Bagian Psikologi</strong></p>
        <p><strong>Fasilitas Pelayanan Kesehatan / Rumah Sakit Terkait</strong></p>
        <p>Di Tempat</p>
    </div>

    <div class="judul-laporan">Surat Pengantar Hasil Skrining Kesehatan Mental</div>

    <p>Dengan hormat,</p>
    <p>Melalui surat ini, kami menyampaikan hasil skrining mandiri yang dilakukan oleh pasien kami melalui platform Ruang Pulih. Informasi ini dimaksudkan sebagai data penunjang awal untuk pemeriksaan klinis lebih lanjut di fasilitas pelayanan kesehatan Bapak/Ibu.</p>

    <span class="section-title">I. DATA IDENTITAS PASIEN</span>
    <table class="data-table">
        <tr>
            <td class="data-label">Nama Lengkap</td>
            <td class="data-separator">:</td>
            <td><strong>{{ $pasien->user->nama_lengkap }}</strong></td>
        </tr>
        <tr>
            <td class="data-label">Email / Kontak</td>
            <td class="data-separator">:</td>
            <td>{{ $pasien->user->email }}</td>
        </tr>
        <tr>
            <td class="data-label">Umur</td>
            <td class="data-separator">:</td>
            <td>{{ $pasien->umur ?? '-' }} Tahun</td>
        </tr>
        <tr>
            <td class="data-label">Jenis Kelamin</td>
            <td class="data-separator">:</td>
            <td>{{ ucfirst($pasien->user->jenis_kelamin ?? '-') }}</td>
        </tr>
    </table>

    <span class="section-title">II. HASIL SKRINING MANDIRI</span>
    <div class="hasil-box">
        <table class="data-table" style="margin-bottom: 0;">
            <tr>
                <td class="data-label">Jenis Pemeriksaan</td>
                <td class="data-separator">:</td>
                <td>{{ $hasil->jenisSkrining->nama_skrining }}</td>
            </tr>
            <tr>
                <td class="data-label">Total Skor</td>
                <td class="data-separator">:</td>
                <td><strong>{{ $hasil->total_skor }}</strong></td>
            </tr>
            <tr>
                <td class="data-label">Kategori Hasil</td>
                <td class="data-separator">:</td>
                <td><span class="hasil-utama">{{ $hasil->kategori_hasil }}</span></td>
            </tr>
        </table>
    </div>

    <span class="section-title">III. KETERANGAN ANALISIS & REKOMENDASI</span>
    <div style="text-align: justify; margin-bottom: 20px;">
        <p>{{ $hasil->keterangan_hasil }}</p>
    </div>

    <div class="rekomendasi">
        <strong>Catatan untuk Fasilitas Kesehatan:</strong><br>
        Pasien disarankan untuk mendapatkan asesmen klinis mendalam (pemeriksaan tatap muka) guna menegakkan diagnosis formal dan menentukan rencana terapi yang sesuai. Hasil skrining ini bersifat indikatif berdasarkan laporan mandiri pasien (self-report).
    </div>

    <p style="margin-top: 30px;">Demikian surat pengantar ini kami sampaikan. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>

    <div class="footer-ttd">
        <p>Hormat Kami,</p>
        <p><strong>Tim Psikolog Ruang Pulih</strong></p>
        <div class="ttd-space">
            <img src="{{ public_path('assets/images/logo.png') }}" style="width: 60px; opacity: 0.15; margin-top: 10px;">
        </div>
        <p>(Dokumen ini diterbitkan secara elektronik)</p>
    </div>

    <div class="clear"></div>
</body>
</html>
