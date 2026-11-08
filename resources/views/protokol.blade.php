<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Protokol Keselamatan Premium
</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="{{ asset('assets/index.css') }}">
<link rel="stylesheet"
href="{{ asset('assets/protokol.css') }}">
    <style>
        .header {
            background: rgba(14, 165, 233, 0.95) !important;
        }
    </style>
</head>
<body>

@include('partials.header')

<div class="main-wrapper">

    <div class="header-section">

        <span class="badge">
            E-SAFETY PROTOCOL
        </span>

        <h1>
            Safe
            <span style="color:var(--aksen-kuning)">
                &
            </span>
            Eco
        </h1>

        <p>
            Standar Operasional Prosedur
            Keamanan Pengunjung
            Jagara Eco Park
        </p>

    </div>

    <div class="protocol-grid">

        <div class="protocol-card">

            <div class="icon-circle">
                <i class="fas fa-hand-sparkles"></i>
            </div>

            <h3>Higienitas</h3>

            <p>
                Gunakan station hand-sanitizer
                yang tersebar di seluruh area
                wahana sebelum berinteraksi.
            </p>

        </div>

        <div class="protocol-card">

            <div class="icon-circle">
                <i class="fas fa-wind"></i>
            </div>

            <h3>Area Hijau</h3>

            <p>
                Dilarang memetik bunga atau
                merusak ekosistem. 
                Biarkan alam tetap indah untuk dinikmati
            </p>

        </div>

        <div class="protocol-card">

            <div class="icon-circle">
                <i class="fas fa-shield-heart"></i>
            </div>

            <h3>P3K Siaga</h3>

            <p>
                Tim medis kami selalu siap siaga di posko utama
                untuk keadaan darurat
            </p>

        </div>

    </div>


    <div class="age-guide-section">

        <h2>
            Safety Management by Category
        </h2>

        <div class="age-container">

            <div class="age-premium-card">

                <div class="age-banner banner-child">

                    <i class="fas fa-baby"></i>

                    <span>Junior</span>

                </div>

                <div class="age-info">

                    <h3>
                        Junior Explorer
                        <small>0 - 12 Tahun</small>
                    </h3>

                    <ul>
                        <li>Wajib didampingi orang tua.</li>
                        <li>Gunakan gelang identitas yang telah di sediakan.</li>
                        <li>Dilarang masuk area yang berisiko.</li>
                        <li>Patuhi batas usia di setiap wahana.</li>
                    </ul>

                </div>

            </div>

            <div class="age-premium-card">

                <div class="age-banner banner-adult">

                    <i class="fas fa-running"></i>

                    <span>Active</span>

                </div>

                <div class="age-info">

                    <h3>
                        Active Visitors
                        <small>13 - 55 Tahun</small>
                    </h3>

                    <ul>
                        <li>Gunakan alat keselamatan yang telah disediakan.</li>
                        <li>Jaga kebersihan saat berada di area wahana.</li>
                        <li>Ikuti petunjuk petugas.</li>
                        <li>Merokok di perbolehkan di "Smoking Area" yang telah ditentukan.</li>
                    </ul>

                </div>

            </div>

            <div class="age-premium-card">

                <div class="age-banner banner-senior">

                    <i class="fas fa-spa"></i>

                    <span>Senior</span>

                </div>

                <div class="age-info">

                    <h3>
                        Silver Guest
                        <small>>55 Tahun</small>
                    </h3>

                    <ul>
                        <li>Akses prioritas fasilitas umum.</li>
                        <li>Tersedia jalur kursi roda.</li>
                        <li>Area relaksasi khusus.</li>
                        <li>Petugas siap membantu mobilisasi ke setiap fasilitas jika di perlukan.</li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

    <div class="btn-footer-protocol">
        <a href="{{ route('home') }}" class="btn-back-protocol">
            Kembali
        </a>
    </div>

</div>

</body>
</html>