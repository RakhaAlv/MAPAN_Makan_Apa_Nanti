<nav class="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">

            {{-- Logo MAPAN --}}
            <a href="/" class="flex items-center gap-2 shrink-0">
                <img src="{{ asset('image/logo mapan.png') }}" alt="MAPAN" class="h-10">
            </a>

            {{-- Search bar (tersembunyi di layar kecil) --}}
            <div class="flex-1 max-w-md hidden sm:block">
                <form action="{{ route('user.search') }}" method="GET" class="search-bar-nav flex items-center bg-gray-50 px-4 py-2">
                    <button type="submit" class="flex shrink-0">
                        <svg class="w-4 h-4 text-gray-400 mr-2 shrink-0 hover:text-[#E8531A] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari restoran..."
                           class="bg-transparent text-sm flex-1 outline-none text-gray-700 placeholder-gray-400">
                </form>
            </div>

            {{-- Link navigasi + tombol auth --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-400 hover:text-[#E8531A]">Dashboard</a>
                <a href="{{ route('home') }}#top-rating-section" class="text-sm font-semibold text-gray-400 hover:text-[#E8531A]">Top Rating</a>
                <a href="{{ route('home') }}#maps" class="text-sm font-semibold text-gray-400 hover:text-[#E8531A]">Maps</a>
                
                @guest
                    <a href="{{ route('register.select') }}" class="px-6 py-2 text-sm font-semibold text-[#E8531A] border-2 border-[#E8531A] rounded-full hover:bg-[#E8531A] hover:text-white transition-all">Sign Up</a>
                @else
                    <div class="flex items-center gap-3">
                        @php
                            $profileRoute = Auth::user()->role === 'merchant' ? route('merchant.profile') : route('user.profile');
                        @endphp
                        <a href="{{ $profileRoute }}" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center border-2 border-white shadow-sm overflow-hidden hover:border-[#E8531A] transition-all">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-[#2D231E] rounded-full hover:bg-black transition-all">Logout</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<style>
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
</style>
