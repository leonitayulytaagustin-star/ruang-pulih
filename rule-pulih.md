# 📋 RULE-PULIH.md — Panduan Pengembangan Sistem Ruang Pulih

> Dokumen ini adalah panduan lengkap pengembangan **Sistem Ruang Pulih**, sistem informasi kesehatan mental berbasis web menggunakan **Laravel 12**. Baca seluruh dokumen sebelum memulai pengembangan.

---

## 1. GAMBARAN UMUM SISTEM

**Ruang Pulih** adalah sistem informasi berbasis digital yang dirancang untuk membantu proses skrining dan pemantauan kesehatan mental secara online. Sistem ini bertujuan untuk:

- Membantu pengguna mengenali kondisi kesehatan mental sejak dini
- Memberikan edukasi mengenai kesehatan mental
- Memfasilitasi konsultasi dengan psikolog secara praktis dan terjadwal

### Stack Teknologi

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel 12 |
| Frontend | Blade Template + Tailwind CSS / Bootstrap |
| Database | MySQL |
| Real-time Chat | Laravel Reverb / Pusher |
| Storage | Laravel Storage |

---

## 2. STRUKTUR ROLE & HAK AKSES

Sistem memiliki **4 jenis pengguna** (+ 1 role tamu tanpa login):

| Role | Deskripsi |
|---|---|
| `guest` | Pengunjung belum login — dapat mengakses halaman publik: Edukasi, About, Bantuan |
| `pasien` | Pengguna terdaftar yang menggunakan layanan skrining & konsultasi |
| `psikolog` | Tenaga profesional yang menangani konsultasi & pemantauan |
| `admin` | Pengelola sistem, konten, dan manajemen pengguna |

---

## 3. FITUR PER ROLE

---

### 3.0 ROLE GUEST (Pengunjung Tanpa Login)

Halaman-halaman berikut dapat diakses **tanpa login**. Route berada di grup publik tanpa middleware `auth`.

---

#### 3.0.1 Halaman Edukasi

**Route:** `/edukasi`

**Layout:** Navbar publik (Logo Ruang Pulih, menu: Edukasi *(aktif)*, About, Bantuan, tombol Login/Daftar)

---

**Bagian 1 — Hero Banner:**
- Background warna hijau muda (`#E8F5F0` atau serupa)
- Teks kiri:
  - Heading besar: **"Belajar, Peduli, Pulih Bersama."**
  - Subtext: *"Temukan informasi dan pengetahuan seputar kesehatan mental yang dapat membantu kamu menjalani hidup lebih seimbang."*
  - Tombol CTA: **"Jelajahi Edukasi →"** (warna hijau tua, rounded)
- Ilustrasi kanan: gambar karakter perempuan memeluk diri sendiri di antara tanaman/daun

---

**Bagian 2 — Search Bar:**
- Input search full-width dengan icon kaca pembesar di kiri
- Placeholder: *"Cari artikel, tips, atau video edukasi..."*
- Fungsi: filter konten secara real-time atau submit form search

---

**Bagian 3 — Filter Tab Kategori:**
Tombol tab pill (rounded) untuk filter tipe konten:

| Tab | Filter |
|---|---|
| **Semua** *(default aktif, bg hijau tua)* | Semua konten |
| Artikel | `tipe_konten = 'artikel'` |
| Tips Stres | Filter kategori Tips Stres |
| Video Edukasi | `tipe_konten = 'video'` |

---

**Bagian 4 — Artikel Terbaru:**
- Heading section: **"Artikel Terbaru"**
- Grid 3 kolom, berisi card artikel:

**Struktur Card Artikel:**
- Thumbnail gambar (rasio 16:9, rounded-top)
- Judul artikel (bold, 2 baris maks)
- Deskripsi singkat (2–3 baris, warna abu)
- Footer card: Tanggal publish • Estimasi baca (*misal: "9 Mei 2026 • 6 min baca"*)

**Data dari:** `tb_konten_edukasi` WHERE `tipe_konten = 'artikel'` AND `status = 'publish'`, ORDER BY `tanggal_publish` DESC, LIMIT 6 (atau pagination)

---

**Bagian 5 — Video Edukasi** *(jika ada konten video publish):*
- Heading section: **"Video Edukasi"**
- Grid 3 kolom card video dengan thumbnail + overlay play button + durasi

---

**Halaman Detail Artikel** (`/edukasi/{slug}`):
- Breadcrumb: Beranda > Edukasi > [Judul Artikel]
- Thumbnail besar
- Judul, kategori, tanggal, penulis
- Isi artikel (render HTML dari `isi_artikel`)
- Sidebar: artikel terkait

**Halaman Detail Video** (`/edukasi/video/{slug}`):
- Embed video (YouTube iframe atau HTML5 video)
- Judul, kategori, durasi, tanggal
- Deskripsi video

> 🔒 **Jika guest mencoba fitur skrining/konsultasi** → redirect ke halaman login dengan pesan: *"Silakan login terlebih dahulu untuk mengakses fitur ini."*

---

#### 3.0.2 Halaman About (Tentang)

**Route:** `/about`

**Layout:** Navbar publik (menu About *(aktif)*)

---

**Breadcrumb:** Beranda > Tentang

---

**Bagian 1 — Hero Banner:**
- Background warna hijau muda (sama dengan halaman Edukasi)
- Teks kiri:
  - Label kecil: *"Tentang Ruang Pulih"*
  - Heading besar: **"Tempat aman untuk kesehatan mentalmu."**
  - Subtext: *"Ruang Pulih hadir untuk menemani kamu dalam perjalanan memahami, menjaga, dan memulihkan kesehatan mental. Karena kamu tidak sendirian, dan setiap langkah kecil menuju pulih itu berarti."*
- Ilustrasi kanan: karakter perempuan + tanaman (sama dengan halaman lain)

---

**Bagian 2 — Apa itu Ruang Pulih?**
- Heading: **"Apa itu Ruang Pulih?"**
- Paragraf deskripsi dalam box rounded abu muda:
  > *"Ruang Pulih hadir sebagai ruang aman dan terpercaya untuk semua orang yang ingin hidup lebih seimbang secara mental dan emosional. Kami percaya bahwa setiap orang berhak mendapatkan informasi yang tepat, dukungan yang tulus, dan lingkungan yang positif untuk bertumbuh."*

---

**Bagian 3 — Nilai Utama (3 Card):**

| Card | Icon | Judul | Deskripsi |
|---|---|---|---|
| 1 | 🛡️ Shield | **Aman & Privat** | Kerahasiaanmu adalah prioritas kami. Semua data dan informasi pribadi dilindungi dengan aman. |
| 2 | 📚 Buku | **Edukasi Terpercaya** | Konten kami dibuat oleh ahli dan bersumber dari referensi ilmiah yang terpercaya. |
| 3 | ❤️ Hati | **Dukungan untuk Semua** | Untuk siapa pun, kapan pun. Kamu tidak sendirian, kami ada untuk mendukungmu. |

**Desain card:** icon dalam lingkaran hijau muda, layout 3 kolom grid

---

**Bagian 4 — Fitur yang Tersedia (4 Card):**
- Heading: **"Fitur yang Tersedia"**

| Card | Icon | Judul | Deskripsi |
|---|---|---|---|
| 1 | 📋 | **Skrining Kesehatan Mental** | Kenali kondisi mentalmu melalui tes skrining yang mudah, cepat, dan terpercaya. |
| 2 | 💬 | **Konsultasi Online** | Bicarakan perasaanmu dengan psikolog profesional secara aman dan nyaman. |
| 3 | 📊 | **Pemantauan Kondisi Mental** | Pantau perkembangan emosimu dari waktu ke waktu dengan visualisasi yang mudah dipahami. |
| 4 | ⭐ | **Edukasi & Informasi** | Akses berbagai artikel, tips, dan video edukasi untuk hidup lebih seimbang. |

**Desain card:** icon dalam lingkaran hijau muda, layout 4 kolom grid, teks lebih kecil

---

**Bagian 5 — Visi & Misi:**
- Heading: **"Visi & Misi"**
- **Card Visi** (setengah lebar):
  - Icon mata dalam lingkaran hijau
  - Label: **Visi**
  - Teks: *"Menjadi platform terdepan dalam mendukung kesehatan mental masyarakat Indonesia melalui teknologi dan edukasi yang mudah diakses oleh semua."*
- **Card Misi** (setengah lebar):
  - Icon target/grafik dalam lingkaran hijau
  - Label: **Misi**
  - Bullet list:
    - Meningkatkan literasi kesehatan mental di masyarakat.
    - Menyediakan akses dukungan mental yang mudah dan terjangkau.
    - Membangun komunitas yang peduli dan saling mendukung.

