<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lokasi Interaktif - Jagara Eco Park</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link rel="stylesheet" href="{{ asset('assets/index.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lokasi.css') }}">
    <style>
        .header {
            background: rgba(14, 165, 233, 0.95) !important;
        }
    </style>
</head>
<body>

@include('partials.header')

<div class="map-container">

    <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.575827752537!2d108.56685997493427!3d-6.821686666825665!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f2e8e2f2e2f2f%3A0x2e6f2e8e2f2e2f2f!2sJagara%20Eco%20Park!5e0!3m2!1sid!2sid!4v1719763200000!5m2!1sid!2sid"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
    </iframe>

    <a href="{{ route('home') }}" class="btn-back-clean">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

</div>

<script>
// Automatic GPS trigger on page load - Direct Navigation Protocol
window.addEventListener('load', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const destination = "JAGARA+Eco+Park+XCH9+X46+Jl+Sekerta+Timur+Jagara+Kec+Darma+Kabupaten+Kuningan+Jawa+Barat+45562+Indonesia";
            window.open(`https://www.google.com/maps/dir/?api=1&origin=${lat},${lng}&destination=${destination}`, '_blank');
        }, function(error) {
            console.log('Geolocation permission denied or error occurred.');
        });
    }
});
</script>

</body>
</html>