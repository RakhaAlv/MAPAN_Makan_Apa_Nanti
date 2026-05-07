<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MAPAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md">

        {{-- Logo / Judul --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-orange-500">MAPAN</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun baru</p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Register --}}
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="username123" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Nama lengkap kamu" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="contoh@email.com" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Minimal 6 karakter" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Ulangi password" required>
            </div>

            {{-- Pilih Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Daftar sebagai</label>
                <div class="grid grid-cols-2 gap-3">

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="user"
                            class="peer hidden" {{ old('role') === 'user' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 rounded-xl p-4 text-center transition">
                            <div class="text-2xl mb-1">🙋</div>
                            <div class="font-semibold text-sm text-gray-700">User</div>
                            <div class="text-xs text-gray-400 mt-1">Cari & review restoran</div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="merchant"
                            class="peer hidden" {{ old('role') === 'merchant' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 rounded-xl p-4 text-center transition">
                            <div class="text-2xl mb-1">🍽️</div>
                            <div class="font-semibold text-sm text-gray-700">Merchant</div>
                            <div class="text-xs text-gray-400 mt-1">Daftarkan restoranmu</div>
                        </div>
                    </label>

                </div>
            </div>

            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-orange-500 hover:underline font-medium">Login di sini</a>
        </p>

    </div>

</body>
</html>