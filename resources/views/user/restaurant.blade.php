<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->nama_restoran }} - MAPAN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body{font-family:'Nunito',sans-serif;background:#FAF7F2;color:#2D231E}
        h1,h2,h3,h4,h5,h6{font-family:'Poppins',sans-serif}
        .navbar{position:sticky;top:0;z-index:50;background:white;border-bottom:1px solid #F3F4F6}
        .search-bar-nav{border:1.5px solid #E5E7EB;border-radius:50px;transition:all .2s}
        .tab-btn{padding:12px 0;font-size:15px;font-weight:700;color:#9CA3AF;border-bottom:4px solid transparent;transition:all .2s; font-family:'Poppins', sans-serif;}
        .tab-btn.active{color:#E8531A;border-bottom-color:#E8531A}
        .info-card{background:white;border-radius:24px;box-shadow:0 10px 30px rgba(0,0,0,0.02);border:1px solid #F3F4F6}
        .btn-primary{background:#E8531A;color:white;border-radius:12px;font-weight:700;transition:all .2s;box-shadow:0 4px 15px rgba(232,83,26,0.2)}
        .btn-primary:hover{background:#C0421A;transform:translateY(-1px)}
        .btn-outline{border:1.5px solid #E5E7EB;border-radius:12px;font-weight:600;transition:all .2s;color:#4B5563}
        .btn-outline:hover{border-color:#E8531A;color:#E8531A}
        .rating-bar{height:6px;border-radius:10px;background:#F3F4F6;overflow:hidden}
        .rating-bar-fill{height:100%;background:#E8531A;border-radius:10px}
        
        /* New Styles for Light Header */
        .header-light { background: #FFF8F3; color: #1A1A1A; }
        .header-light .text-gray-400 { color: #9CA3AF; }
        .header-light .text-gray-200 { color: #4B5563; }
    </style>
</head>
<body>

{{-- Navbar --}}
@include('partials.navbar')

{{-- Header Section - Light Theme --}}
<div class="header-light py-12 mb-0 border-b border-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start text-center md:text-left">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-[32px] overflow-hidden shadow-2xl shrink-0 border-4 border-white/10">
                @if($restaurant->gambar)
                    <img src="{{ asset('storage/'.$restaurant->gambar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-orange-50 flex items-center justify-center text-6xl">🍽️</div>
                @endif
            </div>
            <div class="flex-1 pt-2">
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">{{ $restaurant->category->nama_kategori ?? 'Tanpa Kategori' }}</p>
                <div class="flex items-center justify-center md:justify-start gap-4 mb-4">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-[#E8531A]">{{ $restaurant->nama_restoran }}</h1>
                    @auth
                        @if(Auth::user()->role === 'merchant' && Auth::user()->restaurant && Auth::user()->restaurant->id_restoran === $restaurant->id_restoran)
                            <a href="{{ route('merchant.manage') }}" class="px-4 py-1.5 border border-[#E8531A] text-[#E8531A] text-xs font-bold rounded-full hover:bg-[#E8531A] hover:text-white transition-all whitespace-nowrap">Kelola Restoran</a>
                        @endif
                    @endauth
                </div>
                <div class="flex items-center justify-center md:justify-start gap-6 flex-wrap text-sm font-bold">
                    <div class="flex items-center gap-2">
                        <div class="flex">
                            @for($i=1;$i<=5;$i++)<span class="text-sm {{ $i <= round($restaurant->averageRating()) ? 'text-yellow-400' : 'text-gray-600' }}">★</span>@endfor
                        </div>
                        <span class="text-[#E8531A] text-lg">{{ number_format($restaurant->averageRating(), 1) }}</span>
                        <span class="text-gray-400 text-xs font-normal">({{ $restaurant->reviews->count() }} ulasan)</span>
                    </div>
                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-lg text-xs uppercase">Buka</span>
                    <span class="text-gray-500 font-medium flex items-center gap-2">
                        <img src="{{ asset('image/ikon jam buka.png') }}" class="w-4 h-4 object-contain">
                        {{ $restaurant->jam_operasional ?? '08.00 - 21.00' }}
                    </span>
                    @php
                        $prices = explode(' - ', $restaurant->range_harga ?? '');
                        if (count($prices) === 2 && is_numeric($prices[0]) && is_numeric($prices[1])) {
                            $displayHargaShort = number_format($prices[0], 0, ',', '.') . ' - ' . number_format($prices[1], 0, ',', '.');
                        } else {
                            $displayHargaShort = $restaurant->range_harga ?? '-';
                        }
                    @endphp
                    <span class="text-gray-500 font-medium flex items-center gap-2">
                        <img src="{{ asset('image/ikon harga.png') }}" class="w-4 h-4 object-contain">
                        {{ $displayHargaShort }}
                    </span>
                    <span class="text-gray-500 font-medium flex items-center gap-2 truncate max-w-[250px]">
                        <img src="{{ asset('image/ikon lokasi.png') }}" class="w-4 h-4 object-contain">
                        {{ Str::limit($restaurant->alamat, 30) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabs Section (Full Width) --}}
<div class="border-b border-gray-100 mb-8 bg-white sticky top-[73px] z-40 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-16 md:gap-32">
            <button class="tab-btn active" id="btn-informasi" onclick="switchTab('informasi')">Informasi</button>
            <button class="tab-btn" id="btn-menu" onclick="switchTab('menu')">Menu</button>
            <button class="tab-btn" id="btn-ulasan" onclick="switchTab('ulasan')">Ulasan ({{ $restaurant->reviews->count() }})</button>
        </div>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-0">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
        
        {{-- Left Content --}}
        <div class="lg:col-span-2">
            
            {{-- Section: Informasi --}}
            <div id="section-informasi" class="space-y-8">
                <div class="info-card p-8">
                    <h3 class="text-xl font-bold mb-4">Tentang Restoran</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        {{ $restaurant->deskripsi ?? 'Deskripsi restoran belum ditambahkan.' }}
                    </p>
                </div>

                <div class="info-card p-8">
                    <h3 class="text-xl font-bold mb-6">Detail Informasi</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-400 font-bold">{{ $restaurant->hari_operasional ?? '-' }}</span>
                            <span class="text-sm font-bold">{{ $restaurant->jam_operasional ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-400 font-bold">Alamat</span>
                            <span class="text-sm font-bold text-right max-w-[250px]">{{ $restaurant->alamat }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-400 font-bold">No. Kontak</span>
                            <span class="text-sm font-bold">{{ $restaurant->kontak }}</span>
                        </div>
                        <div class="flex justify-between py-3">
                            <span class="text-sm text-gray-400 font-bold">Harga</span>
                            @php
                                $prices = explode(' - ', $restaurant->range_harga ?? '');
                                if (count($prices) === 2 && is_numeric($prices[0]) && is_numeric($prices[1])) {
                                    $displayHarga = 'Rp ' . number_format($prices[0], 0, ',', '.') . ' - Rp ' . number_format($prices[1], 0, ',', '.');
                                } else {
                                    $displayHarga = $restaurant->range_harga ?? '-';
                                }
                            @endphp
                            <span class="text-sm font-bold">{{ $displayHarga }}</span>
                        </div>
                    </div>
                </div>

                {{-- Preview Ulasan (untuk tab informasi) --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">Ulasan Pengguna</h3>
                    </div>
                    
                    <div class="info-card p-8">
                        <div class="flex flex-col sm:flex-row gap-10 items-center">
                            <div class="text-center sm:pr-10 sm:border-r border-gray-100">
                                <div class="text-6xl font-black text-[#2D231E]">{{ number_format($restaurant->averageRating(), 1) }}</div>
                                <div class="flex justify-center my-2">@for($i=1;$i<=5;$i++)<span class="text-lg {{ $i <= round($restaurant->averageRating()) ? 'text-yellow-400' : 'text-gray-200' }}">★</span>@endfor</div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $restaurant->reviews->count() }} ulasan</p>
                            </div>
                            <div class="flex-1 w-full space-y-3">
                                @for($s=5; $s>=1; $s--)
                                    @php 
                                        $count = $ratingDistribution[$s] ?? 0;
                                        $total = $restaurant->reviews->count();
                                        $pct = $total > 0 ? ($count / $total) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold text-gray-400 w-2">{{ $s }}</span>
                                        <div class="rating-bar flex-1"><div class="rating-bar-fill" style="width: {{ $pct }}%"></div></div>
                                        <span class="text-xs font-bold text-gray-300 w-6 text-right">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($restaurant->reviews->take(2) as $review)
                            <div class="info-card p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center font-bold text-[#E8531A]">{{ strtoupper(substr($review->user->nama_pengguna, 0, 1)) }}</div>
                                        <div>
                                            <h4 class="text-sm font-bold">{{ $review->user->nama_pengguna }}</h4>
                                            <div class="flex">@for($i=1;$i<=5;$i++)<span class="text-[10px] {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>@endfor</div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-gray-500 leading-relaxed italic">"{{ $review->komentar }}"</p>
                            </div>
                        @empty
                            <div class="p-10 text-center bg-white rounded-[32px] border-2 border-dashed border-gray-100">
                                <p class="text-gray-400 font-bold">Belum ada ulasan.</p>
                            </div>
                        @endforelse
                        
                        @if($restaurant->reviews->count() > 2)
                            <div class="text-center py-2">
                                <button onclick="switchTab('ulasan')" class="text-xs font-bold text-gray-400 hover:text-[#E8531A] transition-all">Lihat semua {{ $restaurant->reviews->count() }} ulasan</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Section: Menu --}}
            <div id="section-menu" class="hidden space-y-8">
                <div class="info-card p-8">
                    <h3 class="text-sm font-black text-black-300 uppercase tracking-widest mb-6">Makanan</h3>
                    <div class="space-y-4">
                        @forelse($restaurant->menus->where('kategori', 'Makanan') as $item)
                            <div class="py-4 border-b border-gray-50 last:border-0">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800">{{ $item->nama_menu }}</h4>
                                        <p class="text-xs text-gray-400 mt-1">{{ $item->deskripsi }}</p>
                                    </div>
                                    <div class="text-sm font-bold text-[#E8531A]">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 italic">Belum ada menu makanan.</p>
                        @endforelse
                    </div>
                </div>

                <div class="info-card p-8">
                    <h3 class="text-sm font-black text-black-300 uppercase tracking-widest mb-6">Minuman</h3>
                    <div class="space-y-4">
                        @forelse($restaurant->menus->where('kategori', 'Minuman') as $item)
                            <div class="py-4 border-b border-gray-50 last:border-0">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800">{{ $item->nama_menu }}</h4>
                                        <p class="text-xs text-gray-400 mt-1">{{ $item->deskripsi }}</p>
                                    </div>
                                    <div class="text-sm font-bold text-[#E8531A]">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 italic">Belum ada menu minuman.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Section: Ulasan --}}
            <div id="section-ulasan" class="hidden space-y-8">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Semua Ulasan</h3>
                </div>

                <div class="space-y-4">
                    @forelse($restaurant->reviews as $review)
                        <div class="info-card p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center font-bold text-[#E8531A]">{{ strtoupper(substr($review->user->nama_pengguna, 0, 1)) }}</div>
                                    <div>
                                        <h4 class="text-sm font-bold">{{ $review->user->nama_pengguna }}</h4>
                                        <div class="flex">@for($i=1;$i<=5;$i++)<span class="text-[10px] {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>@endfor</div>
                                    </div>
                                </div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $review->created_at->format('d M Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-500 leading-relaxed italic">"{{ $review->komentar }}"</p>
                            @if($review->gambar)
                                <div class="mt-4 w-24 h-24 rounded-xl overflow-hidden border border-gray-100">
                                    <img src="{{ asset('storage/'.$review->gambar) }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            @if(Auth::id() === $review->user_id)
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Hapus review?')">
                                    @csrf @method('DELETE')
                                    <button class="text-[10px] text-red-400 font-bold uppercase hover:underline">Hapus Review</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="p-20 text-center bg-white rounded-[32px] border-2 border-dashed border-gray-100">
                            <p class="text-gray-400 font-bold">Belum ada ulasan untuk restoran ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Right Content / Sidebar --}}
        <div class="space-y-8">
            {{-- Map Card --}}
            <div class="info-card overflow-hidden">
                <div class="h-48 bg-gray-100">
                    @if($restaurant->gmaps_link)
                        <iframe src="https://www.google.com/maps?q={{ urlencode($restaurant->alamat) }}&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">Peta tidak tersedia</div>
                    @endif
                </div>
                <div class="p-6">
                    <h4 class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Lokasi</h4>
                    <p class="text-sm font-bold text-gray-600">Lokasi Restoran</p>
                </div>
            </div>

            {{-- Actions Card --}}
            <div class="info-card p-8 space-y-4">
                <h3 class="text-xs font-black text-gray-300 uppercase tracking-widest mb-2">Aksi Cepat</h3>
                @auth
                    @if(Auth::user()->role === 'user' && !$sudahReview)
                        <a href="{{ route('reviews.create', $restaurant->id_restoran) }}" class="btn-primary w-full py-4 text-sm text-center block">Tulis Ulasan</a>
                    @elseif(Auth::user()->role === 'user' && $sudahReview)
                        <div class="bg-orange-50 text-[#E8531A] p-4 rounded-xl text-xs font-bold text-center">Anda sudah memberikan ulasan</div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full py-4 text-sm text-center block">Login untuk Review</a>
                @endauth
                <button onclick="switchTab('menu')" class="btn-outline w-full py-4 text-sm text-center block">Lihat Menu Lengkap</button>
                <a href="tel:{{ $restaurant->kontak }}" class="btn-outline w-full py-4 text-sm text-center block">Hubungi Resto</a>
            </div>
        </div>

    </div>
</main>

@include('partials.footer')

{{-- Skrip JavaScript untuk Fungsionalitas Tab (Informasi, Menu, Ulasan) --}}
<script>
    /**
     * Fungsi untuk berpindah antar tab (Informasi, Menu, Ulasan).
     * @param {string} targetId - ID dari konten tab (informasi, menu, atau ulasan).
     */
    function switchTab(targetId) {
        // Atur status aktif pada tombol tab
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('btn-' + targetId).classList.add('active');

        // Sembunyikan semua section konten terlebih dahulu
        document.getElementById('section-informasi').classList.add('hidden');
        document.getElementById('section-menu').classList.add('hidden');
        document.getElementById('section-ulasan').classList.add('hidden');

        // Tampilkan section konten yang dipilih
        document.getElementById('section-' + targetId).classList.remove('hidden');
        
        // Scroll halus ke area konten agar user tidak perlu scroll manual ke bawah
        window.scrollTo({
            top: document.querySelector('.header-dark').offsetHeight - 50,
            behavior: 'smooth'
        });
    }
</script>

</body>
</html>