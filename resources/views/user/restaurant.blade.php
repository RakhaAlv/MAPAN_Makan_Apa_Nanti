<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->nama_restoran }} - MAPAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('user.dashboard') }}" class="text-orange-500 font-bold text-xl">MAPAN</a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ Auth::user()->nama_pengguna }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-sm text-red-500 hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 py-8">

        {{-- Tombol kembali --}}
        <a href="{{ route('user.dashboard') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-orange-500 mb-6">
            ← Kembali
        </a>

        {{-- Info Restoran --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">
            @if ($restaurant->gambar)
                <img src="{{ Storage::url($restaurant->gambar) }}"
                    alt="{{ $restaurant->nama_restoran }}"
                    class="w-full h-56 object-cover">
            @else
                <div class="w-full h-56 bg-orange-100 flex items-center justify-center text-6xl">🍽️</div>
            @endif

            <div class="p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $restaurant->nama_restoran }}</h1>
                        <span class="inline-block mt-1 text-xs bg-orange-100 text-orange-600 px-3 py-1 rounded-full font-medium">
                            {{ $restaurant->category->nama_kategori }}
                        </span>
                    </div>
                    <div class="text-center bg-orange-50 rounded-xl px-4 py-2 shrink-0">
                        <div class="text-2xl font-bold text-orange-500">
                            {{ number_format($restaurant->averageRating(), 1) }}
                        </div>
                        <div class="text-yellow-400 text-sm">★★★★★</div>
                        <div class="text-xs text-gray-400">{{ $restaurant->reviews->count() }} review</div>
                    </div>
                </div>

                @if ($restaurant->deskripsi)
                    <p class="text-gray-600 text-sm mt-4">{{ $restaurant->deskripsi }}</p>
                @endif

                <div class="mt-4 space-y-2 text-sm text-gray-600">
                    <div class="flex gap-2">
                        <span>📍</span>
                        <span>{{ $restaurant->alamat }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span>📞</span>
                        <span>{{ $restaurant->kontak }}</span>
                    </div>
                    @if ($restaurant->gmaps_link)
                        <div class="flex gap-2">
                            <span>🗺️</span>
                            <a href="{{ $restaurant->gmaps_link }}" target="_blank"
                                class="text-blue-500 hover:underline">
                                Lihat di Google Maps
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Form Review --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Tulis Review</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($sudahReview)
                <p class="text-gray-400 text-sm bg-gray-50 px-4 py-3 rounded-lg">
                    Kamu sudah memberikan review untuk restoran ini.
                </p>
            @else
                <form action="{{ route('reviews.store', $restaurant->id) }}" method="POST">
                    @csrf

                    {{-- Pilih Bintang --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex gap-2" id="star-container">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button"
                                    class="star text-3xl text-gray-300 hover:text-yellow-400 transition"
                                    data-value="{{ $i }}">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                    </div>

                    {{-- Komentar --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Komentar <span class="text-gray-400">(opsional)</span>
                        </label>
                        <textarea name="komentar" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                            placeholder="Ceritakan pengalamanmu...">{{ old('komentar') }}</textarea>
                    </div>

                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                        Kirim Review
                    </button>
                </form>
            @endif
        </div>

        {{-- Daftar Review --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">
                Review ({{ $restaurant->reviews->count() }})
            </h2>

            @if ($restaurant->reviews->isEmpty())
                <p class="text-gray-400 text-sm">Belum ada review. Jadilah yang pertama!</p>
            @else
                <div class="space-y-4">
                    @foreach ($restaurant->reviews as $review)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center text-sm font-bold text-orange-500">
                                        {{ strtoupper(substr($review->user->nama_pengguna, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">{{ $review->user->nama_pengguna }}</p>
                                        <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }} text-sm">★</span>
                                    @endfor
                                </div>
                            </div>
                            @if ($review->komentar)
                                <p class="text-sm text-gray-600 mt-2 ml-10">{{ $review->komentar }}</p>
                            @endif

                            {{-- Tombol hapus jika milik user yang login --}}
                            @if ($review->user_id === Auth::id())
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                    class="ml-10 mt-2"
                                    onsubmit="return confirm('Hapus review ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-red-400 hover:underline">Hapus review</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Script bintang interaktif --}}
    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const val = parseInt(star.dataset.value);
                ratingInput.value = val;
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-400', i < val);
                    s.classList.toggle('text-gray-300', i >= val);
                });
            });

            star.addEventListener('mouseover', () => {
                const val = parseInt(star.dataset.value);
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-400', i < val);
                    s.classList.toggle('text-gray-300', i >= val);
                });
            });

            star.addEventListener('mouseout', () => {
                const val = parseInt(ratingInput.value) || 0;
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-400', i < val);
                    s.classList.toggle('text-gray-300', i >= val);
                });
            });
        });
    </script>

</body>
</html>