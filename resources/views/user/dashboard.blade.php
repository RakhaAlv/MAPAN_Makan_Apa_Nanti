<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Restoran - MAPAN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; background: #FAF7F2; color: #1A1A1A; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        .navbar { position: sticky; top: 0; z-index: 50; background: white; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .search-bar-nav { border: 1.5px solid #E5E7EB; border-radius: 50px; transition: all .2s; }
        .search-bar-nav:focus-within { border-color: #E8531A; box-shadow: 0 0 0 3px rgba(232,83,26,0.1); }
        .category-chip {
            background: white; border: 1.5px solid #E5E7EB; border-radius: 50px;
            color: #1A1A1A; transition: all 0.2s; font-family: 'Poppins', sans-serif;
            cursor: pointer; white-space: nowrap; padding: 10px 24px;
            font-weight: 600;
        }
        .category-chip:hover, .category-chip.active {
            background: #2D231E; border-color: #2D231E; color: white;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@include('partials.navbar')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Header Content --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            @if(request('category'))
                {{ $categories->find(request('category'))->nama_kategori ?? 'Semua Restoran' }}
            @else
                Semua Restoran
            @endif
        </h1>
        <p class="text-sm text-gray-400 mt-1">Menampilkan semua restoran di Kota Semarang</p>
    </div>

    {{-- Category Chips --}}
    <div class="flex gap-3 overflow-x-auto pb-6 no-scrollbar">
        <button onclick="window.location.href='{{ route('user.search') }}'" 
                class="category-chip px-6 py-2 text-xs {{ !request('category') ? 'active' : '' }}">
            Semua
        </button>
        @foreach($categories as $cat)
            <button onclick="window.location.href='{{ route('user.search', ['category' => $cat->id]) }}'"
                    class="category-chip px-6 py-2 text-xs {{ request('category') == $cat->id ? 'active' : '' }}">
                {{ $cat->nama_kategori }}
            </button>
        @endforeach

    </div>

    {{-- Vertical Results List --}}
    <div id="search-results" class="max-w-4xl">
        @include('partials.restaurant_list_vertical', ['restaurants' => $restaurants])
    </div>
</main>

@include('partials.footer')

</body>
</html>
