<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kuota Harian - Jagara Eco Park</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
    <style>
        .quota-table-wrapper { overflow-x: auto; }
        .quota-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .quota-table thead th { 
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #e2e8f0; padding: 16px 18px; text-align: center; font-weight: 700; font-size: 12px;
            text-transform: uppercase; letter-spacing: 0.7px; 
            border-right: 1px solid rgba(51, 65, 85, 0.5);
        }
        .quota-table thead th:last-child {
            border-right: none;
        }
        .quota-table thead th:first-child { border-radius: 16px 0 0 0; }
        .quota-table thead th:last-child { border-radius: 0 16px 0 0; }
        .quota-table tbody td { padding: 16px 18px; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; vertical-align: middle; background: white; color: #334155; font-size: 14px; white-space: nowrap; text-align: center; }
        .quota-table tbody td:last-child {
            border-right: none;
        }
        .quota-table tbody tr:hover td { background: #f8fafc; }
        .quota-table tbody tr:last-child td:first-child { border-radius: 0 0 0 16px; }
        .quota-table tbody tr:last-child td:last-child { border-radius: 0 0 16px 0; }
        .status-badge { 
            display: inline-block; padding: 8px 16px; border-radius: 100px; font-weight: 800;
            font-size: 12px; text-transform: uppercase; letter-spacing: 0.7px;
        }
        .status-tersedia { background: #d1fae5; color: #047857; }
        .status-hampir-penuh { background: #fef3c7; color: #d97706; }
        .status-penuh { background: #fee2e2; color: #991b1b; }
        .date-highlight { color: var(--primary); font-weight: 800; }
        .weekday { color: var(--slate-500); }
        .booked-high { color: #dc2626 !important; font-weight: 800 !important; }
    </style>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <main class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title">Kelola Kuota Harian</h1>
                <p class="page-subtitle">Pantau kapasitas dan ketersediaan fasilitas untuk 14 hari ke depan</p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0; color: var(--slate-500); font-size: 13px; font-weight: 500;">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        <div class="widget-card" style="padding:0;">
            <div class="quota-table-wrapper">
                <table class="quota-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Fasilitas</th>
                            <th style="text-align: center;">Terpakai</th>
                            <th style="text-align: center;">Kapasitas</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyQuotaData as $day)
                            @foreach($day['facilities'] as $index => $facility)
                                <tr>
                                    @if($index === 0)
                                        <td class="date-highlight" rowspan="{{ count($day['facilities']) }}">
                                            {{ $day['formatted_date'] }}
                                        </td>
                                        <td class="weekday" rowspan="{{ count($day['facilities']) }}">
                                            {{ $day['weekday'] }}
                                        </td>
                                    @endif
                                    <td style="font-weight:700;">{{ $facility['name'] }}</td>
                                    <td style="text-align: center; {{ $facility['is_full'] || $facility['is_almost_full'] ? 'color: #dc2626;' : '' }} font-weight:800;">
                                        {{ $facility['booked'] }}
                                    </td>
                                    <td style="text-align: center; color: var(--slate-500);">{{ $facility['capacity'] }}</td>
                                    <td style="text-align: center;">
                                        @if($facility['is_full'])
                                            <span class="status-badge status-penuh">Penuh</span>
                                        @elseif($facility['is_almost_full'])
                                            <span class="status-badge status-hampir-penuh">Hampir Penuh</span>
                                        @else
                                            <span class="status-badge status-tersedia">Tersedia {{ $facility['remaining'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

</body>
</html>