---

**Bagian 6 — Banner Motivasi (Full Width):**
- Background hijau muda, teks di tengah/kiri:
  - Kalimat: **"Kesehatan mental adalah bagian penting dari hidup yang berkualitas."**
  - Subtext: *"Yuk, mulai perjalanan pulihmu bersama Ruang Pulih hari ini. Kamu berharga, dan kamu tidak sendiri."*
- Icon daun/tanaman kecil sebagai dekorasi

---

#### 3.0.3 Halaman Bantuan

**Route:** `/bantuan`

**Layout:** Navbar publik (menu Bantuan *(aktif)*)

---

**Breadcrumb:** Beranda > Bantuan

---

**Bagian 1 — Hero Banner:**
- Background warna hijau muda
- Teks kiri:
  - Heading besar: **"Bantuan untukmu"**
  - Subtext: *"Kami siap membantumu kapan pun kamu membutuhkan bantuan. Pilih jenis bantuan yang sesuai dengan kebutuhanmu."*
- Ilustrasi kanan: karakter perempuan + tanaman

---

**Bagian 2 — Grid Kartu Bantuan (3 kolom × 2 baris = 6 card):**

**Card 1 — Bantuan Darurat:**
- Ilustrasi/icon: lingkaran hijau (placeholder atau ikon telepon darurat)
- Judul: **"Bantuan Darurat"**
- Deskripsi: *"Bantuan cepat untuk kamu yang mengalami kondisi emosional darurat atau membutuhkan dukungan segera."*
- Divider
- List item:
  - 📞 Kontak layanan darurat
- Tombol panah `>` (lingkaran hijau) di kanan bawah → menuju halaman/modal kontak darurat

**Card 2 — Keamanan Akun:**
- Judul: **"Keamanan Akun"**
- Deskripsi: *"Membantu menjaga keamanan akun agar tetap aman."*
- Divider
- List item (dengan icon status):
  - ✅ Ganti kata sandi
  - ✅ Verifikasi akun
  - 👤 Aktivitas login mencurigakan
- Tombol panah `>` → halaman panduan keamanan akun

**Card 3 — Reset Kata Sandi:**
- Judul: **"Reset Kata Sandi"**
- Deskripsi: *"Bantuan untuk memulihkan akses akun jika lupa kata sandi atau tidak bisa login."*
- Divider
- List item:
  - ❌ Lupa Password
  - Reset melalui email
- Tombol panah `>` → `/forgot-password`

**Card 4 — Pusat Bantuan:**
- Judul: **"Pusat Bantuan"**
- Deskripsi: *"Kumpulan informasi untuk membantu pengguna menggunakan aplikasi dengan mudah."*
- Divider
- List item:
  - FAQ
  - Informasi akun
- Tombol panah `>` → halaman FAQ

**Card 5 — Laporkan Masalah:**
- Judul: **"Laporkan Masalah"**
- Deskripsi: *"Laporkan kendala atau aktivitas yang tidak sesuai di dalam aplikasi."*
- Divider
- List item:
  - 🔔 Laporkan bug aplikasi
  - ❌ Konten tidak pantas
  - 👤 Penyalahgunaan akun
- Tombol panah `>` → form laporan masalah

**Card 6 — Saran & Masukan:**
- Judul: **"Saran & Masukan"**
- Deskripsi: *"Pengguna dapat memberikan masukan untuk meningkatkan kualitas aplikasi."*
- Divider
- List item:
  - 💬 Kritik & saran
  - ⭐ Penilaian layanan
- Tombol panah `>` → form saran & masukan

---

**Desain card bantuan:**
- Border rounded, shadow tipis
- Header card: ilustrasi lingkaran hijau (bisa ikon atau placeholder image)
- Judul bold warna hijau tua
- List item dengan ikon kecil di kiri
- Tombol arrow di kanan bawah: lingkaran hijau dengan icon `>`

---

#### 3.0.4 Navbar Publik (Komponen Bersama)

Digunakan di semua halaman guest (Edukasi, About, Bantuan):

```
[Logo Ruang Pulih]  [Nama: Ruang Pulih / Tagline: Tempat aman untuk kesehatan mentalmu]
                                    [Edukasi]  [About]  [Bantuan]        [🔒 Login / Daftar]
```

- **Logo:** ikon tumbuhan/kesehatan berwarna hijau
- **Menu aktif:** background pill/rounded hijau tua, teks putih
- **Menu nonaktif:** teks abu gelap, hover hijau
- **Tombol Login/Daftar:** border rounded, icon akun di kiri, teks "Login / Daftar"

---

#### 3.0.5 Route Publik (Guest)

```php
// routes/web.php — Grup publik (tanpa middleware auth)
Route::get('/edukasi', [EdukasiPublikController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{slug}', [EdukasiPublikController::class, 'show'])->name('edukasi.show');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan.index');
```

---

### 3.1 ROLE ADMIN

#### 3.1.1 Dashboard Admin

**Route:** `/admin/dashboard`

**Komponen halaman:**
- **4 Card Stats:**
  1. Total Artikel
  2. Total Video
  3. Total Pasien
  4. Total Konsultasi
- **Card Tambah Artikel** — tombol shortcut menuju form tambah artikel
- **Tabel Artikel Edukasi Terbaru:**

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Judul Artikel | Judul konten artikel |
| Kategori | Kategori artikel |
| Tanggal Dibuat | `created_at` |
| Status | `draft` / `publish` — badge berwarna |
| Aksi | Tombol: Edit, Hapus, Detail |

- **Tabel Video Edukasi Terbaru:**

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Judul Video | Judul konten video |
| Durasi | Durasi video (format mm:ss) |
| Tanggal Dibuat | `created_at` |
| Status | `draft` / `publish` — badge berwarna |
| Aksi | Tombol: Edit, Hapus, Detail |

---

#### 3.1.2 Manajemen Pasien

**Route:** `/admin/pasien`

**Komponen halaman:**
- Search input — berdasarkan nama pasien
- Filter dropdown — Jenis Kelamin (Semua / Laki-laki / Perempuan)
- **Tabel Pasien:**

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Nama Pasien | `nama_lengkap` dari `tb_user` |
| Email | Email pasien |
| Tanggal Daftar | `tanggal_daftar` dari `tb_pasien` |
| Nomor Telepon | `nomor_telepon` |
| Jenis Kelamin | Laki-laki / Perempuan |
| Aksi | Tombol: Detail |

---

#### 3.1.3 Manajemen Psikolog

**Route:** `/admin/psikolog`

**Komponen halaman:**
- Search input — berdasarkan nama psikolog atau nomor SIPA
- Tombol **Tambah Psikolog** → Modal popup form tambah psikolog
- Filter dropdown — Spesialisasi
- **Tabel Psikolog:**

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Nama Psikolog | `nama_lengkap` |
| Email | Email psikolog |
| Spesialisasi | `spesialisasi` |
| Nomor Telepon | `nomor_telepon` |
| Nomor SIPA | `nomor_sipa` |
| Aksi | Tombol: Edit, Hapus, Detail |

**Form Modal Tambah/Edit Psikolog:**
- Nama Lengkap
- Email
- Password (hanya tambah)
- Nomor Telepon
- Jenis Kelamin
- Spesialisasi
- Nomor SIPA
- Pendidikan
- Pengalaman (tahun)
- Bio (textarea)

---

#### 3.1.4 Manajemen Edukasi

**Route:** `/admin/edukasi`

**Komponen halaman:**
- Search input — berdasarkan judul artikel / judul video
- Tombol **Tambah Artikel** → Modal popup tambah artikel
- Tombol **Tambah Video** → Modal popup tambah video
- Filter — Tipe Konten: Artikel / Video
- **Tabel Konten Edukasi:**

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Judul Konten | Judul artikel atau video |
| Kategori | Kategori konten |
| Penulis | Nama admin/psikolog yang menambahkan |
| Tanggal Dibuat | `created_at` |
| Status | `draft` / `publish` — badge berwarna |
| Aksi | Tombol: Edit, Hapus, Detail |

**Form Modal Tambah Artikel:**
- Judul Artikel
- Kategori (dropdown)
- Isi Artikel (rich text editor / textarea)
- Thumbnail (upload file)
- Status (draft / publish)

**Form Modal Tambah Video:**
- Judul Video
- Kategori (dropdown)
- URL Video (YouTube/embed)
- Durasi (format mm:ss)
- Thumbnail (upload file)
- Status (draft / publish)

---

#### 3.1.5 Manajemen Admin

**Route:** `/admin/admin`

