<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MAPAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <h1 class="text-xl font-bold text-orange-500">MAPAN</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Halo, {{ Auth::user()->nama_pengguna }}!</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-sm text-red-500 hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Pencarian & Filter --}}
        <form action="{{ route('user.dashboard') }}" method="GET" class="flex gap-3 mb-8 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari restoran..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 min-w-[200px]">

            <select name="category"
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                Cari
            </button>

            @if (request('search') || request('category'))
                <a href="{{ route('user.dashboard') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Reset
                </a>
            @endif
        </form>

        {{-- Rekomendasi (hanya tampil jika tidak ada pencarian) --}}
        @if (!request('search') && !request('category'))
            <section class="mb-10">
                <h2 class="text-lg font-bold text-gray-800 mb-4">⭐ Rekomendasi Restoran</h2>
                @if ($rekomendasi->isEmpty())
                    <p class="text-gray-400 text-sm">Belum ada restoran.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($rekomendasi as $resto)
                            <a href="{{ route('restaurant.show', $resto->id) }}"
                                class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
                                @if ($resto->gambar)
                                    <img src="{{ Storage::url($resto->gambar) }}"
                                        alt="{{ $resto->nama_restoran }}"
                                        class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-orange-100 flex items-center justify-center text-4xl">🍽️</div>
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800">{{ $resto->nama_restoran }}</h3>
                                    <p class="text-xs text-gray-400 mt-1">{{ $resto->category->nama_kategori }}</p>
                                    <div class="flex items-center gap-1 mt-2">
                                        <span class="text-yellow-400 text-sm">★</span>
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ number_format($resto->reviews_avg_rating ?? 0, 1) }}
                                        </span>
                                        <span class="text-xs text-gray-400">({{ $resto->reviews->count() }} review)</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif

        {{-- Semua Restoran --}}
        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-4">
                {{ request('search') || request('category') ? 'Hasil Pencarian' : '🍴 Semua Restoran' }}
            </h2>

            @if ($restaurants->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <div class="text-5xl mb-3">🔍</div>
                    <p>Restoran tidak ditemukan.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($restaurants as $resto)
                        <a href="{{ route('restaurant.show', $resto->id) }}"
                            class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
                            @if ($resto->gambar)
                                <img src="{{ Storage::url($resto->gambar) }}"
                                    alt="{{ $resto->nama_restoran }}"
                                    class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-orange-100 flex items-center justify-center text-4xl">🍽️</div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800">{{ $resto->nama_restoran }}</h3>
                                <p class="text-xs text-orange-400 mt-1">{{ $resto->category->nama_kategori }}</p>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $resto->alamat }}</p>
                                <div class="flex items-center gap-1 mt-2">
                                    <span class="text-yellow-400 text-sm">★</span>
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ number_format($resto->averageRating(), 1) }}
                                    </span>
                                    <span class="text-xs text-gray-400">({{ $resto->reviews->count() }} review)</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

</body>
</html>