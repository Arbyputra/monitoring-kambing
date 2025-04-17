@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="fw-semibold text-dark mb-4">Dashboard</h1>

        {{-- Statistik Kambing --}}
        <div class="row g-3 mb-3">
            <div class="col-lg-4 col-md-6">
                <div class="card text-white bg-primary shadow-sm" style="min-height: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">Total Kambing</h6>
                        <h3 class="card-text">{{ $totalKambing }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card text-white bg-success shadow-sm" style="min-height: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">Rata-rata ADG</h6>
                        <h3 class="card-text">+{{ number_format($rataAdg, 2) }} kg/hari</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm bg-warning-subtle" style="min-height: 120px;">
                    <div class="card-body">
                        @if ($stagnan->count())
                            <h6 class="text-dark"><i class="bi bi-exclamation-triangle"></i> {{ $stagnan->count() }} Kambing
                                Stagnan</h6>
                            <small class="text-muted">Kode: {{ $stagnan->pluck('kode')->join(', ') }}</small>
                        @else
                            <h6 class="text-success">Semua kambing mengalami perubahan berat</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Distribusi dan Statistik --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm" style="min-height: 250px;">
                    <div class="card-header small">Distribusi Jenis Kelamin</div>
                    <div class="card-body">
                        <canvas id="genderChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm" style="min-height: 250px;">
                    <div class="card-header small">Distribusi Berat Terakhir</div>
                    <div class="card-body">
                        <canvas id="beratChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm" style="min-height: 250px;">
                    <div class="card-header small">Distribusi Status Vaksinasi</div>
                    <div class="card-body">
                        <canvas id="vaksinChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @if ($grafikKode && is_array($riwayatBerat) && count($riwayatBerat))
                <div class="col-md-6">
                    <div class="card shadow-sm" style="min-height: 250px;">
                        <div class="card-header small">Grafik Pertumbuhan Berat ({{ $grafikKode }})</div>
                        <div class="card-body">
                            <canvas id="growthChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-6">
                <div class="card shadow-sm" style="min-height: 250px;">
                    <div class="card-header small">Rata-rata Berat per Kelompok Umur</div>
                    <div class="card-body">
                        <canvas id="umurChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Jenis Kelamin
            new Chart(document.getElementById('genderChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($jenisKelamin->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($jenisKelamin->values()) !!},
                        backgroundColor: ['#4e73df', '#f6c23e'],
                    }]
                }
            });

            // Berat Terakhir
            new Chart(document.getElementById('beratChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($beratLabels) !!},
                    datasets: [{
                        label: 'Berat (kg)',
                        data: {!! json_encode($beratData) !!},
                        backgroundColor: '#36b9cc'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Status Vaksinasi
            new Chart(document.getElementById('vaksinChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Sudah Divaksin', 'Belum Divaksin'],
                    datasets: [{
                        data: [{{ $kambingDivaksin }}, {{ $kambingBelumDivaksin }}],
                        backgroundColor: ['#198754', '#dc3545']
                    }]
                }
            });

            // Pertumbuhan Berat
            @if ($grafikKode && is_array($riwayatBerat) && count($riwayatBerat))
                new Chart(document.getElementById('growthChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode(array_map(fn($i) => 'Minggu ' . ($i + 1), array_keys($riwayatBerat))) !!},
                        datasets: [{
                            label: 'Berat (kg)',
                            data: {!! json_encode($riwayatBerat) !!},
                            borderColor: '#fd7e14',
                            backgroundColor: 'rgba(253,126,20,0.3)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            @endif

            // Berat per Kelompok Umur
            new Chart(document.getElementById('umurChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($umurGroups)) !!},
                    datasets: [{
                        label: 'Rata-rata Berat (kg)',
                        data: {!! json_encode(array_values($umurGroups)) !!},
                        backgroundColor: ['#6610f2', '#6f42c1', '#e83e8c']
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