**Komponen halaman:**
- Search input — berdasarkan nama admin
- Tombol **Tambah Admin** → Modal popup tambah admin
- **Tabel Admin:**

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Nama Admin | `nama_lengkap` |
| Email | Email admin |
| Jenis Kelamin | Laki-laki / Perempuan |
| Nomor Telepon | `nomor_telepon` |
| Aksi | Edit, Hapus, Detail (jika akun sendiri: hanya Detail & Edit) |

> ⚠️ **Rule:** Admin yang sedang login tidak dapat menghapus akunnya sendiri. Tombol Hapus disembunyikan untuk akun aktif.

---

#### 3.1.6 Manajemen Skrining

**Route:** `/admin/skrining`

**Komponen halaman:**
- Search input — berdasarkan jenis penyakit
- Tombol **Tambah Penyakit** → Modal popup tambah jenis skrining
- Tombol **Panduan Pengelolaan Skrining** → Modal popup tampilkan panduan
- **Tabel Jenis Skrining:**

| Kolom | Keterangan |
|---|---|
| No | Nomor urut |
| Jenis Skrining | `nama_skrining` |
| Deskripsi | `deskripsi` |
| Jumlah Pertanyaan | `jumlah_pertanyaan` |
| Status | `draft` / `publish` — badge berwarna |
| Aksi | Tombol: Edit, Hapus |

**Form Modal Tambah/Edit Jenis Skrining:**
- Nama Skrining
- Jenis Penyakit
- Deskripsi (textarea)
- Panduan Pengelolaan (textarea)
- Status (draft / publish)

---

#### 3.1.7 Manajemen Pertanyaan

**Route:** `/admin/skrining/{id}/pertanyaan`

**Komponen halaman:**
- Card daftar jenis skrining dengan tombol **Kelola** → diarahkan ke halaman pengelolaan pertanyaan

**Halaman Pengelolaan Pertanyaan:**
- Input teks pertanyaan
- Tombol **+ Tambah Jawaban** untuk setiap pertanyaan:
  - Input teks jawaban
  - Input nilai jawaban (angka)
- Tombol **+ Tambah Pertanyaan** untuk menambah pertanyaan baru
- Tombol **Simpan** untuk menyimpan semua pertanyaan & jawaban

---

### 3.2 ROLE PSIKOLOG

#### 3.2.1 Dashboard Psikolog

**Route:** `/psikolog/dashboard`

**Komponen halaman:**
- **3 Card Stats:**
  1. Total Konsultasi Hari Ini
  2. Total Pasien (yang pernah konsultasi)
  3. Total Risiko Tinggi (pasien dengan skor tinggi)

- **Card Tabel Jadwal Konsultasi Hari Ini:**

| Kolom | Keterangan |
|---|---|
| Waktu | Jam mulai konsultasi |
| Pasien | Nama pasien |
| Jenis Konsultasi | Tipe konsultasi |
| Status | `selesai` / `berlangsung` / `follow up` / `terjadwal` — badge |
| Aksi | Icon chat → halaman chat konsultasi |

- **Card Tabel Ringkasan Pasien Terbaru** (ada tombol "Lihat Semua"):

| Kolom | Keterangan |
|---|---|
| Nama Pasien | Nama pasien |
| Kondisi Terakhir | Contoh: Stres Ringan |
| Skor Terakhir | Nilai skor terakhir |
| Perubahan | `membaik` / `memburuk` — badge berwarna |

- **Card Tabel Pasien yang Perlu Perhatian:**

| Kolom | Keterangan |
|---|---|
| Nama Pasien | Nama pasien |
| Keterangan | Catatan kondisi |
| Prioritas | `Prioritas Tinggi` / `Prioritas Sedang` — badge |

- **Card Grafik Perkembangan Pasien** — Line chart / Bar chart perkembangan skor pasien

---

#### 3.2.2 Konsultasi Online

**Route:** `/psikolog/konsultasi`

**Komponen halaman:**
- **3 Card Stats:**
  1. Total Permintaan Baru
  2. Total Selesai Hari Ini
  3. Total Konsultasi Semua Sesi

- **Card Permintaan Konsultasi** — Berisi card per permintaan:
  - Nama pasien
  - Tanggal permintaan
  - Tombol **Detail** → Modal popup detail permintaan
  - Tombol **Tolak** → konfirmasi penolakan
  - Tombol **Setuju** → berubah menjadi tombol **Mulai** → diarahkan ke halaman chat konsultasi

**Status alur permintaan:**
```
Permintaan Baru → Disetujui → Berlangsung → Selesai / Follow Up
              ↘ Ditolak
```

---

#### 3.2.3 Pemantauan Kondisi Mental (Psikolog)

**Route:** `/psikolog/pemantauan`

**Komponen halaman:**
- **4 Card Stats:**
  1. Total Pasien Dipantau
  2. Total Perkembangan Membaik
  3. Total Perkembangan Memburuk
  4. Total Kondisi Stabil

- **Tabel Daftar Pasien yang Dipantau:**

| Kolom | Keterangan |
|---|---|
| Nama Pasien | Nama pasien |
| Skor Terakhir | Nilai skor terakhir |
| Perubahan | `membaik` / `memburuk` / `stabil` |
| Status | Badge kondisi |
| Tanggal Skrining Terakhir | `tanggal_skrining` |
| Aksi | Tombol Detail → halaman ringkasan perkembangan |

**Halaman Detail Perkembangan Pasien** (`/psikolog/pemantauan/{id_pasien}`):
- Nama pasien
- Skor terakhir
- Card grafik perkembangan (Line chart skor dari waktu ke waktu)
- Tombol **Kembali**

---

### 3.3 ROLE PASIEN

#### 3.3.1 Dashboard Pasien

**Route:** `/pasien/dashboard`

**Komponen halaman:**
- **Card Mood Harian:** "Bagaimana mood kamu hari ini?" — pilihan emoji mood
- **Card Riwayat Aktivitas Singkat** — list aktivitas terbaru pasien (skrining, konsultasi, dll.)

---

#### 3.3.2 Daftar Tes Skrining Mental

**Route:** `/pasien/skrining`

**Alur:**

**Langkah 1 — Isi Identitas Diri:**
- Nama Lengkap (input text)
- Umur (input number)
- Jenis Kelamin (dropdown)
- Email (input email)

**Langkah 2 — Riwayat Kesehatan:**
- "Apakah anda pernah mengalami gangguan kesehatan mental sebelumnya?" → Radio: Ya / Tidak
- "Jika ya, sebutkan jenis gangguan yang pernah dialami" → Input text (opsional), placeholder: *contoh: depresi, kecemasan, gangguan panik, dll*
- "Apakah anda sedang mengonsumsi obat-obatan tertentu?" → Radio: Ya / Tidak
- "Jika ya, sebutkan obat yang dikonsumsi" → Input text (opsional), placeholder: *sebutkan nama obat dan dosis*
- "Riwayat penyakit fisik yang pernah atau sedang anda alami" → Textarea (opsional), placeholder: *contoh: hipertensi, diabetes, asma, dll*
- "Catatan tambahan (opsional)" → Textarea, placeholder: *tuliskan hal lain yang menurut anda penting*

- Tombol **Daftar Skrining** → diarahkan ke halaman pilih tes skrining

**Langkah 3 — Pilih Tes Skrining** (`/pasien/skrining/pilih`):
- Card per jenis skrining:
  - Judul tes
  - Deskripsi tes
  - Tombol **Mulai Tes** → diarahkan ke halaman tes

**Langkah 4 — Halaman Tes** (`/pasien/skrining/{id}/tes`):
- Pertanyaan satu per satu (navigasi dengan tombol Sebelumnya / Selanjutnya)
- Pilihan jawaban (radio button sesuai `tb_jawaban_skrining`)
- Card Informasi Tes (sidebar)
- Card Petunjuk
- Tombol **Simpan** → simpan hasil dan redirect ke halaman hasil skoring

**Langkah 5 — Hasil Skoring** (`/pasien/skrining/hasil/{id}`):
- Tampilkan total skor
- Kategori hasil (ringan / sedang / berat)
- Keterangan hasil
- Rekomendasi (konsultasi jika skor tinggi)

---

#### 3.3.3 Pendaftaran Konsultasi Online

**Route:** `/pasien/konsultasi`

**Alur:**

**Langkah 1 — Lengkapi Data:**
- Nama Lengkap (input text)
- Umur (input number)
- Jenis Kelamin (dropdown)
- Email (input email)
- Keluhan (textarea)
- Tingkat Urgensi (dropdown): Rendah / Sedang / Tinggi
- Checkbox: *Saya menyetujui syarat & ketentuan serta kebijakan privasi yang berlaku*
- Tombol **Lanjut Pilih Psikolog**

