<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password - SKPI UNAI</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gradient-to-br from-blue-300 via-indigo-200 to-purple-300 flex items-center justify-center min-h-screen">

<div class="bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl w-96 border border-gray-300">

    <div class="text-center mb-6">
        <h2 class="text-3xl font-extrabold text-indigo-700">Lupa Password</h2>
        <p class="text-gray-600 text-sm">Masukkan email Anda untuk menerima kode OTP</p>
    </div>

    @if(session('error'))
    <div class="bg-red-500 text-white p-2 rounded mb-4 text-center shadow-md">{{ session('error') }}</div>
    @endif

    @if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded mb-4 text-center shadow-md">{{ session('success') }}</div>
    @endif

    <form action="{{ route('forgot.send') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Email</label>
            <div class="relative">
                <i data-feather="mail" class="absolute left-3 top-3 text-gray-500"></i>
                <input type="email" name="email" class="w-full p-3 pl-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400" placeholder="Masukkan email" required>
            </div>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 p-3 rounded-lg text-white font-bold">
            Kirim Kode OTP
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-indigo-700 hover:underline">Kembali ke Login</a>
    </div>
</div>

<script>
feather.replace();
</script>
</body>
</html>
