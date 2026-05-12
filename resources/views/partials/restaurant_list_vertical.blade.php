<div class="space-y-4">
    @forelse($restaurants as $resto)
        <a href="{{ route('restaurant.show', $resto->id_restoran) }}" class="group flex bg-white p-4 rounded-2xl shadow-md shadow-gray-200/50 border border-gray-50 items-start gap-6 hover:shadow-lg transition-all">
            <!-- Left: Image -->
            <div class="w-28 h-28 rounded-xl overflow-hidden shrink-0 bg-gray-50 shadow-inner">
                @if($resto->gambar)
                    <img src="{{ asset('storage/'.$resto->gambar) }}" alt="{{ $resto->nama_restoran }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl">🍽️</div>
                @endif
            </div>

            <!-- Middle: Info -->
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-start">
                    <h3 class="font-bold text-base text-gray-800" style="font-family:'Poppins',sans-serif">{{ $resto->nama_restoran }}</h3>
                    <!-- Right: Rating -->
                    <div class="text-right shrink-0">
                        <span class="font-bold text-sm text-gray-800">{{ number_format($resto->averageRating(), 1) }}</span>
                        <span class="text-gray-400 text-[10px]">({{ $resto->reviews->count() }} ulasan)</span>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-1.5 text-[10px] text-gray-400 font-bold uppercase tracking-tight">
                    <span class="px-3 py-1 border border-gray-100 rounded-lg bg-white shadow-sm">Buka</span>
                    <span class="flex items-center gap-1.5">
                        <img src="{{ asset('image/ikon jam buka.png') }}" class="w-3.5 h-3.5 object-contain">
                        {{ $resto->jam_operasional ?? '08.00 - 21.00' }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <img src="{{ asset('image/ikon harga.png') }}" class="w-3.5 h-3.5 object-contain">
                        {{ $resto->range_harga ?? '25.000 - 50.000' }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <img src="{{ asset('image/ikon lokasi.png') }}" class="w-3.5 h-3.5 object-contain">
                        {{ $resto->alamat ? explode(',', $resto->alamat)[0] : 'Tembalang' }}
                    </span>
                </div>

                <p class="text-[10px] text-gray-400 mt-2.5 line-clamp-2 leading-relaxed font-semibold">
                    {{ $resto->deskripsi ?? 'Warung mie legendari dengan kuah kaldu sapi khas dan porsi jumbo. Berdiri sejak 2010, selalu ramai setiap hari.' }}
                </p>

                <div class="mt-3">
                    <span class="px-3 py-1 border border-gray-100 rounded-lg text-[9px] text-gray-400 font-bold uppercase tracking-widest bg-gray-50/50">
                        {{ $resto->category->nama_kategori ?? '-' }}
                    </span>
                </div>
            </div>
        </a>
    @empty
        <div class="py-20 text-center bg-white rounded-3xl border border-dashed border-gray-100">
            <div class="text-6xl mb-4 text-gray-200">🔍</div>
            <h3 class="text-xl font-bold text-gray-400">Restoran tidak ditemukan</h3>
            <p class="text-gray-300 text-sm">Coba gunakan kata kunci pencarian yang berbeda.</p>
        </div>
    @endforelse
</div>