**Langkah 2 — Pilih Psikolog** (`/pasien/konsultasi/pilih-psikolog`):
- Search input — nama psikolog atau spesialisasi
- Card per psikolog:
  - Nama, spesialisasi, bio singkat, foto
  - Tombol **Pilih** → diarahkan ke halaman pilih jadwal

**Langkah 3 — Pilih Jadwal** (`/pasien/konsultasi/jadwal/{id_psikolog}`):
- Card info psikolog
- Card Kalender — pilih tanggal tersedia
- Card Pilih Waktu — slot waktu tersedia sesuai `tb_jadwal_psikolog`
- Tombol **Simpan** → diarahkan ke halaman menunggu persetujuan

**Langkah 4 — Menunggu Persetujuan** (`/pasien/konsultasi/menunggu`):
- Status permintaan (menunggu / disetujui / ditolak)
- Jika disetujui → tombol **Mulai Konsultasi** → halaman chat konsultasi

**Halaman Chat Konsultasi** (`/pasien/konsultasi/chat/{id_konsultasi}`):
- Antarmuka chat real-time dengan psikolog
- Upload file lampiran
- Status baca pesan

**Halaman Riwayat Konsultasi** (`/pasien/konsultasi/riwayat`):
- Daftar riwayat konsultasi dengan status

---

#### 3.3.4 Pemantauan Kondisi Mental (Pasien)

**Route:** `/pasien/pemantauan`

**Alur:**

**Langkah 1 — Isi Pertanyaan Harian:**
- Card berisi pertanyaan-pertanyaan pemantauan dengan pilihan emoji
- Pertanyaan default:
  1. "Apakah kamu merasa sedih hari ini?"
  2. "Apakah kamu merasa cemas atau khawatir?"
  3. "Apakah kamu merasa tidak berharga atau putus asa?"
  4. "Apakah kamu pernah mendengar suara yang orang lain tidak dengar?"
- Navigasi: Tombol **Sebelumnya** / Tombol **Kirim**

**Langkah 2 — Hasil Pemantauan Hari Ini** (`/pasien/pemantauan/hasil`):
- Card kondisi mental hari ini + emoji
- Card skor kondisi mental
- Card ringkasan jawaban
- Card grafik perkembangan kondisi mental (Line chart historis)
- Card kondisi mental: `baik` / `sedang` / `parah`
  - Jika `parah` → tampilkan tombol **Lanjut ke Konsultasi Psikolog**

---

## 4. STRUKTUR DATABASE

### 4.1 Daftar Tabel

| No | Nama Tabel | Fungsi |
|---|---|---|
| 1 | `tb_user` | Data akun semua pengguna |
| 2 | `tb_pasien` | Data profil pasien |
| 3 | `tb_admin` | Data profil admin |
| 4 | `tb_psikolog` | Data profil psikolog |
| 5 | `tb_kategori_edukasi` | Kategori konten edukasi |
| 6 | `tb_konten_edukasi` | Artikel dan video edukasi |
| 7 | `tb_jenis_skrining` | Jenis/tipe tes skrining mental |
| 8 | `tb_pertanyaan_skrining` | Pertanyaan tes skrining |
| 9 | `tb_jawaban_skrining` | Pilihan jawaban skrining beserta nilai |
| 10 | `tb_pendaftaran_skrining` | Data identitas saat mendaftar skrining |
| 11 | `tb_hasil_skrining` | Hasil/skor tes skrining pasien |
| 12 | `tb_detail_hasil_skrining` | Detail jawaban per pertanyaan |
| 13 | `tb_pendaftaran_konsultasi` | Data pendaftaran konsultasi |
| 14 | `tb_jadwal_psikolog` | Jadwal ketersediaan psikolog |
| 15 | `tb_konsultasi` | Sesi konsultasi aktif |
| 16 | `tb_chat_konsultasi` | Pesan chat konsultasi |
| 17 | `tb_pemantauan_mental` | Data pemantauan harian pasien |
| 18 | `tb_pertanyaan_pemantauan` | Pertanyaan pemantauan harian |
| 19 | `tb_jawaban_pemantauan` | Jawaban pemantauan harian |
| 20 | `tb_ringkasan_pasien` | Ringkasan kondisi pasien untuk psikolog |
| 21 | `tb_riwayat_aktivitas_pasien` | Log aktivitas pasien |
| 22 | `tb_mood_harian` | Mood harian pasien |
| 23 | `tb_notifikasi` | Notifikasi sistem per user |
| 24 | `tb_log_aktivitas_admin` | Log aktivitas admin |

---

### 4.2 Skema Tabel Lengkap

#### tb_user
```php
Schema::create('tb_user', function (Blueprint $table) {
    $table->id('id_user');
    $table->string('nama_lengkap');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('nomor_telepon')->nullable();
    $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
    $table->enum('role', ['admin', 'psikolog', 'pasien', 'pengunjung'])->default('pengunjung');
    $table->string('foto_profil')->nullable();
    $table->enum('status_akun', ['aktif', 'nonaktif', 'pending'])->default('aktif');
    $table->rememberToken();
    $table->timestamps();
});
```

#### tb_pasien
```php
Schema::create('tb_pasien', function (Blueprint $table) {
    $table->id('id_pasien');
    $table->unsignedBigInteger('id_user');
    $table->integer('umur')->nullable();
    $table->date('tanggal_daftar')->nullable();
    $table->text('alamat')->nullable();
    $table->enum('status_pasien', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
    $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
});
```

#### tb_admin
```php
Schema::create('tb_admin', function (Blueprint $table) {
    $table->id('id_admin');
    $table->unsignedBigInteger('id_user');
    $table->unsignedBigInteger('dibuat_oleh')->nullable();
    $table->timestamps();
    $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
});
```

#### tb_psikolog
```php
Schema::create('tb_psikolog', function (Blueprint $table) {
    $table->id('id_psikolog');
    $table->unsignedBigInteger('id_user');
    $table->string('spesialisasi')->nullable();
    $table->string('nomor_sipa')->unique();
    $table->string('pendidikan')->nullable();
    $table->integer('pengalaman')->nullable()->comment('dalam tahun');
    $table->text('bio')->nullable();
    $table->enum('status_psikolog', ['aktif', 'nonaktif'])->default('aktif');
    $table->unsignedBigInteger('dibuat_oleh')->nullable();
    $table->timestamps();
    $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
});
```

#### tb_kategori_edukasi
```php
Schema::create('tb_kategori_edukasi', function (Blueprint $table) {
    $table->id('id_kategori');
    $table->string('nama_kategori');
    $table->text('deskripsi')->nullable();
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});
```

#### tb_konten_edukasi
```php
Schema::create('tb_konten_edukasi', function (Blueprint $table) {
    $table->id('id_konten');
    $table->unsignedBigInteger('id_kategori');
    $table->unsignedBigInteger('id_penulis');
    $table->enum('tipe_konten', ['artikel', 'video']);
    $table->string('judul_konten');
    $table->string('slug')->unique();
    $table->longText('isi_artikel')->nullable();
    $table->string('url_video')->nullable();
    $table->string('durasi_video')->nullable();
    $table->string('thumbnail')->nullable();
    $table->enum('status', ['draft', 'publish'])->default('draft');
    $table->timestamp('tanggal_publish')->nullable();
    $table->timestamps();
    $table->foreign('id_kategori')->references('id_kategori')->on('tb_kategori_edukasi');
    $table->foreign('id_penulis')->references('id_user')->on('tb_user');
});
```

#### tb_jenis_skrining
```php
Schema::create('tb_jenis_skrining', function (Blueprint $table) {
    $table->id('id_jenis_skrining');
    $table->string('nama_skrining');
    $table->string('jenis_penyakit');
    $table->text('deskripsi')->nullable();
    $table->enum('status', ['draft', 'publish'])->default('draft');
    $table->integer('jumlah_pertanyaan')->default(0);
    $table->text('panduan_pengelolaan')->nullable();
    $table->unsignedBigInteger('dibuat_oleh')->nullable();
    $table->timestamps();
});
```

#### tb_pertanyaan_skrining
```php
Schema::create('tb_pertanyaan_skrining', function (Blueprint $table) {
    $table->id('id_pertanyaan');
    $table->unsignedBigInteger('id_jenis_skrining');
    $table->text('pertanyaan');
    $table->integer('urutan')->default(1);
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
    $table->foreign('id_jenis_skrining')->references('id_jenis_skrining')->on('tb_jenis_skrining')->onDelete('cascade');
});
```

