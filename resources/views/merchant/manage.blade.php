<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Merchant - {{ $restaurant->nama_restoran }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; background: #FAF7F2; color: #1A1A1A; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        .navbar { position: sticky; top: 0; z-index: 50; background: white; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .stat-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #F3F4F6; }
        .menu-item { background: white; border-bottom: 1.5px solid #F3F4F6; padding: 16px 0; transition: all 0.2s; }
        .menu-item:last-child { border-bottom: none; }
        .btn-action { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; border: 1.5px solid #E5E7EB; color: #4B5563; transition: all 0.2s; }
        .btn-action:hover { border-color: #E8531A; color: #E8531A; }
        .review-card { border-bottom: 1px solid #F3F4F6; padding: 16px 0; }
        .review-card:last-child { border-bottom: none; }
        .btn-primary { background: #E8531A; color: white; border-radius: 50px; font-weight: 600; transition: all 0.2s; }
        .btn-primary:hover { background: #C0421A; }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal.active { display: flex; }
    </style>
</head>
<body>

@include('partials.navbar')

<main class="max-w-7xl mx-auto px-4 py-10">
    
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Selamat datang, {{ $user->nama_pengguna }}!</h1>
            <p class="text-gray-400 text-sm mt-1">Berikut ringkasan aktivitas restoran kamu hari ini</p>
        </div>
        <a href="{{ route('merchant.edit') }}" class="px-6 py-3 bg-[#E8531A] text-white rounded-xl text-sm font-bold shadow-lg shadow-orange-100 flex items-center gap-2 hover:bg-[#C0421A] transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Informasi Resto
        </a>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="stat-card">
            <p class="text-[10px] font-black text-black-300 uppercase tracking-widest mb-1">Total Menu</p>
            <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalMenu }}</div>
            <p class="text-[10px] text-gray-400 font-bold">Total menu restoran anda</p>
        </div>
        <div class="stat-card">
            <p class="text-[10px] font-black text-black-300 uppercase tracking-widest mb-1">Rating Rata-rata</p>
            <div class="text-3xl font-bold text-gray-800 mb-1">{{ $averageRating }}</div>
            <p class="text-[10px] text-gray-400 font-bold">{{ $averageRating }}/5</p>
        </div>
        <div class="stat-card">
            <p class="text-[10px] font-black text-black-300 uppercase tracking-widest mb-1">Total Ulasan</p>
            <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalReviews }}</div>
            <p class="text-[10px] text-gray-400 font-bold">Dari user</p>
        </div>
        <div class="stat-card">
            <p class="text-[10px] font-black text-black-300 uppercase tracking-widest mb-1">Ulasan Baru</p>
            <div class="text-3xl font-bold text-gray-800 mb-1">{{ $newReviewsCount }}</div>
            <p class="text-[10px] text-gray-400 font-bold">Belum dibaca</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- Left: Menu List --}}
        <div class="flex-1 space-y-10">
            
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-sm font-black text-black-300 uppercase tracking-widest">Makanan</h2>
                    <button onclick="openModal('Makanan')" class="text-xs font-bold text-[#E8531A] hover:underline">+ Tambah Makanan</button>
                </div>
                <div class="space-y-2">
                    @forelse($makanan as $item)
                        <div class="menu-item flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800">{{ $item->nama_menu }}</h4>
                                <p class="text-xs text-gray-400 mt-1 max-w-md">{{ $item->deskripsi }}</p>
                                <div class="text-sm font-bold text-gray-800 mt-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="editMenu({{ $item }})" class="btn-action">Edit</button>
                                <form action="{{ route('menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action hover:bg-red-50 hover:text-red-500 hover:border-red-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 py-4 italic">Belum ada menu makanan.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-sm font-black text-black-300 uppercase tracking-widest">Minuman</h2>
                    <button onclick="openModal('Minuman')" class="text-xs font-bold text-[#E8531A] hover:underline">+ Tambah Minuman</button>
                </div>
                <div class="space-y-2">
                    @forelse($minuman as $item)
                        <div class="menu-item flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800">{{ $item->nama_menu }}</h4>
                                <p class="text-xs text-gray-400 mt-1 max-w-md">{{ $item->deskripsi }}</p>
                                <div class="text-sm font-bold text-gray-800 mt-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="editMenu({{ $item }})" class="btn-action">Edit</button>
                                <form action="{{ route('menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action hover:bg-red-50 hover:text-red-500 hover:border-red-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 py-4 italic">Belum ada menu minuman.</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Right: Reviews --}}
        <div class="lg:w-80 shrink-0">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-black text-black-300 uppercase tracking-widest">Ulasan Restoran</h2>
                    <a href="{{ route('restaurant.show', $restaurant->id_restoran) }}#section-ulasan" class="text-[10px] font-bold text-gray-400 border border-gray-200 px-3 py-1 rounded-lg hover:border-[#E8531A] hover:text-[#E8531A] transition-all">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($restaurant->reviews->take(5) as $review)
                        <div class="review-card">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-xs font-bold text-gray-400">
                                    {{ strtoupper(substr($review->user->nama_pengguna, 0, 1)) }}
                                </div>
                                <div class="text-xs font-bold text-gray-700">{{ $review->user->nama_pengguna }}</div>
                            </div>
                            <div class="flex mb-2">
                                @for($i=1;$i<=5;$i++)
                                    <span class="text-[10px] {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                @endfor
                            </div>
                            <p class="text-[11px] text-gray-400 leading-relaxed italic">"{{ Str::limit($review->komentar, 100) }}"</p>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 py-4 italic">Belum ada ulasan.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</main>

