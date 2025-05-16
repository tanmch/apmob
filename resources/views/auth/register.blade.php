<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | GacoRain</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-custom-gradient {
                background-image: linear-gradient(to right, #F7374F, #102E50);
            }
            .bg-info-gradient {
                background-image: linear-gradient(to right, #102E50, #F7374F);
            }
            .text-gacorain-pink {
                color: #F7374F;
            }
            .ring-gacorain-pink:focus {
                --tw-ring-color: #F7374F;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-custom-gradient">

    <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-lg overflow-hidden">

        <!-- Kiri: Informasi -->
        <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-info-gradient text-white p-8">
            <h1 class="text-xl font-bold mb-4">🌤️</h1>
            <h1 class="text-xl font-bold mb-4">
                Hi! Welcome to GacoRain!
            </h1>
        </div>

        <!-- Kanan: Form Registrasi -->
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-2xl font-bold text-center text-gacorain-pink mb-1">🌤️</h2>
            <p class="text-center font-semibold text-gray-800 mb-6">Buat akun di GacoRain!</p>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium">Nama</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none ring-gacorain-pink focus:ring-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none ring-gacorain-pink focus:ring-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none ring-gacorain-pink focus:ring-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none ring-gacorain-pink focus:ring-2">
                </div>

                <button type="submit" class="w-full bg-info-gradient text-white font-semibold py-2 rounded hover:opacity-90 transition duration-200">
                    Register to GacoRain!
                </button>
            </form>

            <p class="mt-4 text-sm text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login.form') }}" class="text-gacorain-pink font-medium hover:underline">
                    Klik di sini untuk login!
                </a>
            </p>
        </div>
    </div>

</body>
</html>
