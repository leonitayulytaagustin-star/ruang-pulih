<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JawabanSkrining;
use App\Models\JenisSkrining;
use App\Models\PertanyaanSkrining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertanyaanController extends Controller
{
    public function edit(JenisSkrining $skrining)
    {
        $skrining->load('pertanyaan.jawaban');

        return view('admin.skrining.pertanyaan', compact('skrining'));
    }

    public function update(Request $request, JenisSkrining $skrining)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|array|min:1',
            'pertanyaan.*.id' => 'nullable|integer|exists:tb_pertanyaan_skrining,id_pertanyaan',
            'pertanyaan.*.teks' => 'required|string',
            'pertanyaan.*.jawaban' => 'required|array|min:2',
            'pertanyaan.*.jawaban.*.id' => 'nullable|integer|exists:tb_jawaban_skrining,id_jawaban',
            'pertanyaan.*.jawaban.*.teks' => 'required|string|max:255',
            'pertanyaan.*.jawaban.*.nilai' => 'required|integer|min:0|max:100',
        ]);

        DB::transaction(function () use ($validated, $skrining) {
            $keptQuestionIds = [];

            foreach ($validated['pertanyaan'] as $index => $data) {
                $pertanyaan = PertanyaanSkrining::updateOrCreate([
                    'id_pertanyaan' => $data['id'] ?? null,
                    'id_jenis_skrining' => $skrining->id_jenis_skrining,
                ], [
                    'pertanyaan' => $data['teks'],
                    'urutan' => $index + 1,
                    'status' => 'aktif',
                ]);

                $keptQuestionIds[] = $pertanyaan->id_pertanyaan;
                $keptAnswerIds = [];

                foreach ($data['jawaban'] as $answerIndex => $answerData) {
                    $jawaban = JawabanSkrining::updateOrCreate([
                        'id_jawaban' => $answerData['id'] ?? null,
                        'id_pertanyaan' => $pertanyaan->id_pertanyaan,
                    ], [
                        'teks_jawaban' => $answerData['teks'],
                        'nilai_jawaban' => $answerData['nilai'],
                        'urutan' => $answerIndex + 1,
                    ]);

                    $keptAnswerIds[] = $jawaban->id_jawaban;
                }

                JawabanSkrining::where('id_pertanyaan', $pertanyaan->id_pertanyaan)
                    ->whereNotIn('id_jawaban', $keptAnswerIds)
                    ->delete();
            }

            PertanyaanSkrining::where('id_jenis_skrining', $skrining->id_jenis_skrining)
                ->whereNotIn('id_pertanyaan', $keptQuestionIds)
                ->delete();

            $skrining->update(['jumlah_pertanyaan' => count($keptQuestionIds)]);
        });

        return back()->with('success', 'Pertanyaan skrining berhasil disimpan.');
    }
}