{{-- Modal Add/Edit --}}
<div id="menuModal" class="modal">
    <div class="bg-white rounded-[32px] w-full max-w-lg p-10 relative mx-4">
        <button onclick="closeModal()" class="absolute top-8 right-8 text-gray-400 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <h3 id="modalTitle" class="text-2xl font-bold text-gray-800 mb-6">Tambah Menu</h3>
        
        <form id="menuForm" method="POST" action="{{ route('menu.store') }}" class="space-y-5">
            @csrf
            <div id="methodField"></div>
            
            <input type="hidden" name="kategori" id="kategoriInput">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu<span class="text-red-500">*</span></label>
                <input type="text" name="nama_menu" id="namaMenu" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-[#E8531A] transition-all" placeholder="Contoh: Mie Ayam Spesial">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsiMenu" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-[#E8531A] transition-all" placeholder="Ceritakan tentang menu ini..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)<span class="text-red-500">*</span></label>
                <input type="number" name="harga" id="hargaMenu" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-[#E8531A] transition-all" placeholder="Contoh: 18000">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full btn-primary py-4 text-sm shadow-lg shadow-orange-100">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

{{-- Skrip JavaScript untuk Pengelolaan Menu (Tambah/Edit) --}}
<script>
    const modal = document.getElementById('menuModal');
    const form = document.getElementById('menuForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const kategoriInput = document.getElementById('kategoriInput');
    
    const namaInput = document.getElementById('namaMenu');
    const deskripsiInput = document.getElementById('deskripsiMenu');
    const hargaInput = document.getElementById('hargaMenu');

    /**
     * Membuka modal untuk menambah menu baru.
     * @param {string} kategori - Kategori menu (Makanan/Minuman).
     */
    function openModal(kategori) {
        modalTitle.innerText = 'Tambah ' + kategori;
        form.action = "{{ route('menu.store') }}";
        methodField.innerHTML = ''; // Pastikan tidak ada method spoofing (default POST)
        kategoriInput.value = kategori;
        
        // Reset form
        namaInput.value = '';
        deskripsiInput.value = '';
        hargaInput.value = '';
        
        modal.classList.add('active');
    }

    /**
     * Menutup modal.
     */
    function closeModal() {
        modal.classList.remove('active');
    }

    /**
     * Membuka modal untuk mengedit menu yang sudah ada.
     * @param {object} menu - Objek data menu dari backend.
     */
    function editMenu(menu) {
        modalTitle.innerText = 'Edit Menu';
        form.action = "/merchant/menu/" + menu.id; // URL update
        methodField.innerHTML = '@method("PUT")'; // Spoofing method PUT untuk update
        kategoriInput.value = menu.kategori;
        
        // Isi data menu ke dalam form
        namaInput.value = menu.nama_menu;
        deskripsiInput.value = menu.deskripsi;
        hargaInput.value = menu.harga;
        
        modal.classList.add('active');
    }

    // Menutup modal jika user mengklik area di luar kotak modal
    window.onclick = function(event) {
        if (event.target == modal) closeModal();
    }
</script>

</body>
</html>
