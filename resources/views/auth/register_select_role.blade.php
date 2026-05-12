<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Peran - MAPAN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family:'Nunito',sans-serif; 
            background: #FAF7F2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        h1,h2,h3,h4 { font-family:'Poppins',sans-serif; }

        .auth-card {
            background: white;
            border-radius: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.05);
            padding: 60px 48px;
            width: 100%;
            max-width: 750px;
            text-align: center;
        }

        .role-link {
            display: block;
            text-decoration: none;
            height: 100%;
        }

        .role-card {
            border: 2px solid #F3F4F6;
            border-radius: 24px;
            padding: 40px 32px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .role-link:hover .role-card {
            border-color: #E8531A;
            background: #FFF9F6;
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(232,83,26,0.1);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: #F9FAFB;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            transition: all 0.3s;
        }

        .role-link:hover .icon-box {
            background: #E8531A;
            transform: scale(1.1);
        }
        .role-link:hover .icon-box img {
            filter: brightness(0) invert(1);
        }

        .btn-login-link {
            color: #E8531A;
            font-weight: 800;
        }
    </style>
</head>
<body>

<div class="auth-card">
    {{-- Header dengan simbol mapan --}}
    <div class="text-center mb-12">
        <div class="mb-4">
            <img src="{{ asset('image/simbol mapan.png') }}" class="h-16 mx-auto" alt="Logo">
        </div>
        <h1 class="text-4xl font-black text-gray-800 mb-2">Join us!</h1>
        <p class="text-gray-400 font-medium">Choose Your Role</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Option: User --}}
        <a href="{{ route('register.form', 'user') }}" class="role-link">
            <div class="role-card">
                <div class="icon-box">
                    <img src="{{ asset('image/User.png') }}" class="h-10 w-10 object-contain" alt="User Icon">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">User</h3>
                <p class="text-gray-400 text-sm font-medium">Memberi Rating dan Ulasan</p>
            </div>
        </a>

        {{-- Option: Merchant --}}
        <a href="{{ route('register.form', 'merchant') }}" class="role-link">
            <div class="role-card">
                <div class="icon-box">
                    <img src="{{ asset('image/Merchant.png') }}" class="h-10 w-10 object-contain" alt="Merchant Icon">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Merchant</h3>
                <p class="text-gray-400 text-sm font-medium">Daftarkan Resto Anda</p>
            </div>
        </a>
    </div>

    <p class="mt-12 text-gray-400 font-medium text-sm">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-red-500 font-black hover:underline ml-1">Masuk disini</a>
    </p>
</div>

</body>
</html>
