<?php

namespace Database\Seeders;

use App\Models\HasilSkrining;
use App\Models\DetailHasilSkrining;
use App\Models\JawabanPemantauan;
use App\Models\JawabanSkrining;
use App\Models\JadwalPsikolog;
use App\Models\JenisSkrining;
use App\Models\KategoriEdukasi;
use App\Models\KontenEdukasi;
use App\Models\Konsultasi;
use App\Models\PendaftaranKonsultasi;
use App\Models\PemantauanMental;
use App\Models\PertanyaanPemantauan;
use App\Models\PertanyaanSkrining;
use App\Models\RingkasanPasien;
use App\Models\TbAdmin;
use App\Models\TbPasien;
use App\Models\TbPsikolog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::firstOrCreate([
            'email' => 'admin@ruangpulih.test',
        ], [
            'nama_lengkap' => 'Admin Ruang Pulih',
            'password' => Hash::make('password'),
            'nomor_telepon' => '081200000001',
            'jenis_kelamin' => 'perempuan',
            'role' => 'admin',
            'status_akun' => 'aktif',
        ]);

        $admin = TbAdmin::firstOrCreate([
            'id_user' => $adminUser->id_user,
        ]);

        $psikologData = [
            ['Siti Aisa Nur', 'siti.psikolog@ruangpulih.test', 'Kecemasan dan stres', 'SIPA-2026-001', 'S.Psi., M.Psi', 5],
            ['Christella E. S.Psi., M.Psi', 'christella@ruangpulih.test', 'Depresi dan trauma', 'SIPA-2026-002', 'S.Psi., M.Psi', 7],
            ['Annida Aulia', 'annida.psikolog@ruangpulih.test', 'Remaja dan keluarga', 'SIPA-2026-003', 'S.Psi., M.Psi', 4],
        ];

        $psikologs = collect($psikologData)->map(function ($data) use ($admin) {
            [$nama, $email, $spesialisasi, $sipa, $pendidikan, $pengalaman] = $data;

            $user = User::firstOrCreate([
                'email' => $email,
            ], [
                'nama_lengkap' => $nama,
                'password' => Hash::make('password'),
                'nomor_telepon' => '0812'.random_int(10000000, 99999999),
                'jenis_kelamin' => 'perempuan',
                'role' => 'psikolog',
                'status_akun' => 'aktif',
            ]);

            return TbPsikolog::firstOrCreate([
                'id_user' => $user->id_user,
            ], [
                'spesialisasi' => $spesialisasi,
                'nomor_sipa' => $sipa,
                'pendidikan' => $pendidikan,
                'pengalaman' => $pengalaman,
                'bio' => 'Berpengalaman membantu pasien memahami kondisi mental dan membangun strategi pemulihan yang realistis.',
                'status_psikolog' => 'aktif',
                'dibuat_oleh' => $admin->id_admin,
            ]);
        });

        $pasienData = [
            ['Leonita Yulyta Agustin', 'leonita@ruangpulih.test', 22, 'perempuan'],
            ['Annida Tri Aulia', 'annida@ruangpulih.test', 21, 'perempuan'],
            ['Kafi Khaula Yukisa Zailina', 'kafi@ruangpulih.test', 23, 'perempuan'],
            ['Siti Aisa Nur Apriliana', 'sitiaisa@ruangpulih.test', 22, 'perempuan'],
        ];

        $pasiens = collect($pasienData)->map(function ($data) {
            [$nama, $email, $umur, $gender] = $data;

            $user = User::firstOrCreate([
                'email' => $email,
            ], [
                'nama_lengkap' => $nama,
                'password' => Hash::make('password'),
                'nomor_telepon' => '0813'.random_int(10000000, 99999999),
                'jenis_kelamin' => $gender,
                'role' => 'pasien',
                'status_akun' => 'aktif',
            ]);

            return TbPasien::firstOrCreate([
                'id_user' => $user->id_user,
            ], [
                'umur' => $umur,
                'tanggal_daftar' => now()->subDays(random_int(3, 30))->toDateString(),
                'status_pasien' => 'aktif',
            ]);
        });

        $kategori = collect([
            ['Kesehatan Mental', 'Informasi umum kesehatan mental'],
            ['Tips Stres', 'Panduan mengelola stres'],
            ['Self Improvement', 'Pengembangan diri dan kebiasaan sehat'],
            ['Trauma', 'Edukasi trauma dan pemulihan'],
            ['Gaya Hidup', 'Kebiasaan harian pendukung kesehatan mental'],
        ])->map(fn ($item) => KategoriEdukasi::firstOrCreate([
            'nama_kategori' => $item[0],
        ], [
            'deskripsi' => $item[1],
            'status' => 'aktif',
        ]))->keyBy('nama_kategori');

        $konten = [
            ['artikel', '4 Manfaat Support System untuk Kesehatan Mental yang Perlu Diketahui', 'Kesehatan Mental', $this->isiArtikel('support-system'), null, null, 'publish'],
            ['artikel', 'Stres: Gejala, Penyebab, dan Cara Mengelolanya', 'Tips Stres', $this->isiArtikel('stres'), null, null, 'publish'],
            ['artikel', '7 Cara Mengatasi Overwhelmed agar Hidup Lebih Tenang', 'Self Improvement', $this->isiArtikel('overwhelmed'), null, null, 'publish'],
            ['artikel', 'Memahami Trauma dan Proses Penyembuhan', 'Trauma', $this->isiArtikel('trauma'), null, null, 'publish'],
            ['artikel', 'Mengenali Tanda Awal Kecemasan Berlebih', 'Kesehatan Mental', $this->isiArtikel('kecemasan'), null, null, 'publish'],
            ['artikel', 'Rutinitas Harian yang Mendukung Pemulihan Mental', 'Gaya Hidup', $this->isiArtikel('rutinitas'), null, null, 'publish'],
            ['artikel', 'Cara Berbicara dengan Teman yang Sedang Tertekan', 'Kesehatan Mental', $this->isiArtikel('mendukung-teman'), null, null, 'publish'],
            ['artikel', 'Membangun Batasan Sehat dalam Relasi', 'Self Improvement', $this->isiArtikel('batasan'), null, null, 'publish'],
            ['artikel', 'Tidur dan Pengaruhnya terhadap Kesehatan Mental', 'Gaya Hidup', $this->isiArtikel('tidur'), null, null, 'publish'],
            ['artikel', 'Kapan Perlu Mencari Bantuan Psikolog', 'Kesehatan Mental', $this->isiArtikel('bantuan-psikolog'), null, null, 'publish'],
            ['video', 'Teknik Pernapasan untuk Mengatasi Kecemasan', 'Tips Stres', null, 'https://youtu.be/0LqWXlBfBxE?si=BgaJ7UxrHzvmoyrO', '08:30', 'publish'],
            ['video', 'Meditasi Mindfulness untuk Pemula', 'Gaya Hidup', null, 'https://youtu.be/WTqhSiqch5k?si=cbSCcZK0YXsnl31R', '15:45', 'publish'],
        ];

        $videoAktif = collect($konten)
            ->where(0, 'video')
            ->map(fn ($item) => Str::slug($item[1]))
            ->all();

        KontenEdukasi::where('tipe_konten', 'video')
            ->whereNotIn('slug', $videoAktif)
            ->delete();

        foreach ($konten as [$tipe, $judul, $namaKategori, $isi, $url, $durasi, $status]) {
            KontenEdukasi::updateOrCreate([
                'slug' => Str::slug($judul),
            ], [
                'id_kategori' => $kategori[$namaKategori]->id_kategori,
                'id_penulis' => $adminUser->id_user,
                'tipe_konten' => $tipe,
                'judul_konten' => $judul,
                'isi_artikel' => $isi,
                'url_video' => $url,
                'durasi_video' => $durasi,
                'status' => $status,
                'tanggal_publish' => $status === 'publish' ? now()->subDays(random_int(1, 14)) : null,
            ]);
        }

        $jenisSkrining = [
            ['Anxiety disorders', 'Anxiety disorders', 'Skrining awal untuk mengenali gejala kecemasan berlebih, kekhawatiran sulit dikendalikan, dan gejala fisik yang menyertai kecemasan.', 10],
            ['Depresi', 'Depresi', 'Skrining awal untuk mengenali gejala depresi seperti suasana hati rendah, kehilangan minat, perubahan tidur, dan rasa tidak berharga.', 10],
            ['Skizofrenia', 'Skizofrenia', 'Skrining awal untuk mengenali gejala psikosis seperti halusinasi, kecurigaan berlebih, pikiran tidak teratur, dan penarikan sosial.', 10],
            ['BPD', 'BPD', 'Skrining awal untuk mengenali pola emosi intens, ketakutan ditinggalkan, relasi tidak stabil, dan perilaku impulsif.', 10],
            ['PTSD', 'PTSD', 'Skrining awal untuk mengenali gejala pascatrauma seperti ingatan mengganggu, menghindari pemicu, kewaspadaan tinggi, dan perubahan suasana hati.', 10],
            ['Bipolar', 'Bipolar', 'Skrining awal untuk mengenali perubahan suasana hati ekstrem, periode energi meningkat, impulsivitas, dan episode suasana hati rendah.', 10],
        ];

        $namaSkriningAktif = collect($jenisSkrining)->pluck(0)->all();
        $skriningLama = JenisSkrining::whereNotIn('nama_skrining', $namaSkriningAktif)->pluck('id_jenis_skrining');

        if ($skriningLama->isNotEmpty()) {
            $hasilLama = HasilSkrining::whereIn('id_jenis_skrining', $skriningLama)->pluck('id_hasil_skrining');
            DetailHasilSkrining::whereIn('id_hasil_skrining', $hasilLama)->delete();
            HasilSkrining::whereIn('id_hasil_skrining', $hasilLama)->delete();
            JenisSkrining::whereIn('id_jenis_skrining', $skriningLama)->delete();
        }

        foreach ($jenisSkrining as [$nama, $penyakit, $deskripsi, $jumlah]) {
            $jenis = JenisSkrining::updateOrCreate([
                'nama_skrining' => $nama,
            ], [
                'jenis_penyakit' => $penyakit,
                'deskripsi' => $deskripsi,
                'status' => 'publish',
                'jumlah_pertanyaan' => $jumlah,
                'panduan_pengelolaan' => "Skor rendah: pantau berkala\nSkor sedang: pertimbangkan konsultasi\nSkor tinggi: disarankan konsultasi psikolog",
                'dibuat_oleh' => $adminUser->id_user,
            ]);

            $hasilSkrining = HasilSkrining::where('id_jenis_skrining', $jenis->id_jenis_skrining)->pluck('id_hasil_skrining');
            DetailHasilSkrining::whereIn('id_hasil_skrining', $hasilSkrining)->delete();
            HasilSkrining::whereIn('id_hasil_skrining', $hasilSkrining)->delete();
            $jenis->pertanyaan()->delete();

            foreach ($this->pertanyaanUntuk($penyakit, $jumlah) as $index => $teks) {
                $pertanyaan = PertanyaanSkrining::create([
                    'id_jenis_skrining' => $jenis->id_jenis_skrining,
                    'pertanyaan' => $teks,
                    'urutan' => $index + 1,
                    'status' => 'aktif',
                ]);

                foreach ($this->jawabanStandar() as $answerIndex => [$label, $nilai]) {
                    JawabanSkrining::create([
                        'id_pertanyaan' => $pertanyaan->id_pertanyaan,
                        'teks_jawaban' => $label,
                        'nilai_jawaban' => $nilai,
                        'urutan' => $answerIndex + 1,
                    ]);
                }
            }
        }

        PertanyaanPemantauan::query()->update(['status' => 'nonaktif']);

        foreach ([
            'Apakah kamu merasa nyaman dengan dirimu sendiri?',
            'Apakah kamu merasa stres akhir-akhir ini?',
            'Apakah kamu sering mimpi buruk tentang kejadian tertentu?',
            'Apakah kamu takut ditinggalkan orang terdekat?',
            'Apakah emosimu sering naik turun dengan cepat?',
            'Apakah kamu merasa sulit membedakan kenyataan dan pikiran?',
            'Apakah kamu sering merasa cemas berlebihan?',
            'Apakah kamu merasa tidak berharga atau putus asa?',
        ] as $index => $teks) {
            PertanyaanPemantauan::updateOrCreate([
                'pertanyaan' => $teks,
            ], [
                'urutan' => $index + 1,
                'status' => 'aktif',
            ]);
        }

        $pasiens->each(fn (TbPasien $pasien) => $this->seedPemantauanPasien($pasien));

        $slots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:00', '11:00'],
            ['13:00', '14:00'],
            ['14:00', '15:00'],
        ];

        foreach ($psikologs as $psikolog) {
            for ($day = 0; $day <= 10; $day++) {
                $date = now()->addDays($day);

                if ($date->isSunday()) {
                    continue;
                }

                foreach ($slots as [$mulai, $selesai]) {
                    JadwalPsikolog::firstOrCreate([
                        'id_psikolog' => $psikolog->id_psikolog,
                        'tanggal' => $date->toDateString(),
                        'jam_mulai' => $mulai,
                    ], [
                        'jam_selesai' => $selesai,
                        'status_jadwal' => 'tersedia',
                    ]);
                }
            }
        }

        $samplePasien = $pasiens->first();
        $sitiPsikolog = TbPsikolog::whereHas('user', fn ($query) => $query->where('email', 'siti.psikolog@ruangpulih.test'))->first();

        if ($sitiPsikolog) {
            foreach ($pasiens as $index => $pasien) {
                $keluhan = [
                    'Merasa cemas dan sulit tidur beberapa hari terakhir.',
                    'Butuh pendampingan untuk mengelola stres kuliah dan relasi.',
                    'Mengalami tekanan emosional yang naik turun dan ingin konsultasi rutin.',
                    'Ingin memahami pola cemas dan membangun rutinitas pemulihan.',
                ][$index] ?? 'Membutuhkan konsultasi lanjutan untuk pemantauan kondisi mental.';

                $pendaftaran = PendaftaranKonsultasi::updateOrCreate([
                    'id_pasien' => $pasien->id_pasien,
                    'email' => $pasien->user->email,
                    'keluhan' => $keluhan,
                ], [
                    'nama_lengkap' => $pasien->user->nama_lengkap,
                    'umur' => $pasien->umur ?? 22,
                    'jenis_kelamin' => $pasien->user->jenis_kelamin ?? 'perempuan',
                    'tingkat_urgensi' => $index === 2 ? 'tinggi' : 'sedang',
                    'persetujuan_syarat' => true,
                    'status_pendaftaran' => 'disetujui',
                ]);

                $existingKonsultasi = Konsultasi::where('id_pendaftaran_konsultasi', $pendaftaran->id_pendaftaran_konsultasi)->first();
                $jadwal = $existingKonsultasi?->jadwal
                    ?? JadwalPsikolog::where('id_psikolog', $sitiPsikolog->id_psikolog)
                        ->where('status_jadwal', 'tersedia')
                        ->orderBy('tanggal')
                        ->orderBy('jam_mulai')
                        ->first();

                if (! $jadwal) {
                    continue;
                }

                Konsultasi::updateOrCreate([
                    'id_pendaftaran_konsultasi' => $pendaftaran->id_pendaftaran_konsultasi,
                ], [
                    'id_pasien' => $pasien->id_pasien,
                    'id_psikolog' => $sitiPsikolog->id_psikolog,
                    'id_jadwal' => $jadwal->id_jadwal,
                    'tanggal_konsultasi' => $jadwal->tanggal,
                    'waktu_mulai' => $jadwal->jam_mulai,
                    'waktu_selesai' => $jadwal->jam_selesai,
                    'status_konsultasi' => 'disetujui',
                ]);

                $jadwal->update(['status_jadwal' => 'terpakai']);
            }
        }

        foreach ($pasiens as $index => $pasien) {
            RingkasanPasien::firstOrCreate([
                'id_pasien' => $pasien->id_pasien,
            ], [
                'kondisi_terakhir' => ['Stres Ringan', 'Cemas Sedang', 'Cemas Tinggi'][$index] ?? 'Stabil',
                'skor_terakhir' => [32, 58, 72][$index] ?? 20,
                'perubahan' => $index === 0 ? 'membaik' : 'memburuk',
                'prioritas' => $index === 2 ? 'tinggi' : 'sedang',
                'keterangan' => 'Data contoh untuk pemantauan psikolog.',
                'tanggal_update' => now()->subDays($index)->toDateString(),
            ]);
        }

        $jenisPertama = JenisSkrining::first();
        if ($jenisPertama && $samplePasien) {
            HasilSkrining::firstOrCreate([
                'id_pasien' => $samplePasien->id_pasien,
                'id_jenis_skrining' => $jenisPertama->id_jenis_skrining,
                'tanggal_skrining' => today()->subDay()->toDateString(),
            ], [
                'total_skor' => 12,
                'kategori_hasil' => 'sedang',
                'keterangan_hasil' => 'Data contoh hasil skrining.',
            ]);
        }
    }

    private function seedPemantauanPasien(TbPasien $pasien): void
    {
        $pertanyaanIds = PertanyaanPemantauan::where('status', 'aktif')
            ->orderBy('urutan')
            ->pluck('id_pertanyaan_pemantauan')
            ->values();

        if ($pertanyaanIds->isEmpty()) {
            return;
        }

        $patterns = $this->polaPemantauanPasien($pasien->user?->email);

        foreach ($patterns as $index => $answers) {
            $date = today()->subDays(20 - $index)->toDateString();
            $total = array_sum($answers);
            [$kondisi, $emoji] = $this->kondisiPemantauan($total);

            $pemantauan = PemantauanMental::updateOrCreate([
                'id_pasien' => $pasien->id_pasien,
                'tanggal_pemantauan' => $date,
            ], [
                'total_skor' => $total,
                'kondisi_mental' => $kondisi,
                'emoji_kondisi' => $emoji,
                'keterangan' => 'Data pemantauan historis untuk tren kondisi mental.',
            ]);

            foreach ($pertanyaanIds as $answerIndex => $questionId) {
                JawabanPemantauan::updateOrCreate([
                    'id_pemantauan' => $pemantauan->id_pemantauan,
                    'id_pertanyaan_pemantauan' => $questionId,
                ], [
                    'emoji_jawaban' => ':)',
                    'nilai_jawaban' => $answers[$answerIndex] ?? 0,
                ]);
            }

            JawabanPemantauan::where('id_pemantauan', $pemantauan->id_pemantauan)
                ->whereNotIn('id_pertanyaan_pemantauan', $pertanyaanIds)
                ->delete();
        }

        $latestAnswers = $patterns[array_key_last($patterns)];
        $latestTotal = array_sum($latestAnswers);
        [$latestKondisi] = $this->kondisiPemantauan($latestTotal);

        RingkasanPasien::updateOrCreate([
            'id_pasien' => $pasien->id_pasien,
        ], [
            'kondisi_terakhir' => 'Pemantauan '.$latestKondisi,
            'skor_terakhir' => $latestTotal,
            'perubahan' => $latestKondisi === 'parah' ? 'memburuk' : ($latestKondisi === 'baik' ? 'membaik' : 'stabil'),
            'prioritas' => $latestKondisi === 'parah' ? 'tinggi' : ($latestKondisi === 'sedang' ? 'sedang' : 'rendah'),
            'keterangan' => 'Data pemantauan historis untuk tren kondisi mental.',
            'tanggal_update' => today()->toDateString(),
        ]);
    }

    private function polaPemantauanPasien(?string $email): array
    {
        $patterns = [
            'leonita@ruangpulih.test' => [
                [0, 1, 0, 0, 1, 0, 1, 0],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [1, 1, 1, 0, 1, 0, 1, 0],
                [1, 2, 1, 0, 1, 0, 1, 0],
                [1, 2, 1, 1, 1, 0, 1, 0],
                [1, 2, 1, 1, 1, 1, 1, 0],
                [2, 2, 1, 1, 1, 1, 1, 0],
                [2, 2, 1, 1, 2, 1, 1, 0],
                [2, 3, 2, 1, 2, 1, 1, 0],
                [2, 3, 2, 1, 2, 1, 2, 0],
                [2, 2, 1, 1, 2, 1, 1, 0],
                [1, 2, 1, 1, 1, 1, 1, 0],
                [1, 2, 1, 0, 1, 0, 1, 0],
                [1, 1, 1, 0, 1, 0, 1, 0],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [1, 2, 0, 0, 1, 0, 1, 0],
                [1, 2, 1, 0, 1, 0, 1, 0],
                [1, 2, 1, 1, 1, 0, 1, 0],
                [2, 2, 1, 1, 1, 0, 1, 0],
                [2, 2, 1, 1, 1, 1, 1, 0],
            ],
            'annida@ruangpulih.test' => [
                [1, 2, 1, 1, 2, 0, 2, 1],
                [1, 2, 1, 1, 1, 0, 2, 1],
                [1, 1, 1, 1, 1, 0, 2, 1],
                [1, 1, 1, 0, 1, 0, 1, 1],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 0, 0, 1, 0],
                [0, 1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 1, 0],
                [0, 1, 0, 0, 0, 0, 1, 0],
                [0, 1, 0, 0, 1, 0, 1, 0],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [1, 1, 1, 0, 1, 0, 1, 0],
                [1, 2, 1, 0, 1, 0, 1, 0],
                [1, 2, 1, 1, 1, 0, 1, 0],
                [1, 1, 1, 0, 1, 0, 1, 0],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 0, 0, 1, 0],
                [0, 1, 0, 0, 0, 0, 0, 0],
            ],
            'kafi@ruangpulih.test' => [
                [2, 3, 2, 2, 2, 1, 2, 1],
                [2, 3, 2, 2, 3, 1, 2, 1],
                [3, 3, 2, 2, 3, 1, 2, 1],
                [3, 3, 2, 3, 3, 1, 3, 1],
                [3, 3, 3, 3, 3, 2, 3, 1],
                [3, 3, 3, 3, 3, 2, 3, 2],
                [3, 2, 3, 3, 3, 2, 3, 2],
                [3, 2, 2, 3, 3, 2, 3, 2],
                [2, 2, 2, 2, 3, 2, 3, 2],
                [2, 2, 2, 2, 2, 2, 2, 2],
                [2, 2, 1, 2, 2, 1, 2, 1],
                [2, 2, 1, 1, 2, 1, 2, 1],
                [2, 1, 1, 1, 2, 1, 2, 1],
                [1, 1, 1, 1, 2, 1, 2, 1],
                [1, 1, 1, 1, 1, 1, 2, 1],
                [1, 1, 1, 1, 1, 0, 2, 1],
                [1, 1, 0, 1, 1, 0, 1, 1],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [1, 0, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 1, 0, 1, 0],
            ],
            'sitiaisa@ruangpulih.test' => [
                [1, 1, 0, 0, 1, 0, 1, 0],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [1, 2, 0, 0, 1, 0, 1, 0],
                [1, 2, 1, 0, 1, 0, 1, 0],
                [2, 2, 1, 0, 1, 0, 2, 0],
                [2, 2, 1, 1, 2, 0, 2, 0],
                [2, 3, 1, 1, 2, 1, 2, 0],
                [2, 3, 2, 1, 2, 1, 2, 1],
                [2, 2, 2, 1, 2, 1, 2, 1],
                [2, 2, 1, 1, 2, 1, 2, 0],
                [1, 2, 1, 1, 2, 0, 2, 0],
                [1, 2, 1, 0, 1, 0, 2, 0],
                [1, 1, 1, 0, 1, 0, 1, 0],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 0, 0, 1, 0],
                [1, 1, 0, 0, 1, 0, 1, 0],
                [1, 2, 0, 0, 1, 0, 1, 0],
                [1, 2, 1, 0, 1, 0, 1, 0],
                [1, 2, 1, 1, 1, 0, 1, 0],
            ],
        ];

        return $patterns[$email] ?? $patterns['leonita@ruangpulih.test'];
    }

    private function kondisiPemantauan(int $total): array
    {
        if ($total <= 3) {
            return ['baik', ':)'];
        }

        if ($total <= 7) {
            return ['sedang', ':|'];
        }

        return ['parah', ':('];
    }

    private function pertanyaanUntuk(string $penyakit, int $jumlah): array
    {
        $base = [
            'Depresi' => [
                'Kurang tertarik atau tidak merasa senang melakukan aktivitas yang biasanya disukai',
                'Merasa sedih, kosong, murung, atau putus asa',
                'Sulit tidur, sering terbangun, atau tidur terlalu banyak',
                'Merasa lelah, tidak bertenaga, atau sulit memulai aktivitas',
                'Nafsu makan berkurang atau meningkat secara jelas',
                'Merasa gagal, tidak berharga, atau terlalu menyalahkan diri sendiri',
                'Sulit berkonsentrasi saat belajar, bekerja, atau berbicara',
                'Bergerak atau berbicara lebih lambat dari biasanya, atau justru sangat gelisah',
                'Merasa masa depan tidak punya harapan',
                'Terpikir untuk menyakiti diri sendiri atau merasa lebih baik jika tidak ada',
            ],
            'Anxiety disorders' => [
                'Merasa gugup, cemas, atau sangat tegang tanpa alasan yang jelas',
                'Sulit menghentikan atau mengendalikan rasa khawatir',
                'Terlalu khawatir terhadap banyak hal dalam kehidupan sehari-hari',
                'Sulit merasa rileks walaupun sedang tidak menghadapi masalah besar',
                'Merasa gelisah sampai sulit duduk diam',
                'Mudah panik atau merasa akan kehilangan kendali',
                'Jantung berdebar, napas terasa pendek, atau tubuh gemetar saat cemas',
                'Menghindari situasi tertentu karena takut cemas atau panik muncul',
                'Mudah kesal, tegang, atau sensitif saat merasa khawatir',
                'Merasa takut seolah sesuatu yang buruk akan terjadi',
            ],
            'Skizofrenia' => [
                'Mendengar suara yang tidak didengar orang lain',
                'Melihat, mencium, atau merasakan sesuatu yang tidak dialami orang lain',
                'Merasa ada orang yang ingin mencelakai, mengawasi, atau mengikuti',
                'Merasa pikiran dikendalikan, disisipkan, atau dibaca oleh orang lain',
                'Sulit menyusun pikiran sehingga ucapan terasa meloncat-loncat',
                'Sulit membedakan pengalaman nyata dan tidak nyata',
                'Menarik diri dari keluarga, teman, atau aktivitas sosial',
                'Ekspresi emosi terasa datar atau sulit menunjukkan perasaan',
                'Sulit menjaga kebersihan diri, rutinitas, atau tanggung jawab harian',
                'Merasa sangat yakin pada sesuatu meski orang lain memberi bukti sebaliknya',
            ],
            'BPD' => [
                'Sangat takut ditinggalkan atau diabaikan oleh orang terdekat',
                'Hubungan dengan orang lain sering berubah dari sangat dekat menjadi sangat buruk',
                'Suasana hati berubah cepat dan terasa sangat intens',
                'Sulit mengendalikan marah atau sering merasa marah berlebihan',
                'Merasa kosong, hampa, atau tidak tahu siapa diri sendiri',
                'Melakukan hal impulsif yang berisiko saat emosi sedang kuat',
                'Pikiran untuk menyakiti diri sendiri muncul saat merasa tertekan',
                'Sulit menenangkan diri setelah konflik atau penolakan',
                'Merasa curiga atau tidak nyata saat sedang sangat stres',
                'Penilaian terhadap diri sendiri sering berubah drastis',
            ],
            'PTSD' => [
                'Ingatan tentang peristiwa traumatis muncul tiba-tiba dan mengganggu',
                'Mengalami mimpi buruk yang berkaitan dengan pengalaman traumatis',
                'Merasa seolah peristiwa traumatis terjadi kembali',
                'Menghindari tempat, orang, percakapan, atau aktivitas yang mengingatkan pada trauma',
                'Sulit mengingat bagian penting dari peristiwa traumatis',
                'Merasa bersalah, malu, takut, atau marah sejak peristiwa tersebut',
                'Kehilangan minat pada aktivitas atau merasa jauh dari orang lain',
                'Mudah terkejut, selalu waspada, atau merasa tidak aman',
                'Sulit tidur atau sulit berkonsentrasi setelah pengalaman traumatis',
                'Mudah tersulut emosi atau melakukan tindakan berisiko setelah trauma',
            ],
            'Bipolar' => [
                'Mengalami periode sangat berenergi atau sangat aktif lebih dari biasanya',
                'Merasa sangat percaya diri, hebat, atau mampu melakukan banyak hal sekaligus',
                'Tidur jauh lebih sedikit tetapi tetap merasa bertenaga',
                'Berbicara lebih cepat atau lebih banyak dari biasanya',
                'Pikiran terasa berlomba-lomba atau sulit dihentikan',
                'Mudah terdistraksi dan sulit menyelesaikan kegiatan',
                'Melakukan keputusan impulsif seperti belanja berlebihan atau mengambil risiko besar',
                'Mengalami periode suasana hati sangat rendah setelah masa energi tinggi',
                'Perubahan suasana hati mengganggu hubungan, pekerjaan, atau sekolah',
                'Orang sekitar pernah menilai perubahan energi atau suasana hati kamu tidak biasa',
            ],
        ];

        return array_slice($base[$penyakit] ?? $base['Depresi'], 0, $jumlah);
    }

    private function jawabanStandar(): array
    {
        return [
            ['Tidak pernah', 0],
            ['Jarang', 1],
            ['Kadang-kadang', 2],
            ['Sering', 3],
            ['Sangat sering', 4],
        ];
    }

    private function isiArtikel(string $key): string
    {
        $artikel = [
            'support-system' => <<<'TEXT'
Support system adalah jaringan orang yang dapat memberi dukungan emosional, bantuan praktis, dan sudut pandang yang lebih tenang ketika seseorang menghadapi tekanan. Dukungan ini bisa datang dari keluarga, teman, pasangan, komunitas, rekan kerja, guru, konselor, psikolog, atau tenaga kesehatan lain. Dalam konteks kesehatan mental, support system tidak hanya berarti orang yang selalu hadir secara fisik, tetapi juga orang yang mampu mendengarkan tanpa menghakimi, menghargai batasan, dan membantu seseorang mengambil keputusan yang lebih aman.

Manfaat pertama support system adalah membantu seseorang merasa tidak sendirian. Saat sedang cemas, sedih, atau kewalahan, pikiran sering membuat masalah terasa lebih besar dan sulit dihadapi. Percakapan yang aman dengan orang tepercaya dapat menurunkan intensitas emosi karena seseorang merasa didengar dan diterima. Perasaan diterima ini penting, terutama ketika seseorang sedang merasa gagal, malu, atau takut membebani orang lain.

Manfaat kedua adalah membantu mengenali tanda bahaya lebih awal. Orang terdekat sering menyadari perubahan yang tidak selalu disadari oleh diri sendiri, misalnya pola tidur yang kacau, menarik diri, mudah marah, kehilangan minat, atau ucapan yang mengarah pada keputusasaan. Dengan komunikasi yang sehat, support system dapat mengingatkan secara lembut dan mendorong langkah pertolongan sebelum kondisi semakin berat.

Manfaat ketiga adalah memberi bantuan praktis. Saat energi mental sedang rendah, hal sederhana seperti membuat janji konsultasi, menyiapkan makanan, menemani ke fasilitas kesehatan, atau membantu mengatur jadwal dapat sangat berarti. Bantuan praktis membuat beban terasa lebih ringan dan memberi ruang bagi seseorang untuk fokus pada pemulihan.

Manfaat keempat adalah menjaga konsistensi proses pemulihan. Pemulihan mental biasanya tidak berlangsung lurus. Ada hari baik dan hari sulit. Support system yang sehat dapat membantu seseorang tetap terhubung dengan rutinitas yang mendukung, seperti tidur cukup, minum obat sesuai arahan dokter, mengikuti sesi konseling, atau menjalankan latihan yang direkomendasikan. Namun support system juga perlu punya batasan. Mendukung orang lain bukan berarti mengambil alih seluruh masalahnya. Bantuan terbaik adalah hadir, mendengarkan, mengarahkan pada sumber profesional ketika dibutuhkan, dan tetap menjaga kesehatan diri sendiri.
TEXT,
            'stres' => <<<'TEXT'
Stres adalah respons tubuh dan pikiran ketika seseorang menghadapi tuntutan, tekanan, atau perubahan yang terasa melebihi kapasitas saat itu. Dalam kadar tertentu, stres dapat membantu seseorang lebih waspada dan termotivasi menyelesaikan tugas. Namun ketika stres berlangsung terlalu lama, terlalu sering, atau tidak diberi ruang pemulihan, tubuh dapat masuk ke kondisi tegang berkepanjangan yang mengganggu kesehatan fisik dan mental.

Gejala stres dapat muncul dalam berbagai bentuk. Secara fisik, seseorang mungkin mengalami sakit kepala, tegang pada leher dan bahu, gangguan pencernaan, jantung berdebar, kelelahan, atau sulit tidur. Secara emosional, stres bisa membuat seseorang mudah marah, cemas, sedih, gelisah, atau merasa tidak mampu menghadapi hari. Secara kognitif, stres dapat mengganggu konsentrasi, membuat pikiran terasa penuh, dan memicu kebiasaan memikirkan kemungkinan buruk secara berulang. Secara perilaku, seseorang bisa menjadi lebih sering menunda, menarik diri, makan berlebihan, kehilangan nafsu makan, atau menggunakan pelarian yang tidak sehat.

Penyebab stres berbeda pada setiap orang. Ada yang dipicu oleh pekerjaan, tugas sekolah, konflik keluarga, masalah keuangan, tuntutan sosial, penyakit, kehilangan, atau perubahan besar seperti pindah tempat tinggal. Stres juga bisa muncul karena pola hidup yang tidak seimbang, kurang tidur, kurang dukungan sosial, atau kebiasaan menuntut diri terlalu keras. Mengenali pemicu adalah langkah penting karena cara mengelola stres harus disesuaikan dengan sumber tekanannya.

Mengelola stres dimulai dari hal yang paling bisa dikendalikan. Buat daftar masalah yang sedang dihadapi, lalu pisahkan antara hal yang mendesak, penting, bisa ditunda, dan tidak bisa dikendalikan. Untuk hal yang bisa dikerjakan, pecah menjadi langkah kecil. Untuk hal yang tidak bisa dikendalikan, latihan menerima dan mengatur respons tubuh dapat membantu. Teknik napas perlahan, berjalan kaki, peregangan ringan, menulis jurnal, mengurangi paparan notifikasi, dan tidur teratur adalah langkah sederhana yang sering efektif jika dilakukan konsisten.

Stres perlu mendapat bantuan profesional jika berlangsung berminggu-minggu, mengganggu sekolah atau pekerjaan, memicu konflik serius, menyebabkan serangan panik, membuat seseorang tidak bisa tidur, atau disertai pikiran menyakiti diri sendiri. Bantuan psikolog atau tenaga kesehatan mental dapat membantu memetakan pola stres, membangun strategi koping, dan menentukan apakah ada kondisi lain yang perlu ditangani.
TEXT,
            'overwhelmed' => <<<'TEXT'
Overwhelmed adalah kondisi ketika pikiran dan tubuh terasa dibanjiri terlalu banyak tuntutan sekaligus. Seseorang mungkin tahu ada banyak hal yang harus dilakukan, tetapi justru sulit memulai karena semuanya terasa sama penting dan sama mendesak. Kondisi ini sering muncul saat pekerjaan menumpuk, tugas datang bersamaan, konflik personal belum selesai, atau seseorang terlalu lama memendam emosi tanpa jeda.

Saat overwhelmed, otak cenderung masuk ke mode bertahan. Akibatnya, kemampuan mengambil keputusan menurun, konsentrasi mudah pecah, dan tubuh terasa tegang. Banyak orang kemudian menyalahkan diri sendiri karena merasa lambat, malas, atau tidak produktif. Padahal yang terjadi sering kali bukan kurang niat, melainkan sistem tubuh sedang kelebihan beban. Memahami hal ini penting agar langkah pemulihan dimulai dengan sikap yang lebih realistis, bukan dengan kritik diri yang semakin menambah tekanan.

Cara pertama untuk mengatasinya adalah melakukan brain dump. Tuliskan semua hal yang memenuhi kepala tanpa perlu disusun rapi. Setelah itu, kelompokkan menjadi beberapa kategori: harus dikerjakan hari ini, bisa dikerjakan minggu ini, bisa didelegasikan, dan sebenarnya tidak perlu dilakukan. Proses menulis membantu memindahkan beban dari kepala ke media yang lebih konkret sehingga pikiran tidak terus mencoba mengingat semuanya sekaligus.

Cara kedua adalah memilih satu langkah paling kecil. Jangan mulai dari target besar seperti menyelesaikan semua tugas. Mulailah dari langkah yang bisa selesai dalam 5 sampai 15 menit, misalnya membuka dokumen, membalas satu pesan penting, merapikan meja, atau menyiapkan daftar prioritas. Langkah kecil memberi sinyal kepada otak bahwa situasi mulai bergerak dan tidak sepenuhnya buntu.

Cara ketiga adalah mengurangi input baru. Saat sedang overwhelmed, notifikasi, media sosial, percakapan yang tidak mendesak, dan multitasking dapat membuat beban mental semakin berat. Buat ruang fokus singkat dengan mematikan notifikasi, menutup tab yang tidak dipakai, atau memberi tahu orang lain bahwa kamu butuh waktu menyelesaikan sesuatu. Setelah itu, beri jeda pemulihan seperti menarik napas perlahan, minum air, berjalan sebentar, atau melakukan peregangan.

Overwhelmed tidak selalu hilang dalam satu hari. Yang penting adalah mengembalikan rasa kendali secara bertahap. Jika kondisi ini terus berulang, coba evaluasi pola hidup, batasan, dan beban tanggung jawab yang sedang dipikul. Bila overwhelmed membuat kamu sulit berfungsi, menangis terus, tidak bisa tidur, atau merasa putus asa, mencari bantuan profesional adalah langkah yang layak dan aman.
TEXT,
            'trauma' => <<<'TEXT'
Trauma dapat muncul setelah seseorang mengalami, menyaksikan, atau terpapar peristiwa yang terasa mengancam keselamatan fisik maupun emosional. Peristiwa itu bisa berupa kekerasan, kecelakaan, kehilangan mendadak, bencana, perundungan, pelecehan, konflik keluarga, atau pengalaman lain yang membuat seseorang merasa tidak berdaya. Tidak semua orang yang mengalami peristiwa berat akan mengalami trauma berkepanjangan, tetapi setiap respons terhadap trauma tetap perlu dihargai karena tubuh dan pikiran setiap orang memiliki kapasitas berbeda.

Dampak trauma tidak selalu langsung terlihat. Sebagian orang tampak baik-baik saja di luar, tetapi mengalami mimpi buruk, kilas balik, mudah terkejut, sulit percaya pada orang lain, atau menghindari tempat dan percakapan yang mengingatkan pada peristiwa tersebut. Ada juga yang merasa mati rasa, sulit merasakan emosi, atau justru mudah marah tanpa memahami pemicunya. Reaksi ini adalah cara tubuh mencoba melindungi diri dari rasa sakit yang belum sepenuhnya diproses.

Proses penyembuhan trauma dimulai dari rasa aman. Seseorang tidak perlu memaksa diri menceritakan semua detail pengalaman traumatis sebelum siap. Langkah awal bisa berupa membangun rutinitas dasar, mengenali pemicu, belajar menenangkan tubuh, dan mencari lingkungan yang tidak menghakimi. Teknik grounding dapat membantu ketika ingatan traumatis muncul, misalnya menyebutkan lima benda yang terlihat, merasakan kaki menyentuh lantai, atau mengatur napas sambil mengingat bahwa saat ini berada di tempat yang lebih aman.

Dukungan sosial sangat berpengaruh dalam pemulihan. Respons seperti "itu sudah lewat" atau "jangan dipikirkan lagi" sering tidak membantu karena trauma tidak bekerja sesederhana ingatan biasa. Yang lebih membantu adalah mendengarkan, mempercayai pengalaman korban, tidak memaksa, dan menanyakan bentuk dukungan yang dibutuhkan. Jika trauma terjadi karena kekerasan atau pelecehan, keamanan fisik dan akses pada bantuan profesional harus menjadi prioritas.

Bantuan psikolog atau psikiater dapat diperlukan ketika gejala trauma mengganggu tidur, relasi, pekerjaan, sekolah, atau membuat seseorang terus merasa tidak aman. Terapi dapat membantu memproses pengalaman traumatis secara bertahap, mengurangi gejala, dan membangun kembali rasa kendali. Penyembuhan trauma bukan berarti melupakan, melainkan mampu hidup dengan lebih aman tanpa terus dikendalikan oleh peristiwa tersebut.
TEXT,
            'kecemasan' => <<<'TEXT'
Kecemasan adalah respons alami ketika seseorang menghadapi ketidakpastian, ancaman, atau situasi yang dianggap penting. Dalam kadar wajar, kecemasan membantu kita bersiap, berhati-hati, dan membuat keputusan. Namun kecemasan perlu diperhatikan ketika muncul terlalu sering, terlalu kuat, sulit dikendalikan, atau membuat seseorang menghindari aktivitas yang sebenarnya penting.

Tanda awal kecemasan berlebih dapat muncul melalui pikiran, tubuh, emosi, dan perilaku. Dari sisi pikiran, seseorang mungkin terus membayangkan skenario buruk, sulit menghentikan kekhawatiran, atau merasa harus memastikan semuanya aman berkali-kali. Dari sisi tubuh, kecemasan dapat muncul sebagai jantung berdebar, napas pendek, keringat dingin, perut tidak nyaman, gemetar, otot tegang, atau rasa lemas. Secara perilaku, kecemasan sering membuat seseorang menunda, menghindar, mencari kepastian terus-menerus, atau sulit tidur.

Salah satu cara memahami kecemasan adalah mencatat pola. Tuliskan kapan kecemasan muncul, situasi apa yang memicunya, pikiran apa yang muncul, reaksi tubuh yang terasa, dan apa yang dilakukan setelahnya. Catatan ini membantu membedakan antara masalah nyata yang perlu diselesaikan dan kekhawatiran yang berulang tanpa solusi. Dari sana, seseorang bisa mulai memilih respons yang lebih sehat, misalnya mengatur napas, membuat rencana sederhana, atau membatasi perilaku mengecek berulang.

Mengurangi kecemasan tidak selalu berarti menghilangkan rasa takut sepenuhnya. Kadang tujuan yang lebih realistis adalah tetap melakukan langkah penting walaupun masih ada rasa cemas. Latihan bertahap menghadapi situasi yang dihindari dapat membantu, selama dilakukan dengan aman dan tidak dipaksakan terlalu cepat. Pola tidur, konsumsi kafein, aktivitas fisik, dan dukungan sosial juga berpengaruh pada intensitas kecemasan.

Kecemasan perlu mendapat bantuan profesional jika membuat seseorang sulit sekolah, bekerja, berinteraksi, tidur, atau menjalankan aktivitas harian. Bantuan juga penting jika kecemasan disertai serangan panik, pikiran obsesif, atau perasaan bahwa hidup semakin sempit karena terlalu banyak hal dihindari. Dengan penanganan yang tepat, kecemasan dapat dikelola dan seseorang bisa membangun kembali rasa aman dalam kehidupan sehari-hari.
TEXT,
            'rutinitas' => <<<'TEXT'
Rutinitas harian adalah salah satu fondasi penting dalam pemulihan mental. Saat kondisi emosional tidak stabil, rutinitas membantu memberi struktur sehingga seseorang tidak harus mengambil terlalu banyak keputusan dari nol. Rutinitas yang baik tidak harus padat atau sempurna. Justru rutinitas yang terlalu ambisius sering sulit dipertahankan dan membuat seseorang merasa gagal ketika tidak mampu menjalankannya.

Langkah pertama adalah memperkuat kebutuhan dasar: tidur, makan, kebersihan diri, gerak tubuh, dan koneksi sosial. Misalnya, bangun pada jam yang relatif sama, mandi, makan sesuatu yang cukup, minum air, dan keluar kamar untuk mendapat cahaya matahari. Hal sederhana seperti ini membantu tubuh menerima sinyal bahwa hari berjalan dengan aman dan teratur. Ketika tubuh lebih stabil, pikiran biasanya lebih mudah diajak bekerja sama.

Rutinitas juga dapat digunakan untuk memantau suasana hati. Menulis jurnal singkat setiap malam, memberi skor mood, atau mencatat pemicu emosi dapat membantu mengenali pola. Misalnya, seseorang mungkin menyadari bahwa kecemasan meningkat saat kurang tidur, terlalu lama membuka media sosial, atau menunda tugas tertentu. Dengan mengenali pola, perubahan kecil bisa dilakukan lebih tepat sasaran.

Selain rutinitas produktif, rutinitas pemulihan juga penting. Banyak orang hanya memasukkan pekerjaan, tugas, dan kewajiban ke dalam jadwal, tetapi lupa memasukkan istirahat. Padahal istirahat bukan hadiah setelah semua selesai; istirahat adalah kebutuhan agar tubuh dan pikiran dapat berfungsi. Jadwalkan waktu untuk aktivitas yang menenangkan, seperti berjalan ringan, membaca, mendengarkan musik, berdoa, meditasi, atau berbicara dengan orang yang dipercaya.

Jika sedang berada dalam kondisi mental yang berat, buat rutinitas versi minimum. Contohnya: bangun, minum air, mandi, makan, dan mengirim satu pesan kepada orang tepercaya. Versi minimum membantu menjaga keberlangsungan hidup sehari-hari tanpa menuntut performa tinggi. Seiring kondisi membaik, rutinitas bisa ditambah pelan-pelan. Pemulihan mental lebih sering dibangun dari konsistensi kecil daripada perubahan besar yang hanya bertahan sebentar.
TEXT,
            'mendukung-teman' => <<<'TEXT'
Ketika teman sedang tertekan, banyak orang ingin segera memberi solusi. Niat itu baik, tetapi respons yang terlalu cepat memberi nasihat kadang membuat teman merasa tidak benar-benar didengarkan. Hal pertama yang paling membantu adalah hadir dengan tenang. Dengarkan ceritanya, beri ruang untuk diam, dan tunjukkan bahwa kamu tidak sedang menghakimi atau terburu-buru memperbaiki semuanya.

Validasi emosi adalah bagian penting dari dukungan. Validasi bukan berarti menyetujui semua tindakan teman, melainkan mengakui bahwa perasaannya nyata dan berat baginya. Kalimat seperti "kedengarannya kamu capek sekali menghadapi ini" atau "wajar kalau kamu merasa kewalahan" sering lebih membantu daripada "jangan sedih" atau "kamu harus kuat". Ketika seseorang merasa dipahami, ia biasanya lebih mudah berpikir jernih tentang langkah berikutnya.

Setelah mendengarkan, tanyakan bantuan konkret yang ia butuhkan. Ada orang yang ingin ditemani, ada yang butuh dibantu menyusun pilihan, ada yang hanya ingin didengarkan tanpa solusi. Hindari membandingkan masalahnya dengan pengalaman orang lain, mengecilkan cerita, atau memaksa ia membuka detail yang belum siap diceritakan. Jika kamu tidak tahu harus berkata apa, jujur saja bahwa kamu peduli dan ingin memahami lebih baik.

Dalam situasi tertentu, dukungan teman perlu diarahkan pada bantuan profesional. Jika teman sering menyebut ingin menghilang, menyakiti diri sendiri, merasa tidak ada harapan, mengalami kekerasan, atau tidak mampu menjalankan aktivitas dasar, jangan menanggung situasi itu sendirian. Ajak ia menghubungi keluarga tepercaya, psikolog, layanan kampus atau kantor, fasilitas kesehatan, atau layanan darurat setempat. Tetap dampingi secara aman, tetapi pahami batas kapasitasmu.

Mendukung teman juga membutuhkan perawatan diri. Kamu boleh peduli tanpa harus tersedia sepanjang waktu. Tetapkan batasan yang jelas, cari dukungan untuk dirimu sendiri, dan jangan merasa gagal jika teman tetap membutuhkan bantuan yang lebih besar. Dukungan yang sehat adalah dukungan yang menjaga keselamatan teman sekaligus menjaga kesehatanmu.
TEXT,
            'batasan' => <<<'TEXT'
Batasan sehat adalah garis yang membantu seseorang menjaga keamanan, energi, waktu, dan nilai diri dalam hubungan. Banyak orang mengira batasan berarti bersikap dingin atau menjauh. Padahal batasan justru membuat hubungan lebih jelas karena setiap orang tahu apa yang bisa diterima, apa yang tidak, dan bagaimana saling menghormati kebutuhan masing-masing.

Contoh batasan dapat muncul dalam banyak bentuk. Batasan waktu berarti berani mengatakan tidak ketika jadwal sudah penuh. Batasan emosional berarti tidak mengambil tanggung jawab atas semua perasaan orang lain. Batasan fisik berarti menentukan sentuhan atau kedekatan seperti apa yang nyaman. Batasan digital berarti mengatur kapan membalas pesan atau membatasi akses orang lain terhadap kehidupan pribadi. Semua batasan ini sah selama disampaikan dengan jelas dan tidak digunakan untuk mengendalikan orang lain.

Membangun batasan dimulai dari mengenali rasa tidak nyaman. Perhatikan situasi yang membuat kamu sering merasa lelah, kesal, takut, atau kehilangan kendali. Rasa tidak nyaman bisa menjadi sinyal bahwa ada kebutuhan yang belum dihormati. Setelah mengenali kebutuhan itu, susun kalimat sederhana. Misalnya, "Aku belum bisa membahas ini malam ini", "Aku butuh waktu sendiri dulu", atau "Aku tidak nyaman jika dibentak".

Menetapkan batasan mungkin terasa bersalah, terutama bagi orang yang terbiasa menyenangkan semua orang. Namun rasa bersalah tidak selalu berarti keputusanmu salah. Kadang rasa bersalah muncul karena kamu sedang belajar pola baru. Batasan perlu konsisten agar orang lain memahami bahwa kebutuhanmu serius. Jika batasan terus dilanggar, kamu berhak mengambil jarak atau mencari bantuan, terutama dalam relasi yang manipulatif atau penuh kekerasan.

Batasan sehat juga berlaku untuk diri sendiri. Misalnya membatasi kerja berlebihan, membatasi media sosial, atau berhenti memaksa diri menyelesaikan semuanya saat tubuh sudah kelelahan. Dengan batasan, seseorang belajar bahwa dirinya layak dihormati. Relasi yang sehat tidak menuntut seseorang kehilangan diri sendiri agar tetap diterima.
TEXT,
            'tidur' => <<<'TEXT'
Tidur memiliki hubungan erat dengan kesehatan mental. Saat tidur, tubuh memperbaiki energi, otak mengolah informasi, dan sistem emosi mendapatkan kesempatan untuk kembali seimbang. Kurang tidur dapat membuat seseorang lebih mudah cemas, sedih, marah, impulsif, dan sulit berkonsentrasi. Sebaliknya, gangguan kesehatan mental juga dapat membuat tidur menjadi sulit, sehingga terbentuk siklus yang saling memperburuk.

Masalah tidur tidak selalu berupa tidak bisa tidur sama sekali. Ada orang yang sulit memulai tidur, sering terbangun, bangun terlalu pagi, tidur terlalu lama tetapi tetap lelah, atau merasa tidurnya tidak nyenyak. Pola ini perlu diperhatikan jika terjadi berulang dan memengaruhi aktivitas harian. Dalam beberapa kondisi, perubahan tidur juga dapat menjadi tanda awal gangguan mood, kecemasan, stres berat, atau episode energi yang meningkat secara tidak biasa.

Menjaga kualitas tidur dapat dimulai dari sleep hygiene. Buat jam tidur dan bangun yang relatif konsisten, kurangi layar menjelang tidur, batasi kafein pada sore atau malam hari, dan gunakan tempat tidur terutama untuk tidur. Jika pikiran terasa ramai, tuliskan kekhawatiran atau daftar tugas sebelum tidur agar otak tidak terus mencoba mengingatnya. Cahaya redup, suhu kamar yang nyaman, dan rutinitas menenangkan seperti membaca ringan atau latihan napas juga dapat membantu.

Namun tidak semua masalah tidur selesai dengan tips sederhana. Jika seseorang mengalami insomnia berkepanjangan, mimpi buruk berulang, serangan panik saat malam, atau perubahan tidur yang ekstrem, evaluasi lebih lanjut diperlukan. Tidur terlalu sedikit tetapi merasa sangat bertenaga selama beberapa hari, misalnya, bisa menjadi sinyal penting yang perlu dibicarakan dengan profesional.

Memperbaiki tidur bukan hanya soal menambah jam istirahat, tetapi juga membangun ritme hidup yang lebih stabil. Tidur yang cukup membuat emosi lebih mudah diatur, keputusan lebih jernih, dan tubuh lebih kuat menghadapi stres. Dalam pemulihan mental, tidur sering menjadi langkah dasar yang dampaknya luas.
TEXT,
            'bantuan-psikolog' => <<<'TEXT'
Mencari bantuan psikolog sering dianggap sebagai langkah terakhir ketika seseorang sudah benar-benar tidak sanggup. Padahal bantuan profesional dapat digunakan jauh lebih awal, sebelum masalah berkembang menjadi lebih berat. Psikolog dapat membantu seseorang memahami pola pikiran, emosi, perilaku, dan relasi yang membuat hidup terasa sulit. Ruang konsultasi juga memberi kesempatan untuk bercerita secara aman tanpa takut dihakimi.

Ada beberapa tanda bahwa seseorang sebaiknya mempertimbangkan bantuan psikolog. Misalnya suasana hati rendah berlangsung lama, kecemasan sulit dikendalikan, tidur terganggu, nafsu makan berubah drastis, motivasi menurun, mudah marah, sering menangis, menarik diri, atau merasa aktivitas harian menjadi terlalu berat. Bantuan juga penting ketika seseorang mengalami trauma, konflik relasi yang berulang, kehilangan, tekanan akademik atau pekerjaan, masalah identitas, atau kebiasaan menyakiti diri sendiri.

Dalam sesi psikolog, seseorang biasanya diajak memetakan masalah, mengenali pemicu, memahami respons tubuh dan pikiran, lalu menyusun strategi yang realistis. Psikolog tidak selalu memberi jawaban instan, tetapi membantu klien menemukan cara yang lebih sehat untuk menghadapi masalah. Proses ini bisa melibatkan latihan mengatur emosi, mengubah pola pikir yang tidak membantu, membangun keterampilan komunikasi, atau menyusun rencana keselamatan jika ada risiko menyakiti diri.

Penting untuk memahami perbedaan psikolog dan psikiater. Psikolog berfokus pada asesmen dan intervensi psikologis seperti konseling atau psikoterapi. Psikiater adalah dokter spesialis yang dapat memberikan diagnosis medis dan meresepkan obat bila diperlukan. Dalam beberapa kondisi, keduanya dapat bekerja bersama. Mendapat obat bukan berarti seseorang lemah; itu bisa menjadi bagian dari penanganan yang tepat jika gejala membutuhkan dukungan biologis.

Mencari bantuan adalah bentuk tanggung jawab terhadap diri sendiri. Jika sesi pertama terasa canggung, itu wajar. Hubungan terapeutik membutuhkan waktu. Yang penting adalah mencari tenaga profesional yang kompeten, merasa cukup aman untuk berbicara, dan berani menyampaikan jika ada pendekatan yang kurang cocok. Semakin cepat seseorang mendapat dukungan yang tepat, semakin besar peluang untuk memahami diri dan membangun pemulihan yang lebih stabil.
TEXT,
        ];

        return $artikel[$key] ?? '';
    }
}