#### tb_jawaban_skrining
```php
Schema::create('tb_jawaban_skrining', function (Blueprint $table) {
    $table->id('id_jawaban');
    $table->unsignedBigInteger('id_pertanyaan');
    $table->string('teks_jawaban');
    $table->integer('nilai_jawaban')->default(0);
    $table->integer('urutan')->default(1);
    $table->timestamps();
    $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('tb_pertanyaan_skrining')->onDelete('cascade');
});
```

#### tb_pendaftaran_skrining
```php
Schema::create('tb_pendaftaran_skrining', function (Blueprint $table) {
    $table->id('id_pendaftaran_skrining');
    $table->unsignedBigInteger('id_pasien');
    $table->string('nama_lengkap');
    $table->integer('umur');
    $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
    $table->string('email');
    $table->boolean('pernah_gangguan_mental')->default(false);
    $table->text('jenis_gangguan')->nullable();
    $table->boolean('sedang_konsumsi_obat')->default(false);
    $table->text('nama_obat_dosis')->nullable();
    $table->text('riwayat_penyakit_fisik')->nullable();
    $table->text('catatan_tambahan')->nullable();
    $table->timestamps();
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
});
```

#### tb_hasil_skrining
```php
Schema::create('tb_hasil_skrining', function (Blueprint $table) {
    $table->id('id_hasil_skrining');
    $table->unsignedBigInteger('id_pasien');
    $table->unsignedBigInteger('id_jenis_skrining');
    $table->integer('total_skor')->default(0);
    $table->string('kategori_hasil')->nullable(); // ringan, sedang, berat
    $table->text('keterangan_hasil')->nullable();
    $table->date('tanggal_skrining');
    $table->timestamps();
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
    $table->foreign('id_jenis_skrining')->references('id_jenis_skrining')->on('tb_jenis_skrining');
});
```

#### tb_detail_hasil_skrining
```php
Schema::create('tb_detail_hasil_skrining', function (Blueprint $table) {
    $table->id('id_detail_hasil');
    $table->unsignedBigInteger('id_hasil_skrining');
    $table->unsignedBigInteger('id_pertanyaan');
    $table->unsignedBigInteger('id_jawaban');
    $table->integer('nilai_jawaban')->default(0);
    $table->timestamps();
    $table->foreign('id_hasil_skrining')->references('id_hasil_skrining')->on('tb_hasil_skrining')->onDelete('cascade');
    $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('tb_pertanyaan_skrining');
    $table->foreign('id_jawaban')->references('id_jawaban')->on('tb_jawaban_skrining');
});
```

#### tb_pendaftaran_konsultasi
```php
Schema::create('tb_pendaftaran_konsultasi', function (Blueprint $table) {
    $table->id('id_pendaftaran_konsultasi');
    $table->unsignedBigInteger('id_pasien');
    $table->string('nama_lengkap');
    $table->integer('umur');
    $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
    $table->string('email');
    $table->text('keluhan');
    $table->enum('tingkat_urgensi', ['rendah', 'sedang', 'tinggi'])->default('rendah');
    $table->boolean('persetujuan_syarat')->default(false);
    $table->enum('status_pendaftaran', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
    $table->timestamps();
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
});
```

#### tb_jadwal_psikolog
```php
Schema::create('tb_jadwal_psikolog', function (Blueprint $table) {
    $table->id('id_jadwal');
    $table->unsignedBigInteger('id_psikolog');
    $table->date('tanggal');
    $table->time('jam_mulai');
    $table->time('jam_selesai');
    $table->enum('status_jadwal', ['tersedia', 'terpakai', 'libur'])->default('tersedia');
    $table->timestamps();
    $table->foreign('id_psikolog')->references('id_psikolog')->on('tb_psikolog');
});
```

#### tb_konsultasi
```php
Schema::create('tb_konsultasi', function (Blueprint $table) {
    $table->id('id_konsultasi');
    $table->unsignedBigInteger('id_pendaftaran_konsultasi');
    $table->unsignedBigInteger('id_pasien');
    $table->unsignedBigInteger('id_psikolog');
    $table->unsignedBigInteger('id_jadwal')->nullable();
    $table->string('jenis_konsultasi')->default('online');
    $table->date('tanggal_konsultasi')->nullable();
    $table->time('waktu_mulai')->nullable();
    $table->time('waktu_selesai')->nullable();
    $table->enum('status_konsultasi', [
        'permintaan_baru', 'disetujui', 'ditolak',
        'terjadwal', 'berlangsung', 'follow_up', 'selesai'
    ])->default('permintaan_baru');
    $table->text('catatan_psikolog')->nullable();
    $table->timestamps();
    $table->foreign('id_pendaftaran_konsultasi')->references('id_pendaftaran_konsultasi')->on('tb_pendaftaran_konsultasi');
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
    $table->foreign('id_psikolog')->references('id_psikolog')->on('tb_psikolog');
    $table->foreign('id_jadwal')->references('id_jadwal')->on('tb_jadwal_psikolog')->nullOnDelete();
});
```

#### tb_chat_konsultasi
```php
Schema::create('tb_chat_konsultasi', function (Blueprint $table) {
    $table->id('id_chat');
    $table->unsignedBigInteger('id_konsultasi');
    $table->unsignedBigInteger('id_pengirim');
    $table->text('pesan')->nullable();
    $table->enum('tipe_pesan', ['teks', 'file', 'gambar'])->default('teks');
    $table->string('file_lampiran')->nullable();
    $table->timestamp('waktu_kirim')->nullable();
    $table->boolean('status_baca')->default(false);
    $table->timestamps();
    $table->foreign('id_konsultasi')->references('id_konsultasi')->on('tb_konsultasi')->onDelete('cascade');
    $table->foreign('id_pengirim')->references('id_user')->on('tb_user');
});
```

#### tb_pemantauan_mental
```php
Schema::create('tb_pemantauan_mental', function (Blueprint $table) {
    $table->id('id_pemantauan');
    $table->unsignedBigInteger('id_pasien');
    $table->date('tanggal_pemantauan');
    $table->integer('total_skor')->default(0);
    $table->enum('kondisi_mental', ['baik', 'sedang', 'parah'])->default('baik');
    $table->string('emoji_kondisi')->nullable();
    $table->text('keterangan')->nullable();
    $table->timestamps();
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
});
```

#### tb_pertanyaan_pemantauan
```php
Schema::create('tb_pertanyaan_pemantauan', function (Blueprint $table) {
    $table->id('id_pertanyaan_pemantauan');
    $table->text('pertanyaan');
    $table->integer('urutan')->default(1);
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});
```

#### tb_jawaban_pemantauan
```php
Schema::create('tb_jawaban_pemantauan', function (Blueprint $table) {
    $table->id('id_jawaban_pemantauan');
    $table->unsignedBigInteger('id_pemantauan');
    $table->unsignedBigInteger('id_pertanyaan_pemantauan');
    $table->string('emoji_jawaban')->nullable();
    $table->integer('nilai_jawaban')->default(0);
    $table->timestamps();
    $table->foreign('id_pemantauan')->references('id_pemantauan')->on('tb_pemantauan_mental')->onDelete('cascade');
    $table->foreign('id_pertanyaan_pemantauan')->references('id_pertanyaan_pemantauan')->on('tb_pertanyaan_pemantauan');
});
```

#### tb_ringkasan_pasien
```php
Schema::create('tb_ringkasan_pasien', function (Blueprint $table) {
    $table->id('id_ringkasan');
    $table->unsignedBigInteger('id_pasien');
    $table->string('kondisi_terakhir')->nullable();
    $table->integer('skor_terakhir')->default(0);
    $table->enum('perubahan', ['membaik', 'memburuk', 'stabil'])->default('stabil');
    $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('rendah');
    $table->text('keterangan')->nullable();
    $table->date('tanggal_update')->nullable();
    $table->timestamps();
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
});
```

#### tb_riwayat_aktivitas_pasien
```php
Schema::create('tb_riwayat_aktivitas_pasien', function (Blueprint $table) {
    $table->id('id_aktivitas');
    $table->unsignedBigInteger('id_pasien');
    $table->enum('jenis_aktivitas', ['skrining', 'konsultasi', 'pemantauan_mental', 'membaca_artikel', 'menonton_video']);
    $table->text('keterangan')->nullable();
    $table->timestamp('tanggal_aktivitas')->nullable();
    $table->timestamps();
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
});
```

#### tb_mood_harian
```php
Schema::create('tb_mood_harian', function (Blueprint $table) {
    $table->id('id_mood');
    $table->unsignedBigInteger('id_pasien');
    $table->string('mood')->nullable(); // bahagia, sedih, netral, dll
    $table->string('emoji_mood')->nullable();
    $table->text('catatan')->nullable();
    $table->date('tanggal_mood');
    $table->timestamps();
    $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
});
```

