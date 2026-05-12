<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restoran - MAPAN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family:'Nunito',sans-serif; }
        h1,h2,h3,h4 { font-family:'Poppins',sans-serif; }

        .auth-bg {
            background-color: #FAF7F2;
            background-image: radial-gradient(#E8531A 0.5px, transparent 0.5px), radial-gradient(#E8531A 0.5px, #FAF7F2 0.5px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
            min-height:100vh; position:relative; overflow:hidden;
            padding: 40px 16px;
        }
        .auth-bg::before {
            content: ""; position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 57c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23e8531a' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .auth-card {
            background:white; border-radius:48px;
            box-shadow:0 15px 50px rgba(0,0,0,0.05);
            padding: 60px 40px;
            width: 100%; max-width: 800px;
            position: relative; z-index: 10;
            margin: 0 auto;
        }

        .input-field {
            border:1.5px solid #E5E7EB; border-radius:12px;
            padding:10px 16px; width:100%; font-size:14px;
            font-family:'Nunito',sans-serif; color:#1A1A1A;
            transition:all 0.2s; outline:none; background:#FAFAFA;
        }
        .input-field:focus { border-color:#E8531A; background:white; box-shadow:0 0 0 3px rgba(232,83,26,0.1); }

        .btn-submit {
            background:linear-gradient(135deg,#E8531A 0%,#C0421A 100%);
            color:white; border-radius:12px; padding:12px 24px;
            font-family:'Poppins',sans-serif; font-weight:600; font-size:15px;
            transition:all 0.25s; box-shadow:0 4px 15px rgba(232,83,26,0.35);
            border:none; cursor:pointer;
        }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(232,83,26,0.45); }
        
        .navbar {
            background:white; border-bottom:1px solid rgba(0,0,0,0.05);
            position: sticky; top: 0; z-index: 100;
        }

        .upload-area {
            border: 2px dashed #E5E7EB;
            border-radius: 12px;
            background: #F9FAFB;
            transition: all .2s;
            cursor: pointer;
        }
        .upload-area:hover {
            border-color: #E8531A;
            background: #FFF5F0;
        }
    </style>
</head>
<body class="bg-[#FAF7F2]">

@include('partials.navbar')

<div class="auth-bg">
    {{-- Background Decoration --}}
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-20">
        <div class="absolute top-10 left-10 text-6xl">🍕</div>
        <div class="absolute top-20 right-20 text-5xl">🍔</div>
        <div class="absolute bottom-20 left-20 text-5xl">🍣</div>
        <div class="absolute bottom-10 right-10 text-6xl">🍦</div>
    </div>

    <div class="auth-card">
        {{-- Logo & heading --}}
        <div class="text-center mb-10">
            <div class="mb-4">
                <img src="{{ asset('image/simbol mapan.png') }}" class="h-16 mx-auto" alt="Logo">
            </div>
            <h1 class="text-3xl font-bold text-[#E8531A] mb-1">Edit Restoran</h1>
            <p class="text-gray-400 text-sm">Perbarui informasi restoran kamu</p>
        </div>

        {{-- Success/Error Alerts --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('merchant.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Restoran<span class="text-red-500">*</span></label>
                    <input type="text" name="nama_restoran" value="{{ $restaurant->nama_restoran }}"
                           class="input-field" placeholder="Masukkan nama restoran" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori Makanan<span class="text-red-500">*</span></label>
                    <select name="category_id" class="input-field" required>
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ($restaurant->category_id == $category->id) ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Restoran</label>
                <textarea name="deskripsi" rows="3" class="input-field resize-none"
                          placeholder="Ceritakan tentang restoran kamu">{{ $restaurant->deskripsi }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap<span class="text-red-500">*</span></label>
                <input type="text" name="alamat" value="{{ $restaurant->alamat }}"
                       class="input-field" placeholder="Masukkan alamat lengkap" required>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hari Operasional<span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $selectedDays = is_array($restaurant->hari_operasional) 
                                ? $restaurant->hari_operasional 
                                : explode(', ', $restaurant->hari_operasional ?? '');
                        @endphp
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="hari_operasional[]" value="{{ $hari }}" class="hidden peer" {{ in_array($hari, $selectedDays) ? 'checked' : '' }}>
                                <span class="px-3 py-1.5 text-xs font-medium border-1.5 border-gray-200 rounded-lg peer-checked:border-[#E8531A] peer-checked:bg-[#FFF5F0] peer-checked:text-[#E8531A] transition-all block text-center min-w-[70px]">
                                    {{ $hari }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Operasional<span class="text-red-500">*</span></label>
                    @php
                        $jam = explode(' - ', $restaurant->jam_operasional ?? '08:00 - 21:00');
                        $buka = $jam[0] ?? '08:00';
                        $tutup = $jam[1] ?? '21:00';
                    @endphp
                    <div class="flex items-center gap-2">
                        <input type="time" name="jam_buka" value="{{ $buka }}" class="input-field" required>
                        <span class="text-gray-400">-</span>
                        <input type="time" name="jam_tutup" value="{{ $tutup }}" class="input-field" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Range Harga (Rp)<span class="text-red-500">*</span></label>
                    @php
                        $harga = explode(' - ', $restaurant->range_harga ?? '0 - 0');
                        $min = $harga[0] ?? '';
                        $max = $harga[1] ?? '';
                    @endphp
                    <div class="flex items-center gap-2">
                        <input type="number" name="harga_min" value="{{ $min }}" class="input-field" placeholder="Min" required>
                        <span class="text-gray-400">-</span>
                        <input type="number" name="harga_max" value="{{ $max }}" class="input-field" placeholder="Max" required>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Kontak<span class="text-red-500">*</span></label>
                    <input type="text" name="kontak" value="{{ $restaurant->kontak }}"
                           class="input-field" placeholder="Masukkan nomor aktif" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Link Google Maps</label>
                    <input type="url" name="gmaps_link" value="{{ $restaurant->gmaps_link }}"
                           class="input-field" placeholder="Masukkan link maps">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2">Update Gambar Restoran</label>
                <label class="upload-area flex flex-col items-center justify-center p-8 w-full text-center relative overflow-hidden min-h-[200px]">
                    <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="font-bold text-sm text-[#E8531A] block">Klik untuk ganti foto restoran</span>
                    <span class="text-[11px] text-gray-500 mt-1 block">Format JPG, JPEG, PNG (Maks. 2MB)</span>
                    
                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/jpg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(this)">
                    
                    <img id="image-preview" src="{{ $restaurant->gambar ? asset('storage/'.$restaurant->gambar) : '' }}" 
                         class="absolute inset-0 w-full h-full object-cover {{ $restaurant->gambar ? '' : 'hidden' }}">
                    
                    <div id="preview-overlay" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity {{ $restaurant->gambar ? '' : 'hidden' }}">
                        <span class="text-white text-xs font-bold bg-[#E8531A] px-3 py-1.5 rounded-full">Ganti Foto</span>
                    </div>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-submit w-full md:w-auto">Simpan Perubahan</button>
                <a href="{{ route('restaurant.show', $restaurant->id_restoran) }}" class="inline-block mt-4 md:mt-0 md:ml-4 text-sm font-bold text-gray-400 hover:text-gray-600">Batal</a>
            </div>
        </form>
    </div>
</div>

@include('partials.footer')

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const overlay = document.getElementById('preview-overlay');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(overlay) overlay.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
