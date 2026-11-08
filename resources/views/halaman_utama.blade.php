<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jagara Eco Park | Official Website</title>

    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

@include('partials.header')

    <!-- HERO SECTION -->
    <section class="hero" id="beranda">
        <div class="hero-content">

            <h2 style="font-size:3.5rem;margin-bottom:10px;">
                Selamat Datang di Jagara Eco Park
            </h2>

            <p style="font-size:1.3rem;margin-bottom:10px;opacity:0.9;">
                Aplikasi Reservasi Wisata Berbasis Web
            </p>

            <div class="op-hours-badge">
                <i class="fas fa-clock"></i>
                <span>Operasional: 09.00 - 22.00</span>
            </div>

            <br>

            <a href="{{ route('reservasi.buat') }}"
               class="btn-reservasi-main">
               PESAN SEKARANG
            </a>

        </div>
    </section>

    <!-- FASILITAS -->
    <section class="fasilitas" id="fasilitas">

        <div class="fasilitas-content">

            <h2 style="
                color:#ffffff;
                text-align:center;
                margin-bottom:50px;
                font-size:2.5rem;
                text-transform:uppercase;
                text-shadow:2px 2px 8px rgba(0,0,0,0.8);
            ">
                Fasilitas & Wahana
            </h2>

            <div class="wahana-grid">

                @if(isset($fasilitas) && count($fasilitas) > 0)

                    @foreach($fasilitas as $f)

                    <a href="{{ route('fasilitas.show', $f->id_fasilitas) }}" style="text-decoration: none; display: block;">
                        <div class="card" style="cursor: pointer;">

                            <div class="img-box">
                                <img
                                    src="{{ asset('assets/images/' . ($f->gambar ?? 'default.jpg')) }}"
                                    alt="{{ $f->nama_fasilitas }}"
                                >
                            </div>

                            <h3 style="margin-top:20px;color:#00b4d8;">
                    {{ $f->nama_fasilitas }}
                </h3>

                            <p style="
                                padding:10px 15px;
                                font-size:0.95rem;
                                color:#555;
                            ">
                                {{ $f->keterangan }}
                            </p>

                            {{--
                            --}}

                        </div>
                    </a>

                    @endforeach

                @else

                    <p style="color:white;text-align:center;">
                        Data fasilitas belum tersedia.
                    </p>

                @endif

            </div>

        </div>

    </section>

<!-- INFORMASI KUNJUNGAN -->
<section class="info-kunjungan" id="informasi">

    <h2 style="
        color:#00b4d8;
        margin-bottom:40px;
        font-size:2rem;
        text-transform:uppercase;
        text-align:center;
    ">
        Informasi Kunjungan
    </h2>

    <div class="info-container">

        <!-- HARGA TIKET -->
        <a href="{{ route('daftar_harga') }}"
           class="info-link"
           style="text-decoration:none;color:inherit;display:block;">

            <div class="info-item">
                <i class="fas fa-ticket-alt"></i>

                <h3>Harga Tiket</h3>

                <p>
                    Mulai dari Rp 10.000 / orang
                    <br>
                    <small>*Klik untuk melihat daftar harga lengkap</small>
                </p>
            </div>

        </a>

        <!-- LOKASI -->
        <a href="{{ route('lokasi') }}"
           class="info-link"
           style="text-decoration:none;color:inherit;display:block;">

            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>

                <h3>Lokasi</h3>

                <p>
                    Kuningan, Jawa Barat
                    <br>
                    <small>*Klik untuk melihat lokasi wisata</small>
                </p>
            </div>

        </a>

        <!-- PROTOKOL -->
        <a href="{{ route('protokol') }}"
           class="info-link"
           style="text-decoration:none;color:inherit;display:block;">

            <div class="info-item">
                <i class="fas fa-info-circle"></i>

                <h3>Protokol</h3>

                <p>
                    Menjaga kebersihan area wisata
                    <br>
                    <small>*Klik untuk melihat aturan kunjungan</small>
                </p>
            </div>

        </a>

    </div>

</section>

    <!-- CTA -->
    <section class="cta">

        <h2>Siap Berkunjung Ke Jagara Eco Park?</h2>

        <p>
            Nikmati Wisata Alam & Wahana Bersama Keluarga
        </p>

        <div style="margin-top:10px;">
            <a href="{{ route('reservasi.buat') }}"
               class="btn-reservasi-main">
               MULAI RESERVASI
            </a>
        </div>

    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <p>
            © {{ date('Y') }}
            Jagara Eco Park.
            Seluruh Hak Cipta Dilindungi.
        </p>
    </footer>

    <script>
        window.onscroll = function () {
            var header = document.getElementById("mainHeader");

            if (window.pageYOffset > 50) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        };
    </script>

</body>
</html>