#### tb_notifikasi
```php
Schema::create('tb_notifikasi', function (Blueprint $table) {
    $table->id('id_notifikasi');
    $table->unsignedBigInteger('id_user');
    $table->string('judul_notifikasi');
    $table->text('isi_notifikasi');
    $table->string('tipe_notifikasi')->nullable(); // konsultasi, skrining, sistem
    $table->boolean('status_baca')->default(false);
    $table->timestamps();
    $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
});
```

#### tb_log_aktivitas_admin
```php
Schema::create('tb_log_aktivitas_admin', function (Blueprint $table) {
    $table->id('id_log');
    $table->unsignedBigInteger('id_admin');
    $table->text('aktivitas');
    $table->string('tabel_terkait')->nullable();
    $table->unsignedBigInteger('id_data_terkait')->nullable();
    $table->timestamp('waktu_aktivitas')->nullable();
    $table->timestamps();
    $table->foreign('id_admin')->references('id_admin')->on('tb_admin');
});
```

---

## 5. SEEDER DATA

### 5.1 UserSeeder

```php
<?php
// database/seeders/UserSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_user')->insert([
            // Admin
            [
                'nama_lengkap' => 'Super Admin',
                'email' => 'admin@ruangpulih.id',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '081234567890',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'admin',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Dewi Rahayu',
                'email' => 'dewi.admin@ruangpulih.id',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '081298765432',
                'jenis_kelamin' => 'perempuan',
                'role' => 'admin',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Psikolog
            [
                'nama_lengkap' => 'Dr. Sari Indah Puspita, M.Psi',
                'email' => 'sari.psikolog@ruangpulih.id',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '082134567891',
                'jenis_kelamin' => 'perempuan',
                'role' => 'psikolog',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Dr. Budi Santoso, M.Psi',
                'email' => 'budi.psikolog@ruangpulih.id',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '082198765433',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'psikolog',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Dr. Anita Wijayanti, M.Psi',
                'email' => 'anita.psikolog@ruangpulih.id',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '083112345678',
                'jenis_kelamin' => 'perempuan',
                'role' => 'psikolog',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pasien
            [
                'nama_lengkap' => 'Rizky Pratama',
                'email' => 'rizky@gmail.com',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '085123456789',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'pasien',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Ayu Maharani',
                'email' => 'ayu@gmail.com',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '085198765432',
                'jenis_kelamin' => 'perempuan',
                'role' => 'pasien',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Dika Nugraha',
                'email' => 'dika@gmail.com',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '086123456789',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'pasien',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Fira Azzahra',
                'email' => 'fira@gmail.com',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '087123456789',
                'jenis_kelamin' => 'perempuan',
                'role' => 'pasien',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Hendra Kusuma',
                'email' => 'hendra@gmail.com',
                'password' => Hash::make('password123'),
                'nomor_telepon' => '088123456789',
                'jenis_kelamin' => 'laki-laki',
                'role' => 'pasien',
                'status_akun' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
```

---

### 5.2 PasienSeeder

```php
<?php
// database/seeders/PasienSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        // id_user pasien dimulai dari 6 (index berdasarkan UserSeeder)
        $pasienUsers = DB::table('tb_user')->where('role', 'pasien')->get();

        foreach ($pasienUsers as $index => $user) {
            DB::table('tb_pasien')->insert([
                'id_user' => $user->id_user,
                'umur' => [23, 27, 21, 25, 30][$index] ?? 22,
                'tanggal_daftar' => now()->subDays(rand(1, 90))->toDateString(),
                'alamat' => ['Surabaya', 'Malang', 'Jember', 'Banyuwangi', 'Sidoarjo'][$index] ?? 'Jakarta',
                'status_pasien' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
```

---

### 5.3 AdminSeeder

```php
<?php
// database/seeders/AdminSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminUsers = DB::table('tb_user')->where('role', 'admin')->get();
        $superAdmin = $adminUsers->first();

        foreach ($adminUsers as $user) {
            DB::table('tb_admin')->insert([
                'id_user' => $user->id_user,
                'dibuat_oleh' => $superAdmin->id_user,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
```

---

### 5.4 PsikologSeeder

```php
<?php
// database/seeders/PsikologSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PsikologSeeder extends Seeder
{
    public function run(): void
    {
        $psikologUsers = DB::table('tb_user')->where('role', 'psikolog')->get();
        $adminId = DB::table('tb_admin')->first()->id_admin;

        $data = [
            [
                'spesialisasi' => 'Psikologi Klinis',
                'nomor_sipa' => 'SIPA-2019-001234',
                'pendidikan' => 'S2 Psikologi Klinis - Universitas Indonesia',
                'pengalaman' => 6,
                'bio' => 'Spesialis dalam penanganan depresi, kecemasan, dan gangguan mood. Berpengalaman lebih dari 6 tahun dalam konseling dan psikoterapi.',
            ],
            [
                'spesialisasi' => 'Psikologi Anak & Remaja',
                'nomor_sipa' => 'SIPA-2018-005678',
                'pendidikan' => 'S2 Psikologi Perkembangan - Universitas Gadjah Mada',
                'pengalaman' => 7,
                'bio' => 'Berfokus pada penanganan masalah psikologis anak dan remaja, termasuk ADHD, autism spectrum, dan gangguan belajar.',
            ],
            [
                'spesialisasi' => 'Psikologi Keluarga',
                'nomor_sipa' => 'SIPA-2020-009012',
                'pendidikan' => 'S2 Psikologi Keluarga - Universitas Airlangga',
                'pengalaman' => 5,
                'bio' => 'Ahli dalam konseling keluarga, pernikahan, dan dinamika hubungan interpersonal.',
            ],
        ];

        foreach ($psikologUsers as $index => $user) {
            $d = $data[$index] ?? $data[0];
            DB::table('tb_psikolog')->insert([
                'id_user' => $user->id_user,
                'spesialisasi' => $d['spesialisasi'],
                'nomor_sipa' => $d['nomor_sipa'],
                'pendidikan' => $d['pendidikan'],
                'pengalaman' => $d['pengalaman'],
                'bio' => $d['bio'],
                'status_psikolog' => 'aktif',
                'dibuat_oleh' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
```

---

### 5.5 KategoriEdukasiSeeder

```php
<?php
// database/seeders/KategoriEdukasiSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriEdukasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Depresi', 'deskripsi' => 'Konten edukasi seputar depresi dan penanganannya'],
            ['nama_kategori' => 'Kecemasan', 'deskripsi' => 'Edukasi mengenai gangguan kecemasan dan cara mengatasinya'],
            ['nama_kategori' => 'Stres', 'deskripsi' => 'Informasi tentang manajemen stres dalam kehidupan sehari-hari'],
            ['nama_kategori' => 'Trauma & PTSD', 'deskripsi' => 'Edukasi seputar trauma psikologis dan pemulihan'],
            ['nama_kategori' => 'Kesehatan Mental Umum', 'deskripsi' => 'Artikel dan video umum tentang kesehatan mental'],
            ['nama_kategori' => 'Self-Care & Mindfulness', 'deskripsi' => 'Tips perawatan diri dan praktik mindfulness'],
        ];

        foreach ($kategori as $k) {
            DB::table('tb_kategori_edukasi')->insert([
                ...$k,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
```

---

### 5.6 KontenEdukasiSeeder

