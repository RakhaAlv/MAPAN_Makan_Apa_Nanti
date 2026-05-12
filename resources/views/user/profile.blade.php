<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - MAPAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background: #FAF7F2; color: #1A1A1A; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        .sidebar-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .content-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .nav-link { 
            padding: 12px 24px; 
            border-radius: 12px; 
            font-weight: 600; 
            font-size: 14px; 
            color: #4B5563; 
            transition: all 0.2s; 
            cursor: pointer;
            display: block;
            text-align: center;
        }
        .nav-link.active { 
            background: #FFE9D8; 
            color: #E8531A; 
            border: 1px solid #FFD4B8;
        }
        .nav-link:hover:not(.active) { background: #F3F4F6; }
        
        .input-field { 
            width: 100%; 
            padding: 12px 16px; 
            border: 1.5px solid #E5E7EB; 
            border-radius: 12px; 
            outline: none; 
            transition: all 0.2s; 
            font-size: 14px;
        }
        .input-field:focus { border-color: #E8531A; background: white; }
        .input-field:disabled { background: #F9FAFB; color: #9CA3AF; cursor: not-allowed; }
        
        .btn-primary { 
            background: #E8531A; 
            color: white; 
            padding: 12px 24px; 
            border-radius: 12px; 
            font-weight: 700; 
            font-size: 14px; 
            transition: all 0.2s;
        }
        .btn-primary:hover { background: #C0421A; }
        
        .btn-outline { 
            background: white; 
            color: #1A1A1A; 
            padding: 12px 24px; 
            border: 1.5px solid #E5E7EB; 
            border-radius: 12px; 
            font-weight: 700; 
            font-size: 14px; 
            transition: all 0.2s;
        }
        .btn-outline:hover { background: #F9FAFB; }

        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .review-card { 
            border: 1px solid #F3F4F6; 
            border-radius: 16px; 
            padding: 20px; 
            margin-bottom: 16px;
        }

        /* Navbar Styles */
        .navbar {
            position:sticky; top:0; z-index:50;
            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(10px);
            border-bottom:1px solid rgba(232,83,26,0.1);
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
        }
        .search-bar-nav { border:1.5px solid #E5E7EB; border-radius:50px; transition:all 0.2s; }
        .search-bar-nav:focus-within { border-color:#E8531A; box-shadow:0 0 0 3px rgba(232,83,26,0.12); }
    </style>
</head>
<body>

@include('partials.navbar')

    <main class="max-w-6xl mx-auto px-4 py-12">
        
        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-6 py-4 rounded-2xl mb-8 font-bold text-sm border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 text-red-600 px-6 py-4 rounded-2xl mb-8 font-bold text-sm border border-red-100">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8">
            
            {{-- Left Sidebar --}}
            <div class="md:w-80 shrink-0">
                <div class="sidebar-card overflow-hidden">
                    {{-- User Info Header --}}
                    <div class="p-8 text-center border-b border-gray-50">
                        <div class="relative w-24 h-24 mx-auto mb-4">
                            <div class="w-full h-full bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                            <button class="absolute bottom-0 right-0 w-8 h-8 bg-[#E8531A] text-white rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                        </div>
                        <div class="text-xs text-gray-400 font-bold mb-1">@ {{ $user->username }}</div>
                        <div class="font-bold text-gray-800">{{ $user->nama_pengguna }}</div>
                    </div>

                    {{-- Navigation --}}
                    <div class="p-6 space-y-2">
                        <div onclick="switchTab('profil-saya')" class="nav-link tab-btn active" data-tab="profil-saya">Profil Saya</div>
                        @if(Auth::user()->role === 'merchant')
                            <a href="{{ route('merchant.manage') }}" class="nav-link hover:text-[#E8531A]">Kelola Resto</a>
                        @endif
                        <div onclick="switchTab('riwayat-ulasan')" class="nav-link tab-btn" data-tab="riwayat-ulasan">Riwayat Ulasan</div>
                        <div onclick="switchTab('ubah-password')" class="nav-link tab-btn" data-tab="ubah-password">Ubah Password</div>
                    </div>

                    {{-- Logout --}}
                    <div class="p-6 border-t border-gray-50">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-center py-2 text-sm font-bold text-orange-500 hover:text-orange-600">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Content --}}
            <div class="flex-1">
                
                {{-- Profil Saya Content --}}
                <div id="profil-saya" class="tab-content active content-card p-10">
                    <h2 class="text-xl font-bold text-orange-600 mb-8">Profil Saya</h2>
                    <form action="{{ Auth::user()->role === 'merchant' ? route('merchant.profile.update') : route('user.profile.update') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap<span class="text-red-500">*</span></label>
                                <input type="text" name="nama_pengguna" value="{{ $user->nama_pengguna }}" class="input-field" placeholder="Masukkan nama lengkap">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Username<span class="text-red-500">*</span></label>
                                <input type="text" name="username" value="{{ $user->username }}" class="input-field" placeholder="Masukkan Username">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Tipe Akun<span class="text-red-500">*</span></label>
                                <input type="text" value="{{ ucfirst($user->role) }}" disabled class="input-field">
                            </div>
                        </div>
                        <div class="mt-12 flex justify-end gap-3">
                            <button type="button" class="btn-outline">Batal</button>
                            <button type="submit" class="btn-primary shadow-lg shadow-orange-100">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                {{-- Riwayat Ulasan Content --}}
                <div id="riwayat-ulasan" class="tab-content content-card p-10">
                    <h2 class="text-xl font-bold text-orange-600 mb-8">Riwayat Ulasan</h2>
                    <div class="space-y-6">
                        @forelse($reviews as $review)
                            <div class="review-card">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 font-bold">
                                        {{ strtoupper(substr(Auth::user()->role === 'user' ? ($review->restaurant->nama_restoran ?? 'R') : $review->user->nama_pengguna, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-800">
                                            @if(Auth::user()->role === 'user')
                                                {{ $review->restaurant->nama_restoran ?? 'Restoran Terhapus' }}
                                            @else
                                                {{ $review->user->nama_pengguna }}
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <div class="flex">
                                                @for($i=1;$i<=5;$i++)
                                                    <span class="text-[10px] {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                                @endfor
                                            </div>
                                            <span class="text-xs font-bold text-gray-800">{{ number_format($review->rating, 1) }}</span>
                                            <span class="text-[10px] text-gray-400">• {{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed italic">"{{ $review->komentar }}"</p>
                                @if($review->gambar)
                                    <div class="mt-4 w-24 h-24 rounded-lg overflow-hidden border border-gray-100">
                                        <img src="{{ asset('storage/'.$review->gambar) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="text-gray-300 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <p class="text-gray-400 font-bold">Belum ada riwayat ulasan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Ubah Password Content --}}
                <div id="ubah-password" class="tab-content content-card p-10">
                    <h2 class="text-xl font-bold text-orange-600 mb-8">Ubah Password</h2>
                    <form action="{{ Auth::user()->role === 'merchant' ? route('merchant.profile.password') : route('user.profile.password') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password Saat ini<span class="text-red-500">*</span></label>
                                <input type="password" name="current_password" required class="input-field" placeholder="Masukkan Password">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru<span class="text-red-500">*</span></label>
                                <input type="password" name="password" required class="input-field" placeholder="Masukkan Password Baru">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru<span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" required class="input-field" placeholder="Masukkan Password">
                            </div>
                        </div>
                        <div class="mt-12 flex justify-end gap-3">
                            <button type="button" class="btn-outline">Batal</button>
                            <button type="submit" class="btn-primary shadow-lg shadow-orange-100">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </main>

    @include('partials.footer')

    {{-- Skrip JavaScript untuk fungsionalitas Tab --}}
    <script>
        /**
         * Fungsi untuk berpindah tab tanpa reload halaman.
         * @param {string} tabId - ID dari elemen konten tab yang ingin ditampilkan.
         */
        function switchTab(tabId) {
            // Sembunyikan semua konten tab terlebih dahulu
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            // Hapus status 'active' dari semua tombol navigasi
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Tampilkan konten tab yang dipilih
            document.getElementById(tabId).classList.add('active');
            // Set tombol navigasi yang dipilih menjadi aktif
            document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');

            // Simpan ID tab ke URL hash agar jika di-refresh tetap di tab yang sama
            window.location.hash = tabId;
        }

        // Cek hash di URL saat halaman dimuat pertama kali
        document.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById(hash)) {
                switchTab(hash);
            }
        });
    </script>
</body>
</html>
