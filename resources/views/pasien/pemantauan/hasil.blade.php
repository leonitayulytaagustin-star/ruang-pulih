@extends('layouts.dashboard', ['title' => 'Hasil Pemantauan'])

@section('content')
    <section
        class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden"
        style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
        <div style="position: relative; z-index: 2;">
            <h1 class="mb-2 fw-bold"><i class="fa-solid fa-clipboard-check me-2"></i> Hasil Pemantauan Hari Ini</h1>
            <p class="mb-0 opacity-75">Tercatat pada {{ $pemantauan->tanggal_pemantauan->format('d M Y') }}</p>
        </div>
        <div class="d-flex gap-2" style="position: relative; z-index: 2;">
            <a href="{{ route('pasien.pemantauan.riwayat') }}"
                class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold">
                <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat
            </a>
            <a href="{{ route('pasien.dashboard') }}"
                class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold">
                <i class="fa-solid fa-home me-1"></i> Beranda
            </a>
        </div>
    </section>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
                @php
                    $isParah = $pemantauan->kondisi_mental === 'parah';
                    $isSedang = $pemantauan->kondisi_mental === 'sedang';
                    $colorClass = $isParah ? 'danger' : ($isSedang ? 'warning' : 'success');
                    $iconClass = $isParah ? 'fa-face-frown' : ($isSedang ? 'fa-face-meh' : 'fa-face-smile');
                @endphp
                <div class="bg-{{ $colorClass }} bg-opacity-10 text-{{ $colorClass }} rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                    style="width: 60px; height: 60px;">
                    <i class="fa-solid {{ $iconClass }} fs-2"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block mb-1">Kondisi Mental</small>
                    <span
                        class="badge bg-{{ $colorClass }} bg-opacity-10 text-{{ $colorClass }} rounded-pill px-3 py-2 text-capitalize shadow-sm">
                        {{ $pemantauan->kondisi_mental }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                    style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-gauge-high fs-3"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block mb-1">Total Skor</small>
                    <h3 class="mb-0 fw-bold">{{ $pemantauan->total_skor }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div
                class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3 {{ $isParah ? 'bg-danger bg-opacity-10' : 'bg-success bg-opacity-10' }}">
                <div class="bg-white bg-opacity-50 text-{{ $isParah ? 'danger' : 'success' }} rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                    style="width: 60px; height: 60px;">
                    <i class="fa-solid {{ $isParah ? 'fa-user-doctor' : 'fa-clock' }} fs-3"></i>
                </div>
                <div class="flex-grow-1">
                    <small class="text-{{ $isParah ? 'danger' : 'success' }} fw-semibold d-block mb-2">Rekomendasi
                        Aksi</small>
                    @if ($isParah)
                        <a href="{{ route('pasien.konsultasi.index') }}"
                            class="btn btn-danger w-100 fw-bold shadow-sm rounded-pill text-decoration-none">
                            Konsultasi Psikolog <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    @else
                        <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm d-block text-center w-100 fs-6">
                            Terus pantau berkala
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Ringkasan Jawaban -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-list-check text-primary me-2"></i>
                    Ringkasan Jawaban Anda</h5>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="py-3 px-4" style="width: 5%">No</th>
                                <th class="py-3 px-4" style="width: 70%">Pertanyaan</th>
                                <th class="py-3 px-4 text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemantauan->jawaban as $jawaban)
                                <tr class="border-bottom">
                                    <td class="px-4 text-muted fw-semibold">{{ $loop->iteration }}</td>
                                    <td class="px-4 text-dark">{{ $jawaban->pertanyaan->pertanyaan }}</td>
                                    <td class="px-4 text-center fw-bold text-primary">{{ $jawaban->nilai_jawaban }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($pemantauan->keterangan)
                    <div class="mt-4 p-3 bg-light rounded-4 border-start border-primary border-4">
                        <h6 class="fw-bold text-dark mb-2">Catatan Tambahan Anda:</h6>
                        <p class="text-muted mb-0 small fst-italic">{{ $pemantauan->keterangan }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Grafik Perkembangan -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-chart-line text-primary me-2"></i> Grafik
                    Perkembangan</h5>
                <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                    <canvas id="monitoringChart"></canvas>
                </div>
                <div class="mt-4 p-3 bg-light rounded-4 small">
                    <p class="mb-0 text-muted fst-italic">
                        <i class="fa-solid fa-circle-info text-primary me-1"></i> Grafik ini menampilkan tren skor
                        pemantauan mental harian Anda. Semakin rendah skor, semakin baik kondisi mental yang dirasakan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tooltips initialization
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })

                // Chart.js implementation
                const ctx = document.getElementById('monitoringChart').getContext('2d');
                const data = @json($riwayat->map(fn($i) => ['date' => $i->tanggal_pemantauan->format('d/m'), 'score' => $i->total_skor]));

                const labels = data.map(item => item.date);
                const scores = data.map(item => item.score);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Skor Kondisi Mental',
                            data: scores,
                            borderColor: '#005c34',
                            backgroundColor: 'rgba(0, 92, 52, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#005c34',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: '#1e293b',
                                titleFont: {
                                    family: "'Plus Jakarta Sans', sans-serif",
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    family: "'Plus Jakarta Sans', sans-serif"
                                },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.parsed.y + ' pts';
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 15,
                                ticks: {
                                    stepSize: 3,
                                    font: {
                                        family: "'Plus Jakarta Sans', sans-serif",
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: '#f1f5f9'
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        family: "'Plus Jakarta Sans', sans-serif",
                                        size: 11
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
