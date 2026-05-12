<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPAN - Makan Apa Nanti?</title>

    {{-- Google Fonts: Poppins untuk heading, Nunito untuk body --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family:'Nunito',sans-serif; background:#FAF7F2; color:#1A1A1A; }
        h1,h2,h3,h4,h5,h6 { font-family:'Poppins',sans-serif; }

        /* Navbar sticky dengan blur */
        .navbar {
            position:sticky; top:0; z-index:50;
            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(10px);
            border-bottom:1px solid rgba(232,83,26,0.1);
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
        }

        /* Search bar navbar */
        .search-bar-nav { border:1.5px solid #E5E7EB; border-radius:50px; transition:all 0.2s; }
        .search-bar-nav:focus-within { border-color:#E8531A; box-shadow:0 0 0 3px rgba(232,83,26,0.12); }

        /* Hero background gradient hangat */
        .hero-section {
            background:linear-gradient(135deg,#FFF9F6 0%,#FFF3EC 60%,#FFE9D8 100%);
            position:relative; overflow:hidden;
        }

        /* Tombol primary orange */
        .btn-primary {
            background:linear-gradient(135deg,#E8531A 0%,#C0421A 100%);
            color:white; border-radius:50px; font-weight:600;
            font-family:'Poppins',sans-serif; transition:all 0.25s;
            box-shadow:0 4px 15px rgba(232,83,26,0.35);
        }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(232,83,26,0.45); }

        /* Angka statistik di hero */
        .stat-number { font-family:'Poppins',sans-serif; font-weight:800; color:#E8531A; }

        /* Banner ajakan daftar merchant */
        .merchant-banner { background:linear-gradient(135deg,#E8531A 0%,#C0421A 100%); }

        /* Chip/pill filter kategori */
        .category-chip {
            background: white; border: 1.5px solid #E5E7EB; border-radius: 50px;
            color: #1A1A1A; transition: all 0.2s; font-family: 'Poppins', sans-serif;
            cursor: pointer; white-space: nowrap;
        }
        .category-chip:hover, .category-chip.active { background: #2D231E; border-color: #2D231E; color: white; }

        /* Kartu restoran top rating */
        .restaurant-card { border-radius:16px; overflow:hidden; transition:all 0.25s; box-shadow:0 2px 10px rgba(0,0,0,0.08); }
        .restaurant-card:hover { transform:translateY(-4px); box-shadow:0 12px 30px rgba(0,0,0,0.14); }
        .badge-top { background:#E8531A; color:white; font-size:11px; font-weight:700; border-radius:6px; padding:2px 8px; font-family:'Poppins',sans-serif; }
        .star-rating { color:#FBBF24; }

        /* Section peta gelap */
        .map-section { background:#1A1A1A; border-radius:20px; overflow:hidden; }

        /* Banner CTA punya restoran */
        .resto-cta-banner { background:linear-gradient(135deg,#E8531A 0%,#F47B45 50%,#FFBB8A 100%); border-radius:20px; }

        /* Footer gelap */
        .footer { background:#1A1A1A; color:#D1D5DB; }
        .footer a { color:#9CA3AF; transition:color 0.2s; }
        .footer a:hover { color:#F47B45; }

        @keyframes spin-slow { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }

        /* Animasi fade + slide saat halaman pertama dimuat */
        .fade-in-up { opacity:0; transform:translateY(24px); animation:fadeInUp 0.6s ease forwards; }
        @keyframes fadeInUp { to{opacity:1; transform:translateY(0)} }
        .delay-1{animation-delay:.1s} .delay-2{animation-delay:.2s} .delay-3{animation-delay:.35s}
    </style>
</head>
<body>

<!-- ============================================================
     NAVBAR — sticky di atas, logo | search | navigasi | auth
============================================================ -->
@include('partials.navbar')


<!-- ============================================================
     HERO SECTION
============================================================ -->
<section class="hero-section py-16 md:py-24 px-4" style="background:#FFF8F3">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center gap-12 relative">

            {{-- Teks hero (kiri) --}}
            <div class="flex-1 text-center md:text-left z-10">
                <h1 class="font-bold text-5xl md:text-6xl lg:text-7xl leading-tight mb-4 fade-in-up"
                    style="font-family:'Poppins',sans-serif; color:#2D231E">
                    Makan Apa <br>
                    <span class="text-[#E8531A]">Nanti?</span>
                </h1>
                <p class="text-gray-500 text-base md:text-lg mb-8 max-w-md fade-in-up delay-1">
                    Temukan restoran terbaik di Semarang berdasarkan lokasi, kategori, dan rating dari ribuan pengguna.
                </p>
                <div class="fade-in-up delay-2 mb-10">
                    <a href="{{ route('user.search') }}" class="bg-[#E8531A] text-white px-10 py-3 rounded-full font-bold text-lg hover:bg-[#C0421A] transition-all inline-block shadow-lg shadow-orange-200">
                        Jelajahi Sekarang
                    </a>
                </div>

                {{-- Statistik --}}
                <div class="flex items-center justify-center md:justify-start gap-10 fade-in-up delay-3">
                    <div>
                        <div class="stat-number text-3xl font-extrabold text-[#E8531A]">{{ \App\Models\Restaurant::count() }}+</div>
                        <div class="text-xs text-gray-400 font-medium uppercase tracking-wider">Restoran</div>
                    </div>
                    <div>
                        <div class="stat-number text-3xl font-extrabold text-[#E8531A]">{{ \App\Models\Category::count() }}</div>
                        <div class="text-xs text-gray-400 font-medium uppercase tracking-wider">Kategori</div>
                    </div>
                    <div>
                        <div class="stat-number text-3xl font-extrabold text-[#E8531A]">{{ \App\Models\Review::count() / 1000 >= 1 ? number_format(\App\Models\Review::count() / 1000, 1) . 'rb' : \App\Models\Review::count() }}+</div>
                        <div class="text-xs text-gray-400 font-medium uppercase tracking-wider">Ulasan</div>
                    </div>
                </div>
            </div>

            {{-- Ilustrasi makanan (kanan) --}}
            <div class="relative flex-1 flex items-center justify-center fade-in-up delay-2 hidden md:flex">
                <div class="relative z-10">
                    <img src="{{ asset('image/gambar dimsum.png') }}" alt="Food" class="w-[400px] drop-shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     BANNER MERCHANT — ajakan daftar restoran
============================================================ -->
<!-- ============================================================
     BANNER MERCHANT
============================================================ -->
<section class="max-w-7xl mx-auto px-4 my-8">
    <div class="bg-[#E8531A] rounded-2xl px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl shadow-orange-100">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4a1 1 0 011-1h2a1 1 0 011 1v3M12 21v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3M12 21h2m-2 0h-5"/></svg>
            </div>
            <div>
                <div class="font-bold text-white text-base" style="font-family:'Poppins',sans-serif">Daftarkan restoranmu sekarang!</div>
                <div class="text-white/80 text-sm">Jangkau ribuan pengguna MAPAN di Semarang tanpa biaya apapun.</div>
            </div>
        </div>
        <a href="{{ route('register.form', ['role' => 'merchant']) }}"
           class="bg-white text-[#E8531A] font-bold px-10 py-2.5 rounded-full text-sm hover:bg-orange-50 transition-all shadow-md">
            Daftar Merchant
        </a>
    </div>
</section>


<!-- ============================================================
     FILTER KATEGORI — chip horizontal yang bisa di-scroll
============================================================ -->


<section class="max-w-7xl mx-auto px-4 my-8">
    <h2 class="font-bold text-2xl mb-6" style="font-family:'Poppins',sans-serif; color:#2D231E">Mau makan <span class="text-[#E8531A]">apa?</span></h2>
    <div class="flex gap-4 overflow-x-auto pb-4 category-chips" style="scrollbar-width:none">
        {{-- Chip "Semua" --}}
        <button data-url="{{ route('home', ['show_all' => 1]) }}" class="category-chip px-8 py-2.5 text-sm font-bold flex-shrink-0 {{ request('show_all') || (request()->fullUrl() == route('home')) ? 'active' : '' }}">Semua</button>
        @foreach($categories as $cat)
            <button data-url="{{ route('home', ['category' => $cat->id]) }}" class="category-chip px-8 py-2.5 text-sm font-bold flex-shrink-0 {{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->nama_kategori }}</button>
        @endforeach
    </div>
</section>

{{-- Section Unified Restoran --}}
<section id="top-rating-section" class="max-w-7xl mx-auto px-4 my-12">
    <div class="flex items-center gap-3 mb-2">
        <svg class="w-7 h-7 text-[#E8531A]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
        <h2 class="font-bold text-2xl" style="font-family:'Poppins',sans-serif; color:#2D231E">Top <span class="text-[#E8531A]">Rating</span></h2>
    </div>
    <p class="text-gray-400 text-sm mb-8">Restoran terbaik berdasarkan ulasan pengguna</p>

    <div id="unified-restaurant-grid">
        @include('partials.restaurant_list', ['restaurants' => $restaurants])
    </div>
</section>


<!-- ============================================================
     SECTION MAPS — peta + teks ajakan eksplorasi
============================================================ -->
<section id="maps" class="max-w-7xl mx-auto px-4 my-16">
    <a href="https://www.google.com/maps/search/restoran+di+Semarang" target="_blank" 
       class="block bg-[#2D231E] rounded-[40px] overflow-hidden shadow-2xl transition-all hover:shadow-orange-100/20 group">
        <div class="flex flex-col md:flex-row min-h-[400px]">
            {{-- Area peta (kiri) --}}
            <div class="md:w-1/2 h-80 md:h-auto relative bg-gray-100 rounded-b-[40px] md:rounded-b-none md:rounded-r-[80px] overflow-hidden z-10 shadow-xl">
                <div id="map-container" class="w-full h-full"></div>
                {{-- Overlay tipis agar tidak terlalu silau --}}
                <div class="absolute inset-0 bg-blue-500/5 pointer-events-none"></div>
            </div>

            {{-- Teks kanan --}}
            <div class="flex-1 p-10 md:p-16 flex flex-col justify-center">
                <h2 class="font-bold text-3xl md:text-5xl text-white mb-6 leading-tight" style="font-family:'Poppins',sans-serif">
                    Jelajahi Lewat Peta
                </h2>
                <p class="text-gray-400 text-base md:text-lg leading-relaxed mb-8 max-w-md">
                    Temukan restoran-restoran menarik yang bisa kamu kunjungi di Kota Semarang!
                </p>
                <div class="flex items-center gap-3 text-[#E8531A] font-bold text-sm">
                    <span>Lihat di Google Maps</span>
                    <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </div>
            </div>
        </div>
    </a>
</section>

{{-- Load Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    /* Custom Marker yang lebih clean */
    .custom-marker {
        width: 16px; height: 16px;
        background: #E8531A;
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .leaflet-control-attribution { display: none !important; }
    /* Menghilangkan border focus pada map */
    .leaflet-container { outline: none; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const semarangCoord = [-6.9932, 110.4203];
        const map = L.map('map-container', {
            zoomControl: false,
            scrollWheelZoom: false,
            dragging: false,
            touchZoom: false,
            doubleClickZoom: false
        }).setView(semarangCoord, 14);

        // Pakai Light Theme yang bersih
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

        // Tambah marker tunggal di pusat Semarang
        const icon = L.divIcon({
            className: 'custom-marker',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });
        L.marker(semarangCoord, {icon: icon}).addTo(map);
    });
</script>


<!-- ============================================================
     CTA BANNER RESTORAN — untuk menarik merchant baru
============================================================ -->
<!-- ============================================================
     CTA BANNER
============================================================ -->
<section class="max-w-7xl mx-auto px-4 my-16">
    <div class="bg-[#E8531A] rounded-[40px] px-12 py-12 flex flex-col md:flex-row items-center justify-between gap-10 shadow-2xl shadow-orange-200">
        <div class="text-white text-center md:text-left flex-1">
            <h2 class="font-bold text-4xl md:text-5xl mb-4" style="font-family:'Poppins',sans-serif">
                Punya Restoran di <br>Kota Semarang?
            </h2>
            <p class="text-white/85 text-lg">
                Daftarkan restoranmu sekarang agar bisa ditemukan ribuan pengguna MAPAN. Gratis, mudah, dan langsung tampil!
            </p>
        </div>
        <div class="shrink-0">
            <img src="{{ asset('image/icon Restaurant.png') }}" alt="Restaurant Icon" class="h-48 md:h-64 object-contain opacity-90">
        </div>
    </div>
</section>


<!-- ============================================================
     FOOTER — logo | jelajahi | kategori | merchant
============================================================ -->
@include('partials.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chips = document.querySelectorAll('.category-chip');
        const grid = document.getElementById('unified-restaurant-grid');
        const topRatingSection = document.getElementById('top-rating-section');

        chips.forEach(chip => {
            chip.addEventListener('click', async function() {
                const url = this.getAttribute('data-url');
                
                // Update UI chips
                chips.forEach(c => {
                    c.classList.remove('active');
                });
                this.classList.add('active');

                // Fetch data
                try {
                    const response = await fetch(url + (url.includes('?') ? '&' : '?') + 'view=grid', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const html = await response.text();
                    grid.innerHTML = html;
                } catch (error) {
                    console.error('Error fetching restaurants:', error);
                }
            });
        });
    });

    // Smooth scroll untuk anchor link (#top-rating, #maps)
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function(e) {
            const t = document.querySelector(this.getAttribute('href'));
            if (t) { e.preventDefault(); t.scrollIntoView({behavior:'smooth', block:'start'}); }
        });
    });
</script>

</body>
</html>
