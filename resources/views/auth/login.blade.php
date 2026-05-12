<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MAPAN</title>
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
            display: flex; align-items: center; justify-content: center; p-4;
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
            width: 100%; max-width: 600px;
            position: relative; z-index: 10;
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
            color:white; border-radius:12px; padding:12px; width:100%;
            font-family:'Poppins',sans-serif; font-weight:600; font-size:15px;
            transition:all 0.25s; box-shadow:0 4px 15px rgba(232,83,26,0.35);
            border:none; cursor:pointer;
        }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(232,83,26,0.45); }
    </style>
</head>
<body>
<div class="auth-bg">
    {{-- Background Decoration --}}
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-20">
        <div class="absolute top-10 left-10 text-6xl">🍕</div>
        <div class="absolute top-20 right-20 text-5xl">🍔</div>
        <div class="absolute bottom-20 left-20 text-5xl">🍣</div>
        <div class="absolute bottom-10 right-10 text-6xl">🍦</div>
    </div>

    <div class="auth-card mx-auto">
        {{-- Logo & heading --}}
        <div class="text-center mb-8">
            <div class="mb-4">
                <img src="{{ asset('image/simbol mapan.png') }}" class="h-16 mx-auto" alt="Logo">
            </div>
            <h1 class="text-3xl font-bold text-[#E8531A] mb-1">Welcome Back!</h1>
            <p class="text-gray-400 text-sm">Masuk ke akun MAPAN kamu</p>
        </div>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert error --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username<span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="input-field" placeholder="Masukkan username" required autofocus>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password<span class="text-red-500">*</span></label>
                <input type="password" name="password" id="pw-input"
                       class="input-field" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-10">
            Belum punya akun?
            <a href="{{ route('register.select') }}" class="text-[#E8531A] font-bold hover:underline">Daftar Sekarang</a>
        </p>
    </div>
</div>
</body>
</html>
