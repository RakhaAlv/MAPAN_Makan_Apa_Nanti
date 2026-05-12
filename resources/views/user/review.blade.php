<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Ulasan - {{ $restaurant->nama_restoran }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body{font-family:'Nunito',sans-serif;background:#FAF7F2;color:#1A1A1A}
        h1,h2,h3,h4,h5,h6{font-family:'Poppins',sans-serif}
        .navbar{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-bottom:1px solid rgba(232,83,26,.1);box-shadow:0 2px 12px rgba(0,0,0,.06)}
        .search-bar-nav{border:1.5px solid #E5E7EB;border-radius:50px;transition:all .2s}
        .search-bar-nav:focus-within{border-color:#E8531A;box-shadow:0 0 0 3px rgba(232,83,26,.12)}
        .info-card{background:white;border-radius:16px;border:1px solid #F3F4F6;box-shadow:0 1px 4px rgba(0,0,0,.04)}
        .btn-primary{background:linear-gradient(135deg,#E8531A,#C0421A);color:white;border-radius:12px;font-family:'Poppins',sans-serif;font-weight:600;transition:all .25s;box-shadow:0 4px 15px rgba(232,83,26,.35)}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(232,83,26,.45)}
        .btn-outline{border:1.5px solid #E5E7EB;border-radius:12px;font-family:'Poppins',sans-serif;font-weight:600;transition:all .2s;color:#4B5563;background:white}
        .btn-outline:hover{border-color:#E8531A;color:#E8531A;background:#FFF5F0}
        .input-field{border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 16px;width:100%;font-size:14px;transition:all .2s;outline:none;background:#FAFAFA}
        .input-field:focus{border-color:#E8531A;background:white;box-shadow:0 0 0 3px rgba(232,83,26,.1)}
        .upload-area{border:2px dashed #E5E7EB;border-radius:12px;background:#F9FAFB;transition:all .2s;cursor:pointer}
        .upload-area:hover{border-color:#E8531A;background:#FFF5F0}
        .footer{background:#1A1A1A;color:#D1D5DB}
        .footer a{color:#9CA3AF;transition:color .2s}
        .footer a:hover{color:#F47B45}
    </style>
</head>
<body>

@include('partials.navbar')

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-6">
        <h1 class="font-bold text-2xl">Tulis Ulasan Kamu!</h1>
        <p class="text-gray-500 text-sm mt-1">Berikan pengalaman kamu tentang restoran ini kepada pengguna lain!</p>
    </div>

    @if(session('success'))<div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="bg-red-50 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">{{ $errors->first() }}</div>@endif

    <div class="info-card overflow-hidden">
        {{-- Header Restoran --}}
        <div class="p-6 border-b border-gray-100 flex items-center gap-5">
            <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                @if($restaurant->gambar)
                    <img src="{{ asset('storage/'.$restaurant->gambar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-orange-50 to-orange-100 text-3xl">🍽️</div>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">{{ $restaurant->category->nama_kategori }}</p>
                <h2 class="font-bold text-lg mt-0.5 text-[#E8531A]">{{ $restaurant->nama_restoran }}</h2>
                <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                    <div class="flex items-center gap-1">
                        <span class="text-xs text-yellow-400">★</span>
                        <span class="text-xs font-bold text-yellow-500">{{ $restaurant->averageRating() }}</span>
                        <span class="text-[11px] text-gray-400">({{ $restaurant->reviews->count() }} ulasan)</span>
                    </div>
                    <span class="text-[11px] text-gray-500">📍 {{ $restaurant->alamat }}</span>
                </div>
            </div>
        </div>

        {{-- Form Ulasan --}}
        <form action="{{ route('reviews.store', $restaurant->id_restoran) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label class="font-bold text-sm text-gray-800 mb-2 block">Beri Rating<span class="text-red-500">*</span></label>
                <div class="flex gap-2" id="star-container">
                    @for($i=1;$i<=5;$i++)
                        <button type="button" class="star text-3xl text-gray-300 hover:text-yellow-400 transition" data-value="{{ $i }}">★</button>
                    @endfor
                </div>
                <p class="text-[11px] text-gray-400 mt-1">Pilih bintang untuk memberikan rating (1-5)</p>
                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
            </div>

            <div class="mb-6">
                <label class="font-bold text-sm text-gray-800 mb-2 block">Ulasan<span class="text-red-500">*</span></label>
                <textarea name="komentar" rows="4" class="input-field" placeholder="Ceritakan Pengalaman Anda">{{ old('komentar') }}</textarea>
                <p class="text-[11px] text-gray-400 mt-1 text-right">0/500</p>
            </div>

            <div class="mb-6">
                <label class="font-bold text-sm text-gray-800 mb-2 block">Foto <span class="font-normal text-gray-400">(Opsional)</span></label>
                <label class="upload-area flex flex-col items-center justify-center p-8 w-full text-center relative overflow-hidden">
                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="font-bold text-sm text-[#E8531A] block">Klik untuk unggah foto</span>
                    <span class="text-[11px] text-gray-500 mt-1 block">Format JPG, JPEG, PNG</span>
                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/jpg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(this)">
                    <img id="image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                </label>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('restaurant.show', $restaurant->id_restoran) }}" class="btn-outline px-6 py-2.5 text-sm rounded-lg">Batal</a>
                <button type="submit" class="btn-primary px-6 py-2.5 text-sm rounded-lg">Posting Ulasan</button>
            </div>
        </form>
    </div>

@include('partials.footer')

<script>
    // Rating Bintang
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-input');
    
    // Update tampilan bintang berdasarkan nilai yang dipilih
    function updateStars(value) {
        stars.forEach((s, i) => {
            if(i < value) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.add('text-gray-300');
                s.classList.remove('text-yellow-400');
            }
        });
    }

    if(stars.length) {
        stars.forEach(s => {
            s.addEventListener('click', () => {
                const value = parseInt(s.dataset.value);
                ratingInput.value = value;
                updateStars(value);
            });
            s.addEventListener('mouseover', () => {
                const value = parseInt(s.dataset.value);
                updateStars(value);
            });
            s.addEventListener('mouseout', () => {
                const value = parseInt(ratingInput.value) || 0;
                updateStars(value);
            });
        });
    }

    // Preview Foto
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.classList.add('hidden');
        }
    }
</script>
</body>
</html>
