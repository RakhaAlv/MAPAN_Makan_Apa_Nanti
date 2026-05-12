<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse($restaurants as $resto)
        <a href="{{ route('restaurant.show', $resto->id_restoran) }}" class="group block relative bg-white rounded-[24px] overflow-hidden shadow-xl shadow-orange-100/20 transition-all hover:-translate-y-2">
            {{-- Image --}}
            <div class="aspect-video w-full bg-gray-100 relative overflow-hidden">
                @if($resto->gambar)
                    <img src="{{ asset('storage/'.$resto->gambar) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl">🍽️</div>
                @endif
                <div class="absolute top-3 left-3">
                    <span class="bg-[#E8531A] text-white text-[9px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-widest shadow-lg">★ Top</span>
                </div>
            </div>

            {{-- Info Banner (Orange) --}}
            <div class="bg-[#E8531A] p-4 text-white">
                <h3 class="font-extrabold text-base truncate mb-0.5">{{ $resto->nama_restoran }}</h3>
                <p class="text-[10px] opacity-80 font-bold mb-3">{{ $resto->category->nama_kategori ?? '-' }}</p>
                
                <div class="flex items-center justify-between border-t border-white/20 pt-3">
                    <div class="flex items-center gap-1.5">
                        <div class="flex text-yellow-300">
                            @for($i=1; $i<=5; $i++)
                                <span class="text-[10px] {{ $i <= round($resto->averageRating()) ? 'text-yellow-300' : 'text-white/30' }}">★</span>
                            @endfor
                        </div>
                        <span class="font-black text-xs">{{ number_format($resto->averageRating(), 1) }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[10px] font-bold opacity-90">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ $resto->reviews->count() }} ulasan</span>
                    </div>
                </div>

                {{-- Hover Extra Info --}}
                <div class="mt-3 text-[9px] font-black uppercase tracking-tight opacity-70 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-1.5 truncate">
                        <img src="{{ asset('image/ikon jam buka.png') }}" class="w-3 h-3 object-contain brightness-0 invert">
                        <span>{{ $resto->jam_operasional ?? '08.00 - 21.00' }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <img src="{{ asset('image/ikon harga.png') }}" class="w-3 h-3 object-contain brightness-0 invert">
                        <span>{{ $resto->range_harga ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
            <div class="text-6xl mb-4">🍽️</div>
            <p class="text-gray-400 font-bold">Tidak ada restoran di kategori ini.</p>
        </div>
    @endforelse
</div>
