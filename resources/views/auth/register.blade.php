<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - MAPAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background: #FAF7F2; color: #1A1A1A; min-height: 100vh; padding: 40px 16px; display: flex; align-items: center; justify-content: center; }
        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }
        
        .auth-card { background: white; border-radius: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); padding: 48px; width: 100%; max-width: 650px; }
        .input-field { width: 100%; padding: 12px 18px; border: 1.5px solid #E5E7EB; border-radius: 14px; outline: none; transition: all 0.2s; font-size: 14px; background: #FAFAFA; font-weight: 500; }
        .input-field:focus { border-color: #E8531A; background: white; box-shadow: 0 0 0 4px rgba(232,83,26,0.08); }
        
        .btn-submit { background: linear-gradient(135deg, #E8531A 0%, #C0421A 100%); color: white; border-radius: 14px; padding: 16px; width: 100%; font-weight: 700; transition: all 0.25s; margin-top: 24px; box-shadow: 0 6px 20px rgba(232,83,26,0.25); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(232,83,26,0.35); }
        
        .section-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #E8531A; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .section-title::after { content: ""; flex: 1; height: 1px; background: #F3F4F6; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="text-center mb-10">
        <div class="mb-4">
            <img src="{{ asset('image/simbol mapan.png') }}" class="h-14 mx-auto" alt="Logo">
        </div>
        <h1 class="text-3xl font-black text-gray-800 mb-1">Sign Up</h1>
        <p class="text-gray-400 text-sm font-medium">Lengkapi data akun <span class="text-[#E8531A] font-bold">{{ ucfirst($role) }}</span> Anda</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-8 text-sm border border-red-100 font-bold">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">

        <div class="space-y-6">
            {{-- Account Information --}}
            <div>
                <div class="section-title">Informasi Akun</div>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Nama Lengkap<span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna') }}" class="input-field" placeholder="Masukkan nama" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Username<span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" class="input-field" placeholder="username" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Email<span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="email@contoh.com" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Password<span class="text-red-500">*</span></label>
                            <input type="password" name="password" class="input-field" placeholder="Min. 6 karakter" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Konfirmasi Password<span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" class="input-field" placeholder="Ulangi password" required>
                        </div>
                    </div>
                </div>
            </div>

            @if($role === 'merchant')
                {{-- Merchant / Restaurant Information --}}
                <div class="pt-4">
                    <div class="section-title">Informasi Restoran</div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Nama Restoran<span class="text-red-500">*</span></label>
                                <input type="text" name="nama_restoran" value="{{ old('nama_restoran') }}" class="input-field" placeholder="Nama bisnis" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Kategori<span class="text-red-500">*</span></label>
                                <select name="category_id" class="input-field" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Alamat Lengkap<span class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="2" class="input-field resize-none" placeholder="Masukkan alamat lengkap restoran" required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">No. Kontak<span class="text-red-500">*</span></label>
                                <input type="text" name="kontak" value="{{ old('kontak') }}" class="input-field" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Link Google Maps<span class="text-red-500">*</span></label>
                                <input type="url" name="gmaps_link" value="{{ old('gmaps_link') }}" class="input-field" placeholder="https://maps.app.goo.gl/..." required>
                            </div>
                        </div>
                        
                        {{-- Hidden defaults to keep form simple but valid --}}
                        <input type="hidden" name="hari_operasional[]" value="Senin">
                        <input type="hidden" name="hari_operasional[]" value="Selasa">
                        <input type="hidden" name="hari_operasional[]" value="Rabu">
                        <input type="hidden" name="hari_operasional[]" value="Kamis">
                        <input type="hidden" name="hari_operasional[]" value="Jumat">
                        <input type="hidden" name="jam_buka" value="09:00">
                        <input type="hidden" name="jam_tutup" value="21:00">
                        <input type="hidden" name="harga_min" value="10000">
                        <input type="hidden" name="harga_max" value="100000">
                    </div>
                </div>
            @endif
        </div>

        <button type="submit" class="btn-submit">Sign Up Sekarang</button>
        
        <p class="text-center text-sm text-gray-400 mt-8 font-medium">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#E8531A] font-extrabold hover:underline">Masuk disini</a>
        </p>
    </form>
</div>

</body>
</html>