```php
<?php
// database/seeders/KontenEdukasiSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KontenEdukasiSeeder extends Seeder
{
    public function run(): void
    {
        $penulis = DB::table('tb_user')->where('role', 'admin')->first();
        $kategori = DB::table('tb_kategori_edukasi')->get()->pluck('id_kategori')->toArray();

        $konten = [
            // Artikel
            [
                'tipe_konten' => 'artikel',
                'judul_konten' => 'Mengenali Tanda-Tanda Depresi Sejak Dini',
                'id_kategori' => $kategori[0],
                'isi_artikel' => 'Depresi adalah gangguan suasana hati yang ditandai dengan perasaan sedih yang berkepanjangan, kehilangan minat pada aktivitas yang biasa dinikmati, dan berbagai gejala emosional serta fisik lainnya. Penting untuk mengenali tanda-tandanya sejak dini agar dapat segera mendapatkan pertolongan yang tepat...',
                'status' => 'publish',
            ],
            [
                'tipe_konten' => 'artikel',
                'judul_konten' => 'Cara Mengelola Kecemasan dalam Kehidupan Sehari-hari',
                'id_kategori' => $kategori[1],
                'isi_artikel' => 'Kecemasan adalah respons alami tubuh terhadap tekanan atau ancaman. Namun, jika tidak dikelola dengan baik, kecemasan dapat mengganggu aktivitas sehari-hari. Artikel ini akan membahas strategi efektif untuk mengelola kecemasan...',
                'status' => 'publish',
            ],
            [
                'tipe_konten' => 'artikel',
                'judul_konten' => '7 Teknik Relaksasi untuk Mengurangi Stres',
                'id_kategori' => $kategori[2],
                'isi_artikel' => 'Stres adalah bagian dari kehidupan, namun terlalu banyak stres dapat berdampak negatif pada kesehatan mental dan fisik. Berikut adalah 7 teknik relaksasi yang terbukti efektif untuk mengurangi stres...',
                'status' => 'publish',
            ],
            [
                'tipe_konten' => 'artikel',
                'judul_konten' => 'Memahami Trauma dan Proses Penyembuhan',
                'id_kategori' => $kategori[3],
                'isi_artikel' => 'Trauma adalah respons emosional terhadap peristiwa yang sangat menyakitkan atau mengancam jiwa. Setiap orang dapat mengalami trauma secara berbeda. Artikel ini membahas tentang apa itu trauma dan bagaimana proses penyembuhan dapat dilakukan...',
                'status' => 'draft',
            ],
            // Video
            [
                'tipe_konten' => 'video',
                'judul_konten' => 'Teknik Pernapasan untuk Mengatasi Kecemasan',
                'id_kategori' => $kategori[1],
                'url_video' => 'https://www.youtube.com/watch?v=example1',
                'durasi_video' => '08:30',
                'status' => 'publish',
            ],
            [
                'tipe_konten' => 'video',
                'judul_konten' => 'Meditasi Mindfulness untuk Pemula',
                'id_kategori' => $kategori[5],
                'url_video' => 'https://www.youtube.com/watch?v=example2',
                'durasi_video' => '15:45',
                'status' => 'publish',
            ],
            [
                'tipe_konten' => 'video',
                'judul_konten' => 'Mengenal Gejala Depresi dan Cara Mengatasinya',
                'id_kategori' => $kategori[0],
                'url_video' => 'https://www.youtube.com/watch?v=example3',
                'durasi_video' => '12:20',
                'status' => 'draft',
            ],
        ];

        foreach ($konten as $k) {
            DB::table('tb_konten_edukasi')->insert([
                'id_kategori' => $k['id_kategori'],
                'id_penulis' => $penulis->id_user,
                'tipe_konten' => $k['tipe_konten'],
                'judul_konten' => $k['judul_konten'],
                'slug' => Str::slug($k['judul_konten']),
                'isi_artikel' => $k['isi_artikel'] ?? null,
                'url_video' => $k['url_video'] ?? null,
                'durasi_video' => $k['durasi_video'] ?? null,
                'status' => $k['status'],
                'tanggal_publish' => $k['status'] === 'publish' ? now()->subDays(rand(1, 30)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
```

---

### 5.7 JenisSkriningSeeder

```php
<?php
// database/seeders/JenisSkriningSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSkriningSeeder extends Seeder
{
    public function run(): void
    {
        $admin = DB::table('tb_user')->where('role', 'admin')->first();

        DB::table('tb_jenis_skrining')->insert([
            [
                'nama_skrining' => 'PHQ-9 (Patient Health Questionnaire)',
                'jenis_penyakit' => 'Depresi',
                'deskripsi' => 'Kuesioner standar untuk mengukur tingkat keparahan depresi. Terdiri dari 9 pertanyaan berdasarkan kriteria DSM-IV.',
                'status' => 'publish',
                'jumlah_pertanyaan' => 9,
                'panduan_pengelolaan' => "Skor 0-4: Tidak ada depresi\nSkor 5-9: Depresi ringan\nSkor 10-14: Depresi sedang\nSkor 15-19: Depresi cukup parah\nSkor 20-27: Depresi berat\n\nRekomendasikan konsultasi psikolog untuk skor di atas 10.",
                'dibuat_oleh' => $admin->id_user,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_skrining' => 'GAD-7 (Generalized Anxiety Disorder)',
                'jenis_penyakit' => 'Kecemasan',
                'deskripsi' => 'Alat skrining standar untuk mendeteksi gangguan kecemasan umum. Menggunakan 7 pertanyaan berdasarkan kriteria DSM-IV.',
                'status' => 'publish',
                'jumlah_pertanyaan' => 7,
                'panduan_pengelolaan' => "Skor 0-4: Kecemasan minimal\nSkor 5-9: Kecemasan ringan\nSkor 10-14: Kecemasan sedang\nSkor 15-21: Kecemasan berat\n\nRekomendasikan konsultasi untuk skor di atas 10.",
                'dibuat_oleh' => $admin->id_user,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_skrining' => 'PSS-10 (Perceived Stress Scale)',
                'jenis_penyakit' => 'Stres',
                'deskripsi' => 'Skala untuk mengukur persepsi stres seseorang dalam sebulan terakhir. Terdiri dari 10 pertanyaan.',
                'status' => 'publish',
                'jumlah_pertanyaan' => 10,
                'panduan_pengelolaan' => "Skor 0-13: Stres rendah\nSkor 14-26: Stres sedang\nSkor 27-40: Stres tinggi\n\nRekomendasikan manajemen stres untuk skor di atas 14.",
                'dibuat_oleh' => $admin->id_user,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
```

---

### 5.8 PertanyaanSkriningSeeder

```php
<?php
// database/seeders/PertanyaanSkriningSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSkriningSeeder extends Seeder
{
    public function run(): void
    {
        $skriningList = DB::table('tb_jenis_skrining')->get();

        $pertanyaanPHQ9 = [
            'Kurang tertarik atau tidak merasa senang dalam melakukan hal apapun',
            'Merasa sedih, murung, atau putus asa',
            'Sulit tidur, mudah terbangun, atau terlalu banyak tidur',
            'Merasa lelah atau kurang bertenaga',
            'Kurang nafsu makan atau makan berlebihan',
            'Merasa buruk tentang diri sendiri, atau merasa bahwa anda adalah orang yang gagal',
            'Sulit berkonsentrasi pada sesuatu, seperti membaca koran atau menonton televisi',
            'Bergerak atau berbicara sangat lambat sehingga orang lain memperhatikan, atau sebaliknya, sangat gelisah sehingga anda bergerak lebih banyak dari biasanya',
            'Terpikir untuk menyakiti diri sendiri atau lebih baik jika anda mati',
        ];

        $pertanyaanGAD7 = [
            'Merasa gugup, cemas, atau sangat tegang',
            'Tidak mampu menghentikan atau mengendalikan rasa khawatir',
            'Terlalu khawatir tentang berbagai hal yang berbeda',
            'Kesulitan untuk bersantai',
            'Sangat gelisah sehingga sulit untuk duduk diam',
            'Mudah kesal atau mudah marah',
            'Merasa takut seolah-olah sesuatu yang mengerikan akan terjadi',
        ];

        $pertanyaanPSS = [
            'Seberapa sering anda kesal karena sesuatu terjadi secara tak terduga?',
            'Seberapa sering anda merasa tidak mampu mengendalikan hal-hal penting dalam hidup anda?',
            'Seberapa sering anda merasa gugup dan tertekan?',
            'Seberapa sering anda merasa yakin tentang kemampuan anda untuk menangani masalah pribadi anda?',
            'Seberapa sering anda merasa bahwa segala sesuatu berjalan sesuai keinginan anda?',
            'Seberapa sering anda merasa tidak bisa mengatasi semua hal yang harus anda lakukan?',
            'Seberapa sering anda mampu mengendalikan rasa jengkel dalam hidup anda?',
            'Seberapa sering anda merasa bahwa anda menguasai situasi?',
            'Seberapa sering anda marah karena hal-hal di luar kendali anda?',
            'Seberapa sering anda merasa kesulitan menumpuk begitu tinggi sehingga anda tidak bisa mengatasinya?',
        ];

        $allPertanyaan = [
            [$skriningList[0]->id_jenis_skrining, $pertanyaanPHQ9],
            [$skriningList[1]->id_jenis_skrining, $pertanyaanGAD7],
            [$skriningList[2]->id_jenis_skrining, $pertanyaanPSS],
        ];

        foreach ($allPertanyaan as [$idSkrining, $pertanyaanList]) {
            foreach ($pertanyaanList as $urutan => $pertanyaan) {
                DB::table('tb_pertanyaan_skrining')->insert([
                    'id_jenis_skrining' => $idSkrining,
                    'pertanyaan' => $pertanyaan,
                    'urutan' => $urutan + 1,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
```

