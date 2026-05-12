<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Restoran - MAPAN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family:'Nunito',sans-serif; }
        h1,h2,h3,h4 { font-family:'Poppins',sans-serif; }

        .auth-bg {
            background-color: #FAF7F2;
            min-height:100vh; position:relative; overflow:hidden;
            padding: 40px 16px;
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
            transition:all 0.2s; outline:none; background:#FAFAFA;
        }
        .input-field:focus { border-color:#E8531A; background:white; box-shadow:0 0 0 3px rgba(232,83,26,0.1); }

        .btn-submit {
            background:linear-gradient(135deg,#E8531A 0%,#C0421A 100%);
            color:white; border-radius:12px; padding:12px 24px;
            font-weight:600; font-size:15px;
            transition:all 0.25s; box-shadow:0 4px 15px rgba(232,83,26,0.35);
            border:none; cursor:pointer;
        }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(232,83,26,0.45); }
    </style>
</head>
<body class="bg-[#FAF7F2]">

@include('partials.navbar')

<div class="auth-bg">
    <div class="auth-card">
        <div class="text-center mb-10">
            <div class="mb-4">
                <img src="{{ asset('image/simbol mapan.png') }}" class="h-16 mx-auto" alt="Logo">
            </div>
            <h1 class="text-3xl font-bold text-[#E8531A] mb-1">Daftarkan Restoran</h1>
            <p class="text-gray-400 text-sm">Lengkapi data untuk mulai mengelola restoran kamu</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('merchant.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Restoran<span class="text-red-500">*</span></label>
                    <input type="text" name="nama_restoran" value="{{ old('nama_restoran') }}" class="input-field" placeholder="Nama restoran kamu" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori Makanan<span class="text-red-500">*</span></label>
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
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Restoran</label>
                <textarea name="deskripsi" rows="3" class="input-field resize-none" placeholder="Ceritakan tentang restoran kamu">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap<span class="text-red-500">*</span></label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" class="input-field" placeholder="Masukkan alamat lengkap" required>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hari Operasional<span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="hari_operasional[]" value="{{ $hari }}" class="hidden peer" {{ in_array($hari, old('hari_operasional', [])) ? 'checked' : '' }}>
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
                    <div class="flex items-center gap-2">
                        <input type="time" name="jam_buka" value="{{ old('jam_buka', '08:00') }}" class="input-field" required>
                        <span class="text-gray-400">-</span>
                        <input type="time" name="jam_tutup" value="{{ old('jam_tutup', '21:00') }}" class="input-field" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Range Harga (Rp)<span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="harga_min" value="{{ old('harga_min') }}" class="input-field" placeholder="Min" required>
                        <span class="text-gray-400">-</span>
                        <input type="number" name="harga_max" value="{{ old('harga_max') }}" class="input-field" placeholder="Max" required>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Kontak<span class="text-red-500">*</span></label>
                    <input type="text" name="kontak" value="{{ old('kontak') }}" class="input-field" placeholder="08xxxxxxxxxx" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Link Google Maps</label>
                    <input type="url" name="gmaps_link" value="{{ old('gmaps_link') }}" class="input-field" placeholder="https://maps.app.goo.gl/...">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Restoran</label>
                <input type="file" name="gambar" accept="image/*" class="input-field">
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-submit w-full md:w-auto">Daftarkan Sekarang</button>
            </div>
        </form>
    </div>
</div>

@include('partials.footer')

</body>
</html>
