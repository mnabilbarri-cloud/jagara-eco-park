<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Pendapatan - Jagara Eco Park</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <main class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title">Grafik Pendapatan Bulanan</h1>
                <p class="page-subtitle">Analisis pendapatan dari reservasi dalam 6 bulan terakhir</p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0; color: var(--slate-500); font-size: 13px; font-weight: 500;">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-chart-line" style="margin-right: 10px;"></i>
                    Pendapatan Bulanan (6 Bulan Terakhir)
                </h3>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- New Accounting Trends Table -->
        <div class="widget-card">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-chart-bar" style="margin-right: 10px;"></i>
                    Akumulasi Pendapatan & Analisis Tren Bisnis
                </h3>
            </div>
            <div class="quota-table-wrapper">
                <table class="quota-table">
                    <thead>
                        <tr>
                            <th>Periode Bulan</th>
                            <th>Total Reservasi Selesai</th>
                            <th>Akumulasi Pendapatan</th>
                            <th>Status Tren/Proyeksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyLabels as $index => $label)
                            <tr>
                                <td style="font-weight: 700; color: var(--slate-800);">{{ $label }}</td>
                                <td style="color: var(--slate-600);">{{ $monthlyCompletedReservations[$index] }} reservasi</td>
                                <td style="font-weight: 700; color: var(--primary);">Rp {{ number_format($monthlyRevenue[$index], 0, ',', '.') }}</td>
                                <td>
                                    @if ($monthlyTrends[$index] === 'up')
                                        <span class="badge badge-trend-up">
                                            <i class="fas fa-arrow-up" style="margin-right: 6px;"></i>
                                            Naik (Potensi Profit Meningkat)
                                        </span>
                                    @elseif($monthlyTrends[$index] === 'down')
                                        <span class="badge badge-trend-down">
                                            <i class="fas fa-arrow-down" style="margin-right: 6px;"></i>
                                            Turun (Evaluasi Strategi Pemasaran)
                                        </span>
                                    @else
                                        <span class="badge badge-trend-stable">
                                            <i class="fas fa-minus" style="margin-right: 6px;"></i>
                                            Stabil
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // This completely removes the confusing dot/legend from the top center
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Total Pendapatan: Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: 'rgba(243, 244, 246, 0.6)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

</body>
</html>