---

### 5.9 JawabanSkriningSeeder

```php
<?php
// database/seeders/JawabanSkriningSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JawabanSkriningSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaan = DB::table('tb_pertanyaan_skrining')->get();

        // Jawaban standar PHQ-9 dan GAD-7
        $jawabanStandar = [
            ['teks_jawaban' => 'Tidak sama sekali', 'nilai_jawaban' => 0],
            ['teks_jawaban' => 'Beberapa hari', 'nilai_jawaban' => 1],
            ['teks_jawaban' => 'Lebih dari separuh waktu', 'nilai_jawaban' => 2],
            ['teks_jawaban' => 'Hampir setiap hari', 'nilai_jawaban' => 3],
        ];

        // Jawaban PSS (frekuensi)
        $jawabanPSS = [
            ['teks_jawaban' => 'Tidak pernah', 'nilai_jawaban' => 0],
            ['teks_jawaban' => 'Hampir tidak pernah', 'nilai_jawaban' => 1],
            ['teks_jawaban' => 'Kadang-kadang', 'nilai_jawaban' => 2],
            ['teks_jawaban' => 'Cukup sering', 'nilai_jawaban' => 3],
            ['teks_jawaban' => 'Sangat sering', 'nilai_jawaban' => 4],
        ];

        foreach ($pertanyaan as $p) {
            $skrining = DB::table('tb_jenis_skrining')
                ->where('id_jenis_skrining', $p->id_jenis_skrining)
                ->first();

            $jawabanList = str_contains($skrining->nama_skrining, 'PSS')
                ? $jawabanPSS
                : $jawabanStandar;

            foreach ($jawabanList as $urutan => $jawaban) {
                DB::table('tb_jawaban_skrining')->insert([
                    'id_pertanyaan' => $p->id_pertanyaan,
                    'teks_jawaban' => $jawaban['teks_jawaban'],
                    'nilai_jawaban' => $jawaban['nilai_jawaban'],
                    'urutan' => $urutan + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
```

---

### 5.10 PertanyaanPemantauanSeeder

```php
<?php
// database/seeders/PertanyaanPemantauanSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanPemantauanSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaan = [
            'Apakah kamu merasa sedih hari ini?',
            'Apakah kamu merasa cemas atau khawatir?',
            'Apakah kamu merasa tidak berharga atau putus asa?',
            'Apakah kamu pernah mendengar suara yang orang lain tidak dengar?',
        ];

        foreach ($pertanyaan as $urutan => $p) {
            DB::table('tb_pertanyaan_pemantauan')->insert([
                'pertanyaan' => $p,
                'urutan' => $urutan + 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
```

---

### 5.11 JadwalPsikologSeeder

```php
<?php
// database/seeders/JadwalPsikologSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPsikologSeeder extends Seeder
{
    public function run(): void
    {
        $psikologList = DB::table('tb_psikolog')->get();
        $slots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:00', '11:00'],
            ['13:00', '14:00'],
            ['14:00', '15:00'],
            ['15:00', '16:00'],
        ];

        foreach ($psikologList as $psikolog) {
            for ($i = 0; $i <= 7; $i++) {
                $tanggal = now()->addDays($i)->toDateString();
                $dayOfWeek = now()->addDays($i)->dayOfWeek;

                // Skip Minggu
                if ($dayOfWeek === 0) continue;

                foreach ($slots as $slot) {
                    DB::table('tb_jadwal_psikolog')->insert([
                        'id_pasien' => $psikolog->id_psikolog,
                        'id_psikolog' => $psikolog->id_psikolog,
                        'tanggal' => $tanggal,
                        'jam_mulai' => $slot[0],
                        'jam_selesai' => $slot[1],
                        'status_jadwal' => 'tersedia',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
```

---

### 5.12 DatabaseSeeder (Main)

```php
<?php
// database/seeders/DatabaseSeeder.php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            PasienSeeder::class,
            PsikologSeeder::class,
            KategoriEdukasiSeeder::class,
            KontenEdukasiSeeder::class,
            JenisSkriningSeeder::class,
            PertanyaanSkriningSeeder::class,
            JawabanSkriningSeeder::class,
            PertanyaanPemantauanSeeder::class,
            JadwalPsikologSeeder::class,
        ]);
    }
}
```

---

## 6. ATURAN PENGEMBANGAN

### 6.1 Konvensi Penamaan

| Komponen | Konvensi | Contoh |
|---|---|---|
| Controller | PascalCase + Controller | `AdminDashboardController` |
| Model | PascalCase (sesuai tabel) | `TbUser`, `TbPasien` |
| View | snake_case + subfolder role | `admin/dashboard.blade.php` |
| Route | kebab-case | `/admin/manajemen-psikolog` |
| Migration | timestamp + nama deskriptif | `2025_01_01_create_tb_user_table` |
| Seeder | PascalCase + Seeder | `UserSeeder` |

### 6.2 Middleware & Guard

```php
// Middleware per role
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () { ... });
Route::middleware(['auth', 'role:psikolog'])->prefix('psikolog')->group(function () { ... });
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () { ... });
```

### 6.3 Rules Validasi Penting

- **Email:** harus unik di `tb_user`
- **Nomor SIPA:** harus unik di `tb_psikolog`
- **Jadwal konsultasi:** satu slot waktu per psikolog hanya bisa digunakan satu sesi
- **Skrining:** pasien hanya bisa submit satu skrining per jenis per hari
- **Pemantauan:** satu catatan pemantauan per pasien per hari

### 6.4 Status Alur Konsultasi

```
permintaan_baru
    ↓ (psikolog setuju)
disetujui / terjadwal
    ↓ (sesi dimulai)
berlangsung
    ↓ (sesi selesai)
selesai / follow_up

permintaan_baru
    ↓ (psikolog tolak)
ditolak
```

### 6.5 Penghitungan Skor Pemantauan

- Setiap emoji jawaban memiliki nilai (0–3)
- Total skor dari semua pertanyaan → tentukan kondisi:
  - `0–3`: `baik`
  - `4–7`: `sedang`
  - `8+`: `parah`

### 6.6 Keamanan

- Semua password di-hash dengan `bcrypt`
- CSRF token wajib di setiap form
- Validasi input server-side untuk semua form
- File upload hanya izinkan: jpg, jpeg, png, pdf (max 2MB)
- Admin tidak bisa hapus akun sendiri
- Gunakan `policy` Laravel untuk otorisasi per resource

---

## 7. STRUKTUR FOLDER LARAVEL

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── PasienController.php
│   │   │   ├── PsikologController.php
│   │   │   ├── EdukasiController.php
│   │   │   ├── AdminController.php
│   │   │   ├── SkriningController.php
│   │   │   └── PertanyaanController.php
│   │   ├── Psikolog/
│   │   │   ├── DashboardController.php
│   │   │   ├── KonsultasiController.php
│   │   │   └── PemantauanController.php
│   │   └── Pasien/
│   │       ├── DashboardController.php
│   │       ├── SkriningController.php
│   │       ├── KonsultasiController.php
│   │       └── PemantauanController.php
│   └── Middleware/
│       └── CheckRole.php
├── Models/
│   ├── TbUser.php
│   ├── TbPasien.php
│   ├── TbAdmin.php
│   ├── TbPsikolog.php
│   └── ... (satu model per tabel)
resources/
└── views/
    ├── admin/
    ├── psikolog/
    ├── pasien/
    ├── auth/
    └── layouts/
database/
├── migrations/
└── seeders/
```

---

## 8. CATATAN PENTING

> ⚠️ **Jangan ubah tampilan UI** yang sudah ada. Rule ini hanya mengatur logika, database, dan alur fitur.

> 🔄 **Real-time chat** menggunakan Laravel Reverb atau Pusher untuk fitur `tb_chat_konsultasi`.

> 📊 **Grafik** menggunakan Chart.js atau ApexCharts di frontend.

> 🔒 **Setiap route** wajib dilindungi middleware sesuai role. Tidak ada akses lintas role kecuali disebut secara eksplisit.

> 📱 **Notifikasi** dikirim otomatis ke `tb_notifikasi` ketika:
> - Psikolog menyetujui/menolak permintaan konsultasi
> - Admin menambahkan konten edukasi baru
> - Pasien menyelesaikan skrining dengan skor tinggi
> - Psikolog memberikan follow-up

---

*Dokumen ini dibuat untuk panduan pengembangan sistem **Ruang Pulih** — harap selalu merujuk pada dokumen ini sebelum memulai implementasi fitur baru.*
