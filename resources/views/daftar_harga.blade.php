<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricelist Wahana - Jagara Eco Park</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/daftar_harga.css') }}">
    <style>
        .header {
            background: rgba(0, 180, 216, 0.95) !important;
        }
    </style>
</head>
<body>

@include('partials.header')

<header class="hero-header">

    <a href="{{ route('home') }}" class="btn-back-header">
        Kembali
    </a>

    <h1>Pricelist Wahana</h1>

    <p>
        Tarif keseruan dan fasilitas terbaik
        di Jagara Eco Park
    </p>

</header>

<main class="main-container">

    <div class="wahana-grid">

        @foreach($fasilitas as $f)

        @php
            $is_gratis =
            (($f->tipe ?? '') == 'umum')
            || ($f->harga == 0);
        @endphp

        <div class="card-wahana-master">

            <div class="card-img-box">

                @if($is_gratis)

                    <span class="tag-badge tag-gratis">
                        Fasilitas Umum
                    </span>

                @else

                    <span class="tag-badge tag-populer">
                        Terpopuler
                    </span>

                @endif

                <img
                src="{{ asset('assets/images/' . ($f->gambar ?? 'default.jpg')) }}"
                alt="{{ $f->nama_fasilitas }}">

            </div>

            <div class="card-content">

                <h3>
                    {{ $f->nama_fasilitas }}
                </h3>

                <p>
                    {{ $f->keterangan }}
                </p>

                <div class="card-footer">

                    <div class="price-box">

                        @if($is_gratis)

                            <span class="amount">
                                Gratis
                            </span>

                            <span class="label">
                                Akses Pengunjung
                            </span>

                        @else

                            <span class="amount">
                                Rp {{ number_format($f->harga,0,',','.') }}
                            </span>

                            <span class="label">
                                Per Tiket / Sesi
                            </span>

                        @endif

                    </div>

                    <div class="action-buttons">
                        @if(!$is_gratis)
                            <a href="{{ route('reservasi.buat') }}?id_fasilitas={{ $f->id_fasilitas }}" class="btn-reserve">
                                <i class="fas fa-ticket-alt"></i> Pesan Tiket
                            </a>
                        @endif
                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</main>

</body>
</html>