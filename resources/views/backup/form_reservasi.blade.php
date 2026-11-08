<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Jagara Eco Park</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4>Form Reservasi Pengunjung</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('reservasi.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Nama Pengunjung
                    </label>

                    <input type="text"
                           name="nama_pengunjung"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Nomor HP
                    </label>

                    <input type="text"
                           name="no_hp"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Tanggal Kunjungan
                    </label>

                    <input type="date"
                           name="tanggal_kunjungan"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Pilih Fasilitas
                    </label>

                    <select name="id_fasilitas"
                            id="id_fasilitas"
                            class="form-control"
                            onchange="hitungTotal()">

                        @foreach($fasilitas as $f)

                            <option
                                value="{{ $f->id_fasilitas }}"
                                data-harga="{{ $f->harga }}">

                                {{ $f->nama_fasilitas }}
                                - Rp {{ number_format($f->harga) }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Jumlah Tiket
                    </label>

                    <input type="number"
                           id="jumlah_tiket"
                           name="jumlah_tiket"
                           class="form-control"
                           min="1"
                           value="1"
                           onchange="hitungTotal()"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Total Bayar
                    </label>

                    <input type="text"
                           id="total_view"
                           class="form-control"
                           readonly>

                    <input type="hidden"
                           id="total_bayar"
                           name="total_bayar">

                </div>

                <div class="d-grid">

                    <button type="submit"
                            class="btn btn-success">

                        Kirim Reservasi Sekarang

                    </button>

                    <a href="{{ route('home') }}"
                       class="btn btn-secondary mt-2">

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

function hitungTotal()
{
    let fasilitas =
        document.getElementById('id_fasilitas');

    let harga =
        fasilitas.options[
            fasilitas.selectedIndex
        ].dataset.harga;

    let jumlah =
        document.getElementById('jumlah_tiket').value;

    let total =
        parseInt(harga) * parseInt(jumlah);

    document.getElementById('total_bayar')
        .value = total;

    document.getElementById('total_view')
        .value = "Rp " + total.toLocaleString('id-ID');
}

window.onload = hitungTotal;

</script>

</body>
</html>