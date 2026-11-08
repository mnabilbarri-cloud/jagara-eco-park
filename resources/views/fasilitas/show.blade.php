<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $fasilitas->nama_fasilitas }} - Jagara Eco Park</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <style>
        .header {
            background: linear-gradient(135deg, #00b4d8 0%, #0096c7 100%) !important;
        }
        .back-nav {
            margin-top: 80px;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            padding: 24px 0;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #facc15;
            color: #111827;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-decoration: none;
        }
        .btn-back:hover {
            background: #eab308;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }
        .btn-back:hover i {
            transform: translateX(-3px);
        }
        .btn-back i {
            transition: transform 0.3s ease;
        }
        .gallery-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            margin-bottom: 32px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        @media (min-width: 768px) {
            .gallery-container {
                grid-template-columns: 2fr 1fr;
            }
        }
        .gallery-main-wrapper {
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .gallery-main {
            height: 400px;
            width: 100%;
            object-fit: cover;
            transition: all 0.5s ease-in-out;
        }
        .gallery-main-wrapper:hover .gallery-main {
            transform: scale(1.05) rotate(1deg);
        }
        .gallery-side {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .gallery-side-wrapper {
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .gallery-side img {
            height: 192px;
            width: 100%;
            object-fit: cover;
            transition: all 0.5s ease-in-out;
        }
        .gallery-side-wrapper:hover img {
            transform: scale(1.05) rotate(-1deg);
        }
        .content-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            padding-bottom: 16px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }
        @media (min-width: 1024px) {
            .content-container {
                grid-template-columns: 2fr 1fr;
            }
        }
        .facility-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            letter-spacing: -0.025em;
            margin-bottom: 16px;
        }
        @media (min-width: 1024px) {
            .facility-title {
                font-size: 2.25rem;
            }
        }
        .facility-desc {
            font-size: 1.125rem;
            color: #4b5563;
            line-height: 1.75;
            margin-bottom: 24px;
            width: 100%;
            max-width: 100%;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            display: block;
            padding-right: 20px;
            box-sizing: border-box;
        }
        .features-card {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            padding: 24px;
            border-radius: 16px;
            border: 1px solid #bfdbfe;
        }
        .features-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .features-title i {
            color: #0284c7;
        }
        .features-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        @media (min-width: 768px) {
            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            background: #bfdbfe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .feature-icon i {
            color: #0284c7;
        }
        .feature-label {
            font-weight: 600;
            color: #1f2937;
        }
        .feature-value {
            color: #4b5563;
        }
        .reserve-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }
        .reserve-card:hover {
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }
        .reserve-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 12px;
        }
        .reserve-desc {
            color: #64748b;
            margin-bottom: 20px;
        }
        .order-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
        .order-detail-label {
            color: #64748b;
        }
        .order-detail-value {
            color: #1e293b;
            font-weight: 600;
        }
        .total-section {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }
        .total-label {
            color: #1e293b;
            font-weight: 700;
        }
        .total-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: #00b4d8;
        }
        .btn-reserve {
            width: 100%;
            display: block;
            background: linear-gradient(to right, #00b4d8, #0077b6);
            color: #ffffff;
            text-align: center;
            font-weight: 600;
            padding: 14px;
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }
        .btn-reserve:hover {
            background: linear-gradient(to right, #0096c7, #005f8f);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 180, 216, 0.4);
        }
        .btn-reserve i {
            margin-right: 8px;
        }
        /* New Section Styles */
        .sections-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            padding-top: 0;
            padding-bottom: 80px;
        }
        .section-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-title i {
            color: #0284c7;
        }
        /* Reviews Section */
        .reviews-section {
            margin-bottom: 48px;
            margin-top: 0;
        }
        .rating-summary {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 32px;
        }
        .rating-score {
            font-size: 3rem;
            font-weight: 800;
            color: #0369a1;
        }
        .rating-stars {
            color: #facc15;
            font-size: 1.5rem;
            letter-spacing: 4px;
        }
        .review-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 16px;
        }
        .review-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
        }
        .review-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }
        .review-info {
            flex: 1;
        }
        .review-name {
            font-weight: 700;
            color: #1f2937;
        }
        .review-date {
            font-size: 0.875rem;
            color: #6b7280;
        }
        .review-stars-small {
            color: #facc15;
        }
        .review-text {
            color: #4b5563;
            line-height: 1.6;
        }
        /* FAQ Section */
        .faq-section {
            margin-bottom: 48px;
        }
        .faq-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .faq-item {
            padding: 20px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .faq-item:last-child {
            border-bottom: none;
        }
        .faq-question {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .faq-question i {
            color: #0284c7;
        }
        .faq-answer {
            color: #4b5563;
            line-height: 1.6;
        }
        /* Related Recommendations */
        .related-section {
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 20px;
            width: 100%;
        }
        .related-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .related-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }
        .related-image {
            height: 180px;
            width: 100%;
            object-fit: cover;
        }
        .related-content {
            padding: 20px;
        }
        .related-name {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            font-size: 1.125rem;
        }
        .related-desc {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>

@include('partials.header')

<!-- Back Button Navigation -->
<section class="back-nav">
    <div class="max-w-7xl mx-auto px-6">
        <a href="{{ route('home') }}#fasilitas" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Fasilitas
        </a>
    </div>
</section>

<!-- Photo Gallery Grid -->
<section style="position: relative; overflow: hidden; padding: 32px 0 0 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; grid-template-rows: calc(240px - 8px) calc(240px - 8px); gap: 16px; width: 100%; height: auto; max-height: 480px; overflow: hidden; margin-bottom: 24px;">
            @php
                $img1 = 'assets/images/' . ($fasilitas->gambar ?? 'resto_1.jpeg');
                $img2 = 'assets/images/' . ($fasilitas->gambar2 ?? $fasilitas->gambar ?? 'resto_2.jpeg');
                $img3 = 'assets/images/' . ($fasilitas->gambar3 ?? $fasilitas->gambar ?? 'resto_3.jpeg');
            @endphp

            <!-- LEFT: Main Image (Spans 2 Rows) -->
            <div style="grid-row: span 2; width: 100%; height: 100%; border-radius: 12px; overflow: hidden;">
                <img src="{{ asset($img1) }}" alt="Image 1" style="width: 100%; height: 100%; object-fit: cover; display: block;">
            </div>
            
            <!-- RIGHT TOP: Gambar 2 -->
            <div style="width: 100%; height: calc(240px - 8px); border-radius: 12px; overflow: hidden;">
                <img src="{{ asset($img2) }}" alt="Image 2" style="width: 100%; height: 100%; object-fit: cover; display: block;">
            </div>

            <!-- RIGHT BOTTOM: Gambar 3 -->
            <div style="width: 100%; height: calc(240px - 8px); border-radius: 12px; overflow: hidden;">
                <img src="{{ asset($img3) }}" alt="Image 3" style="width: 100%; height: 100%; object-fit: cover; display: block;">
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section style="position: relative; padding: 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <!-- Facility Description Box -->
        <div style="width: 100%; background: #ffffff; border: 1px solid #e5e7eb; padding: 24px; border-radius: 12px; margin-top: 24px; clear: both; display: block;">
            <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 15px; color: #1f2937;">Informasi Lengkap Fasilitas</h3>
                <div style="font-size: 15px; line-height: 1.7; color: #4b5563; word-wrap: break-word;">
                    <!-- Title -->
                    <h1 class="facility-title">
                        {{ $fasilitas->nama_fasilitas }}
                    </h1>
                    
                    <!-- Description -->
                @if($fasilitas->nama_fasilitas === 'Mushola')
                    <p style="line-height: 1.6; margin-bottom: 16px; color: #4b5563; font-size: 1rem;">
                        Mushola yang nyaman dan bersih untuk kebutuhan ibadah Anda selama berkunjung di Jagara Eco Park.
                    </p>
                    <p style="line-height: 1.6; margin-bottom: 16px; color: #4b5563; font-size: 1rem;">
                        {{ $fasilitas->keterangan }}
                    </p>
                    <p style="line-height: 1.6; margin-bottom: 16px; color: #4b5563; font-size: 1rem;">
                        Fasilitas ini disediakan demi kenyamanan dan ketenangan beribadah pengunjung.
                    </p>
                @else
                    <p style="line-height: 1.6; margin-bottom: 16px; color: #4b5563; font-size: 1rem;">
                        Nikmati harmoni alam berpadu dengan kenyamanan fasilitas eksklusif kami yang dirancang khusus untuk petualangan keluarga Anda.
                    </p>
                    <p style="line-height: 1.6; margin-bottom: 16px; color: #4b5563; font-size: 1rem;">
                        {{ $fasilitas->keterangan }}
                    </p>
                    <p style="line-height: 1.6; margin-bottom: 16px; color: #4b5563; font-size: 1rem;">
                        Rasakan sensasi berbeda yang hanya bisa Anda temukan di Jagara Eco Park, tempat keindahan alam dan keseruan berpadu sempurna untuk menciptakan kenangan tak terlupakan bersama orang tersayang.
                    </p>
                @endif
            
            <!-- Features Grid -->
            <div class="features-card">
                <h3 class="features-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Lengkap
                </h3>
                <div class="features-grid">
                    @if($fasilitas->nama_fasilitas === 'Mushola')
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-hand-holding-water"></i>
                            </div>
                            <div>
                                <div class="feature-label">Tempat Wudhu</div>
                                <div class="feature-value">Pria & Wanita Terpisah</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-pray"></i>
                            </div>
                            <div>
                                <div class="feature-label">Perlengkapan Shalat</div>
                                <div class="feature-value">Mukena, Sarung, & Sajadah Tersedia</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div class="feature-label">Waktu Operasional</div>
                                <div class="feature-value">Terbuka 24 Jam / Setiap Waktu Shalat</div>
                            </div>
                        </div>
                    @else
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <div class="feature-label">Kapasitas Maksimal</div>
                                <div class="feature-value">{{ $fasilitas->kapasitas }} Pengunjung</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <div class="feature-label">Aksesibilitas</div>
                                <div class="feature-value">Ramah Keluarga</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div class="feature-label">Jam Operasional</div>
                                <div class="feature-value">09:00 - 22:00</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Live Availability Calendar -->
            @if($fasilitas->nama_fasilitas !== 'Mushola')
            <div class="mt-8" id="availability-section">
                <h3 class="features-title" style="margin-bottom: 16px;">
                    <i class="fas fa-calendar-check"></i>
                    Ketersediaan Tanggal Kunjungan
                </h3>
                
                <!-- Date Cards Container -->
                <div class="date-cards-container" id="dateCardsContainer">
                    <div class="date-cards-wrapper flex flex-col gap-3">
                        @foreach($availabilityData as $index => $availability)
                            @php
                                $capacity = $availability['capacity'];
                                $booked = $availability['booked'];
                                $percentBooked = ($capacity > 0) ? min(100, ($booked / $capacity) * 100) : 0;
                            @endphp
                            <div 
                                class="date-card cursor-pointer flex flex-row items-center justify-between p-4 rounded-xl border-2 transition-all duration-300 shadow-sm hover:shadow-lg"
                                data-date="{{ $availability['date'] }}"
                                data-index="{{ $index }}"
                                data-booked="{{ $booked }}"
                                data-capacity="{{ $capacity }}"
                                data-remaining="{{ $availability['remaining'] }}"
                                data-is-available="{{ $availability['is_available'] ? '1' : '0' }}"
                                onclick="selectDate('{{ $availability['date'] }}', {{ $index }})"
                                id="date-card-{{ $index }}"
                                style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 16px;"
                            >
                                <!-- Left Side: Full Date on ONE horizontal line -->
                                <span style="font-weight: 600; font-size: 15px; white-space: nowrap; color: #1f2937;">
                                    {{ \Carbon\Carbon::parse($availability['date'])->translatedFormat('D, d M Y') }}
                                </span>

                                <!-- Right Side: Status Badge and Progress -->
                                <div class="date-right flex flex-col items-end gap-2">
                                    <!-- Dynamic Badge -->
                                    <div class="availability-badge">
                                        @if($availability['is_available'])
                                            @if($availability['remaining'] > 20)
                                                <span class="px-3 py-1 rounded-full text-xs font-bold" style="background-color: #e0f2fe; color: #0369a1;">
                                                    {{ $availability['remaining'] }} Tersedia
                                                </span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-bold" style="background-color: #fff3cd; color: #856404;">
                                                    Sisa {{ $availability['remaining'] }}!
                                                </span>
                                            @endif
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-bold" style="background-color: #f8d7da; color: #721c24;">
                                                Penuh
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Progress Bar Inside Card -->
                                    <div class="w-32">
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div 
                                                class="h-full rounded-full transition-all duration-500"
                                                style="width: {{ $percentBooked }}%; background: linear-gradient(90deg, #00b4d8 0%, #0284c7 100%);"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            </div> <!-- Close font-size div -->
        </div> <!-- Close background div -->
    </div> <!-- Close max-width div -->
</section>

<!-- New Sections -->
<section class="sections-container">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 40px; width: 100%; align-items: start;">
        
        <!-- Left Column: Reviews & FAQ -->
        <div>
            <!-- Reviews Section -->
    <section class="reviews-section">
        <h2 class="section-title">
            <i class="fas fa-star"></i>
            Ulasan Pengunjung
        </h2>
        <div class="rating-summary">
            <div class="rating-score">{{ $reviewStats->total_reviews > 0 ? number_format($reviewStats->avg_rating, 1) : '0' }}</div>
            <div>
                <div class="rating-stars">★★★★★</div>
                <p style="color: #4b5563; font-size: 0.875rem;">
                    {{ $reviewStats->total_reviews > 0 ? 'Berdasarkan ' . $reviewStats->total_reviews . ' ulasan' : 'Belum ada ulasan' }}
                </p>
            </div>
        </div>

        <!-- STRICT FORM ACCESS CONTROL -->
        <div style="margin-bottom: 30px;">
            @if(Session::has('user_login'))
                @php
                    $completedReservasi = \DB::table('reservasi')
                        ->where('user_id', Session::get('user_id'))
                        ->where('id_fasilitas', $fasilitas->id_fasilitas)
                        ->where('status', 'Diterima')
                        ->first();
                @endphp

                @if($completedReservasi)
                    @php
                        $hasReviewed = \DB::table('testimoni')->where('id_reservasi', $completedReservasi->id_reservasi)->exists();
                    @endphp

                    @if(!$hasReviewed)
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 25px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                            <h3 style="margin-top: 0; font-size: 1.1rem; color: #0f172a; margin-bottom: 15px;">Bagaimana Kesan Anda?</h3>
                            <form action="{{ route('reservasi.testimoni.simpan', $completedReservasi->kode_reservasi) }}" method="POST">
                                @csrf
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Rating Bintang <span style="color: #ef4444;">*</span></label>
                                    <div style="display: flex; gap: 8px; flex-direction: row-reverse; justify-content: flex-end;">
                                        @for($s = 5; $s >= 1; $s--)
                                            <input type="radio" id="star_f_{{ $s }}" name="rating" value="{{ $s }}" style="display: none;" required>
                                            <label for="star_f_{{ $s }}" style="font-size: 24px; color: #d1d5db; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#f59e0b'" onmouseout="if(!document.getElementById('star_f_{{ $s }}').checked) this.style.color='#d1d5db'" onclick="highlightStarsF({{ $s }})"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Isi Komentar / Kesan <span style="color: #ef4444;">*</span></label>
                                    <textarea name="komentar" style="width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; resize: vertical; min-height: 80px; outline: none;" placeholder="Ceritakan keseruan Anda di sini..." required></textarea>
                                </div>
                                <button type="submit" style="background: linear-gradient(135deg, #00b4d8, #0096c7); color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer;">Kirim Ulasan</button>
                            </form>
                            <script>
                                function highlightStarsF(val) {
                                    for(let i=1; i<=5; i++) {
                                        document.querySelector('label[for="star_f_'+i+'"]').style.color = (i <= val) ? '#f59e0b' : '#d1d5db';
                                    }
                                }
                            </script>
                        </div>
                    @endif
                @else
                    <div style="background: #fffbeb; border: 1px solid #fef3c7; color: #92400e; padding: 15px; border-radius: 10px;">
                        Anda hanya dapat memberikan ulasan setelah melakukan reservasi dan berkunjung ke fasilitas ini.
                    </div>
                @endif
            @else
                <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 15px; border-radius: 10px;">
                    Silakan <a href="{{ route('user.login') }}" style="color: #b91c1c; font-weight: bold; text-decoration: underline;">Login</a> terlebih dahulu untuk memberikan ulasan.
                </div>
            @endif
        </div>

        @if($ulasanList->count() > 0)
            @foreach($ulasanList as $ulasan)
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">
                            {{ strtoupper(substr($ulasan->name, 0, 2)) }}
                        </div>
                        <div class="review-info">
                            <div class="review-name">{{ $ulasan->name }}</div>
                            <div class="review-date">{{ \Carbon\Carbon::parse($ulasan->created_at)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div class="review-stars-small">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $ulasan->rating)
                                    ★
                                @else
                                    <span style="color:#d1d5db;">★</span>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="review-text">
                        {{ $ulasan->komentar }}
                    </p>
                </div>
            @endforeach
        @else
            <div class="review-card" style="text-align: center; color: #6b7280; font-style: italic;">
                Belum ada ulasan untuk fasilitas ini. Jadilah yang pertama memberikan kesan!
            </div>
        @endif
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <h2 class="section-title">
            <i class="fas fa-question-circle"></i>
            Aturan & Ketentuan Wisata
        </h2>
        <div class="faq-card">
            @if($fasilitas->nama_fasilitas === 'Mushola')
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-check-circle"></i>
                        Menjaga Ketertiban & Kebersihan
                    </div>
                    <div class="faq-answer">
                        Mohon selalu menjaga kebersihan dan ketertiban di area mushola demi kenyamanan bersama.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-check-circle"></i>
                        Perlengkapan Ibadah Tersedia
                    </div>
                    <div class="faq-answer">
                        Mukena, sarung, dan sajadah tersedia dalam kondisi bersih untuk digunakan pengunjung.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-check-circle"></i>
                        Wudhu & Toilet Tersedia
                    </div>
                    <div class="faq-answer">
                        Fasilitas wudhu dan toilet bersih tersedia di dekat area mushola.
                    </div>
                </div>
            @else
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-check-circle"></i>
                        Persyaratan Usia
                    </div>
                    <div class="faq-answer">
                        Minimal usia 12 tahun untuk mengendarai wahana ini. Anak di bawah 12 tahun harus didampingi orang tua.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-check-circle"></i>
                        Perlengkapan Keselamatan
                    </div>
                    <div class="faq-answer">
                        Wajib menggunakan helm pengaman dan perlengkapan safety yang telah disediakan.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-check-circle"></i>
                        Kondisi Kesehatan
                    </div>
                    <div class="faq-answer">
                        Tidak disarankan untuk pengunjung dengan kondisi kesehatan tertentu (jantung, tekanan darah tinggi, dll).
                    </div>
                </div>
            @endif
        </div>
    </section>


        </div> <!-- Close Left Column -->

        <!-- Right Column: Booking Card -->
        <div>
            <div style="position: sticky; top: 30px; z-index: 50;">
                <div class="reserve-card">
                    @if($fasilitas->nama_fasilitas === 'Mushola')
                        <h3 class="reserve-title">
                            Fasilitas Umum & Ibadah
                        </h3>
                        <p class="reserve-desc">
                            Fasilitas ini disediakan gratis demi kenyamanan ibadah Anda di Jagara Eco Park.
                        </p>
                    @else
                        <h3 class="reserve-title">
                            Ringkasan Pesanan
                        </h3>
                        <p class="reserve-desc">
                            Hitung total harga sebelum reservasi!
                        </p>
                        
                        <!-- Hidden inputs for selected date -->
                        <input type="hidden" id="selected-date" value="">
                        
                        <!-- Facility Name -->
                        <div class="order-detail-row">
                            <span class="order-detail-label">Nama Fasilitas</span>
                            <span class="order-detail-value">{{ $fasilitas->nama_fasilitas }}</span>
                        </div>
                        
                        <!-- Ticket Quantity -->
                        <div class="mb-6">
                            <label class="block order-detail-label mb-3">
                                <i class="fas fa-ticket-alt mr-2" style="color: #00b4d8;"></i>
                                Jumlah Tiket
                            </label>
                            <div class="flex items-center gap-3">
                                <button type="button" id="decrease-tickets" class="w-10 h-10 rounded-full bg-sky-100 text-sky-700 font-bold text-xl hover:bg-sky-200 transition-all flex items-center justify-center">
                                    -
                                </button>
                                <input type="number" id="ticket-count" value="1" min="1" max="{{ $fasilitas->kapasitas }}" class="flex-1 text-center border-2 border-sky-200 rounded-xl py-2 font-semibold text-lg focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-100">
                                <button type="button" id="increase-tickets" class="w-10 h-10 rounded-full bg-sky-100 text-sky-700 font-bold text-xl hover:bg-sky-200 transition-all flex items-center justify-center">
                                    +
                                </button>
                            </div>
                        </div>
                        
                        <!-- Price per Ticket -->
                        <div class="order-detail-row">
                            <span class="order-detail-label">Harga per Tiket</span>
                            <span class="order-detail-value">Rp {{ number_format($fasilitas->harga, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Total Price Highlight -->
                        <div class="total-section">
                            <div class="flex justify-between items-center">
                                <span class="total-label">Total Pembayaran</span>
                                <span class="total-price" id="total-price">Rp {{ number_format($fasilitas->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <!-- CTA Button -->
                        <div class="mt-6">
                            <a id="reserve-btn" href="{{ route('reservasi.buat') }}?id_fasilitas={{ $fasilitas->id_fasilitas }}" class="btn-reserve">
                                <i class="fas fa-calendar-check"></i>
                                Lanjutkan Reservasi Tiket
                            </a>
                        </div>
                        
                        <!-- Terms & Conditions Toggle -->
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <button type="button" id="toggle-terms" class="flex items-center justify-between w-full text-left font-semibold text-slate-700 hover:text-sky-600 transition-all">
                                <span>
                                    <i class="fas fa-file-contract mr-2" style="color: #00b4d8;"></i>
                                    Syarat & Ketentuan Kunjungan
                                </span>
                                <i id="terms-icon" class="fas fa-chevron-down transition-transform"></i>
                            </button>
                            <div id="terms-content" class="mt-3 text-sm text-slate-600 leading-relaxed hidden">
                                <ul class="list-disc list-inside space-y-2">
                                    <li>Tiket tidak dapat di-refund atau diubah tanggal setelah pembelian.</li>
                                    <li>Datang sesuai jam operasional yang ditentukan (09:00 - 22:00).</li>
                                    <li>Patuhi protokol kesehatan dan kebersihan area wisata.</li>
                                    <li>Anak di bawah 12 tahun harus didampingi oleh orang tua.</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div> <!-- Close Right Column -->

    </div> <!-- Close Grid -->
</section>

<!-- Rekomendasi Seru - Full Width Section (Outside Two-Column Grid) -->
<div style="width: 100%; max-width: 1200px; margin: 50px auto 0 auto; padding: 0 15px; clear: both; display: block;">
    <h2 style="text-align: center; font-size: 26px; font-weight: bold; margin-bottom: 30px; color: #1f2937; width: 100%;">
        <i class="fas fa-thumbs-up" style="color: #0284c7;"></i>
        Rekomendasi Seru Lainnya Untuk Anda
    </h2>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; width: 100%;">
        @foreach($all_fasilitas as $related)
            @if($related->id_fasilitas != $fasilitas->id_fasilitas && $related->id_fasilitas != 9)
                <a href="{{ route('fasilitas.show', $related->id_fasilitas) }}" class="related-card" style="display: block; text-decoration: none;">
                    <img src="{{ asset('assets/images/' . $related->gambar) }}" alt="{{ $related->nama_fasilitas }}" style="width: 100%; height: 210px; object-fit: cover; border-radius: 12px 12px 0 0; display: block;">
                    <div class="related-content" style="padding: 16px 20px;">
                        <div class="related-name">{{ $related->nama_fasilitas }}</div>
                        <div class="related-desc">{{ $related->keterangan }}</div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <p>
        © {{ date('Y') }}
        Jagara Eco Park.
        Seluruh Hak Cipta Dilindungi.
    </p>
</footer>

<style>
    /* Custom CSS for Premium UI */
    .date-cards-container {
        max-width: 100%;
        width: 100%;
    }
    
    .date-card {
        width: 100%;
        max-width: 100%;
        height: auto;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border: 1px solid #00b4d8;
        border-radius: 8px;
        background-color: white;
        box-sizing: border-box;
    }

    .date-card:hover {
        border-color: #0284c7;
        background-color: #f0f9ff;
    }
    .date-card.active {
        border-color: #00b4d8;
        box-shadow: 0 4px 12px rgba(0, 180, 216, 0.2);
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
    }
    .date-card.active .date-number {
        color: #00b4d8;
    }
    .date-card.active .day-name {
        color: #0284c7;
    }
    .date-card.active .month-year {
        color: #0284c7;
    }
    .date-cards-wrapper {
        max-width: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    #availability-section {
        height: auto;
        min-height: fit-content;
        margin-bottom: 20px;
        padding-bottom: 0;
    }
</style>
<script>
    // Facility data
    const facilityPrice = {{ $fasilitas->harga }};
    const facilityId = {{ $fasilitas->id_fasilitas }};
    const facilityCapacity = {{ $fasilitas->kapasitas }};
    
    // DOM Elements
    const ticketCountInput = document.getElementById('ticket-count');
    const decreaseBtn = document.getElementById('decrease-tickets');
    const increaseBtn = document.getElementById('increase-tickets');
    const totalPriceEl = document.getElementById('total-price');
    const reserveBtn = document.getElementById('reserve-btn');
    const selectedDateInput = document.getElementById('selected-date');
    const toggleTermsBtn = document.getElementById('toggle-terms');
    const termsContent = document.getElementById('terms-content');
    const termsIcon = document.getElementById('terms-icon');
    const availabilityCards = document.querySelectorAll('.date-card');
    
    // Format number as Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    
    // Update total price and progress
    function updateTotalPrice() {
        const count = parseInt(ticketCountInput.value) || 1;
        const total = count * facilityPrice;
        totalPriceEl.textContent = formatRupiah(total);
        
        // Update reserve button link with ticket count and selected date
        let url = '{{ route("reservasi.buat") }}?id_fasilitas=' + facilityId + '&jumlah_tiket=' + count;
        if (selectedDateInput.value) {
            url += '&tanggal_kunjungan=' + selectedDateInput.value;
        }
        reserveBtn.href = url;
    }
    
    // Ticket counter handlers
    decreaseBtn.addEventListener('click', () => {
        let current = parseInt(ticketCountInput.value);
        if (current > 1) {
            ticketCountInput.value = current - 1;
            updateTotalPrice();
        }
    });
    
    increaseBtn.addEventListener('click', () => {
        let current = parseInt(ticketCountInput.value);
        const max = parseInt(ticketCountInput.max);
        if (current < max) {
            ticketCountInput.value = current + 1;
            updateTotalPrice();
        }
    });
    
    ticketCountInput.addEventListener('input', () => {
        let val = parseInt(ticketCountInput.value);
        if (val < 1) ticketCountInput.value = 1;
        if (val > parseInt(ticketCountInput.max)) ticketCountInput.value = ticketCountInput.max;
        updateTotalPrice();
    });
    
    // Select date card
    function selectDate(dateStr, index) {
        // Update selected date input
        selectedDateInput.value = dateStr;
        
        // Remove active class from all cards
        availabilityCards.forEach(card => {
            card.classList.remove('active');
            card.style.borderColor = '#e0f2fe';
        });
        
        // Add active class to selected card
        const selectedCard = availabilityCards[index];
        selectedCard.classList.add('active');
        
        // Update total price (to refresh the reserve button link)
        updateTotalPrice();
    }
    
    // Select first date by default on load
    document.addEventListener('DOMContentLoaded', () => {
        if (availabilityCards.length > 0) {
            selectDate(availabilityCards[0].dataset.date, 0);
        }
    });
    
    // Terms toggle handler
    toggleTermsBtn.addEventListener('click', () => {
        termsContent.classList.toggle('hidden');
        termsIcon.classList.toggle('rotate-180');
    });
</script>

</body>
</html>