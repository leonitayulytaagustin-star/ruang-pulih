<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nomor_telepon')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->enum('role', ['admin', 'psikolog', 'pasien', 'pengunjung'])->default('pengunjung');
            $table->string('foto_profil')->nullable();
            $table->enum('status_akun', ['aktif', 'nonaktif', 'pending'])->default('aktif');
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('tb_pasien', function (Blueprint $table) {
            $table->id('id_pasien');
            $table->unsignedBigInteger('id_user')->unique();
            $table->integer('umur')->nullable();
            $table->date('tanggal_daftar')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status_pasien', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
        });

        Schema::create('tb_admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->unsignedBigInteger('id_user')->unique();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
            $table->foreign('dibuat_oleh')->references('id_admin')->on('tb_admin')->nullOnDelete();
        });

        Schema::create('tb_psikolog', function (Blueprint $table) {
            $table->id('id_psikolog');
            $table->unsignedBigInteger('id_user')->unique();
            $table->string('spesialisasi')->nullable();
            $table->string('nomor_sipa')->unique();
            $table->string('pendidikan')->nullable();
            $table->integer('pengalaman')->nullable();
            $table->text('bio')->nullable();
            $table->enum('status_psikolog', ['aktif', 'nonaktif'])->default('aktif');
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
            $table->foreign('dibuat_oleh')->references('id_admin')->on('tb_admin')->nullOnDelete();
        });

        Schema::create('tb_kategori_edukasi', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

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

        Schema::create('tb_jenis_skrining', function (Blueprint $table) {
            $table->id('id_jenis_skrining');
            $table->string('nama_skrining');
            $table->string('jenis_penyakit');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->enum('status', ['draft', 'publish'])->default('draft');
            $table->integer('jumlah_pertanyaan')->default(0);
            $table->text('panduan_pengelolaan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('id_user')->on('tb_user')->nullOnDelete();
        });

        Schema::create('tb_pertanyaan_skrining', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->unsignedBigInteger('id_jenis_skrining');
            $table->text('pertanyaan');
            $table->integer('urutan')->default(1);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_jenis_skrining')->references('id_jenis_skrining')->on('tb_jenis_skrining')->onDelete('cascade');
        });

        Schema::create('tb_jawaban_skrining', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->string('teks_jawaban');
            $table->integer('nilai_jawaban')->default(0);
            $table->integer('urutan')->default(1);
            $table->timestamps();

            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('tb_pertanyaan_skrining')->onDelete('cascade');
        });

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

        Schema::create('tb_hasil_skrining', function (Blueprint $table) {
            $table->id('id_hasil_skrining');
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_jenis_skrining');
            $table->integer('total_skor')->default(0);
            $table->string('kategori_hasil')->nullable();
            $table->text('keterangan_hasil')->nullable();
            $table->date('tanggal_skrining');
            $table->timestamps();

            $table->unique(['id_pasien', 'id_jenis_skrining', 'tanggal_skrining'], 'skrining_pasien_jenis_tanggal_unique');
            $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
            $table->foreign('id_jenis_skrining')->references('id_jenis_skrining')->on('tb_jenis_skrining');
        });

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

        Schema::create('tb_jadwal_psikolog', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_psikolog');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status_jadwal', ['tersedia', 'terpakai', 'libur'])->default('tersedia');
            $table->timestamps();

            $table->unique(['id_psikolog', 'tanggal', 'jam_mulai'], 'jadwal_psikolog_slot_unique');
            $table->foreign('id_psikolog')->references('id_psikolog')->on('tb_psikolog');
        });

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
                'permintaan_baru',
                'disetujui',
                'ditolak',
                'terjadwal',
                'berlangsung',
                'follow_up',
                'selesai',
            ])->default('permintaan_baru');
            $table->text('catatan_psikolog')->nullable();
            $table->timestamps();

            $table->foreign('id_pendaftaran_konsultasi')->references('id_pendaftaran_konsultasi')->on('tb_pendaftaran_konsultasi');
            $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
            $table->foreign('id_psikolog')->references('id_psikolog')->on('tb_psikolog');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('tb_jadwal_psikolog')->nullOnDelete();
        });

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

        Schema::create('tb_pemantauan_mental', function (Blueprint $table) {
            $table->id('id_pemantauan');
            $table->unsignedBigInteger('id_pasien');
            $table->date('tanggal_pemantauan');
            $table->integer('total_skor')->default(0);
            $table->enum('kondisi_mental', ['baik', 'sedang', 'parah'])->default('baik');
            $table->string('emoji_kondisi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['id_pasien', 'tanggal_pemantauan'], 'pemantauan_pasien_tanggal_unique');
            $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
        });

        Schema::create('tb_pertanyaan_pemantauan', function (Blueprint $table) {
            $table->id('id_pertanyaan_pemantauan');
            $table->text('pertanyaan');
            $table->integer('urutan')->default(1);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

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

        Schema::create('tb_ringkasan_pasien', function (Blueprint $table) {
            $table->id('id_ringkasan');
            $table->unsignedBigInteger('id_pasien')->unique();
            $table->string('kondisi_terakhir')->nullable();
            $table->integer('skor_terakhir')->default(0);
            $table->enum('perubahan', ['membaik', 'memburuk', 'stabil'])->default('stabil');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('rendah');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_update')->nullable();
            $table->timestamps();

            $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
        });

        Schema::create('tb_riwayat_aktivitas_pasien', function (Blueprint $table) {
            $table->id('id_aktivitas');
            $table->unsignedBigInteger('id_pasien');
            $table->enum('jenis_aktivitas', ['skrining', 'konsultasi', 'pemantauan_mental', 'membaca_artikel', 'menonton_video']);
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_aktivitas')->nullable();
            $table->timestamps();

            $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
        });

        Schema::create('tb_mood_harian', function (Blueprint $table) {
            $table->id('id_mood');
            $table->unsignedBigInteger('id_pasien');
            $table->string('mood')->nullable();
            $table->string('emoji_mood')->nullable();
            $table->text('catatan')->nullable();
            $table->date('tanggal_mood');
            $table->timestamps();

            $table->unique(['id_pasien', 'tanggal_mood'], 'mood_pasien_tanggal_unique');
            $table->foreign('id_pasien')->references('id_pasien')->on('tb_pasien');
        });

        Schema::create('tb_notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_user');
            $table->string('judul_notifikasi');
            $table->text('isi_notifikasi');
            $table->string('tipe_notifikasi')->nullable();
            $table->boolean('status_baca')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
        });

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

        Schema::create('tb_laporan_masalah', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('kategori');
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('status_laporan', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('set null');
        });

        Schema::create('tb_saran_masukan', function (Blueprint $table) {
            $table->id('id_saran');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->text('pesan');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_saran_masukan');
        Schema::dropIfExists('tb_laporan_masalah');
        Schema::dropIfExists('tb_log_aktivitas_admin');
        Schema::dropIfExists('tb_notifikasi');
        Schema::dropIfExists('tb_mood_harian');
        Schema::dropIfExists('tb_riwayat_aktivitas_pasien');
        Schema::dropIfExists('tb_ringkasan_pasien');
        Schema::dropIfExists('tb_jawaban_pemantauan');
        Schema::dropIfExists('tb_pertanyaan_pemantauan');
        Schema::dropIfExists('tb_pemantauan_mental');
        Schema::dropIfExists('tb_chat_konsultasi');
        Schema::dropIfExists('tb_konsultasi');
        Schema::dropIfExists('tb_jadwal_psikolog');
        Schema::dropIfExists('tb_pendaftaran_konsultasi');
        Schema::dropIfExists('tb_detail_hasil_skrining');
        Schema::dropIfExists('tb_hasil_skrining');
        Schema::dropIfExists('tb_pendaftaran_skrining');
        Schema::dropIfExists('tb_jawaban_skrining');
        Schema::dropIfExists('tb_pertanyaan_skrining');
        Schema::dropIfExists('tb_jenis_skrining');
        Schema::dropIfExists('tb_konten_edukasi');
        Schema::dropIfExists('tb_kategori_edukasi');
        Schema::dropIfExists('tb_psikolog');
        Schema::dropIfExists('tb_admin');
        Schema::dropIfExists('tb_pasien');
        Schema::dropIfExists('tb_user');
    }
};
