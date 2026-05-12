<footer class="bg-[#2D231E] py-16 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 text-white">
            {{-- Logo Section --}}
            <div class="flex flex-col items-center md:items-start">
                <div class="bg-white p-3 rounded-lg inline-block mb-6 shadow-xl shadow-orange-900/20">
                    <img src="{{ asset('image/logo mapan.png') }}" class="h-10">
                </div>
            </div>

            {{-- Jelajahi --}}
            <div class="text-center md:text-left">
                <h4 class="font-bold text-lg mb-6">Jelajahi</h4>
                <ul class="space-y-3 text-sm opacity-90">
                    <li><a href="{{ route('user.search') }}" class="hover:underline">Semua Restoran</a></li>
                    <li><a href="{{ route('home') }}#top-rating-section" class="hover:underline">Top Rating</a></li>
                    <li><a href="{{ route('home') }}#maps" class="hover:underline">Maps</a></li>
                </ul>
            </div>

            {{-- Kategori --}}
            <div class="text-center md:text-left">
                <h4 class="font-bold text-lg mb-6">Kategori</h4>
                <ul class="space-y-3 text-sm opacity-90">
                    <li><a href="{{ route('home', ['show_all' => 1]) }}" class="hover:underline">Semua</a></li>
                    <li><a href="{{ route('home', ['category' => 1]) }}" class="hover:underline">Mie</a></li>
                    <li><a href="{{ route('home', ['category' => 2]) }}" class="hover:underline">Ayam</a></li>
                </ul>
            </div>

            {{-- Merchant --}}
            <div class="text-center md:text-left">
                <h4 class="font-bold text-lg mb-6">Merchant</h4>
                <ul class="space-y-3 text-sm opacity-90">
                    <li><a href="{{ route('register.form', ['role' => 'merchant']) }}" class="hover:underline">Daftarkan Restoran</a></li>
                    <li><a href="{{ route('login') }}" class="hover:underline">Login Merchant</a></li>
                    <li><a href="#" class="hover:underline">Panduan</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
