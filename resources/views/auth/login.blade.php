<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GacoRain</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="{{ asset('styles.css') }}" rel="stylesheet">
</head>
<body class="bg-custom-gradient min-h-screen flex items-center justify-center p-4">

  <div class="bg-white rounded-lg shadow-xl flex flex-col md:flex-row w-full max-w-5xl overflow-hidden">
    
    <!-- Form Login -->
    <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
      <div class="text-center mb-6">
        <div class="text-4xl font-bold text-[#ff00cc] mb-2">🌤️</div>
        <h2 class="text-2xl font-semibold text-gray-800">Welcome To GacoRain!</h2>
      </div>

      @if(session('error'))
        <p class="text-red-500 text-sm mb-4">{{ session('error') }}</p>
      @endif

      @if(session('success'))
        <p class="text-green-500 text-sm mb-4">{{ session('success') }}</p>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-gray-700 text-black">Email</label>
          <input 
            type="email" 
            name="email" 
            required 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff00cc] text-gray-700"
          >
        </div>

        <div>
          <label class="block text-gray-700">Password</label>
          <input 
            type="password" 
            name="password" 
            required 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff00cc] text-gray-700"
          >
        </div>

        <button 
          type="submit" 
          class="w-full btn-gradient text-white font-semibold py-2 rounded-lg hover:opacity-90 transition duration-200"
        >
          Login to GacoRain
        </button>
      </form>

      <div class="text-center mt-4 text-sm text-gray-700">
        Lupa password? <a href="#" class="text-[#ff00cc] hover:underline">Klik di sini!</a>
      </div>

      <div class="text-center mt-2 text-sm text-gray-700">
        Belum punya akun? 
        <a href="{{ route('register.form') }}" class="text-[#ff00cc] font-semibold hover:underline">Bergabung Sekarang!</a>
      </div>
    </div>

    <!-- Informasi -->
    <div class="hidden md:flex w-1/2 flex-col justify-center right-panel-gradient text-white p-10">
      <h3 class="text-2xl font-bold mb-4">GacoRain! 🌤️</h3>
      <p class="text-sm leading-relaxed" style="text-align: justify;">
      GacoRain adalah sistem otomatis pengangkat jemuran menggunakan ESP8266, yang menggabungkan sensor BME280 dan servo untuk merespons kondisi cuaca secara realtime. Saat cuaca memburuk, sistem ini secara otomatis mengangkat jemuran Anda tanpa perlu intervensi manual. Dengan dashboard web berbasis Firebase Realtime Database, Anda dapat memantau data suhu, kelembapan, dan tekanan udara secara langsung, di mana saja dan kapan saja. Ciptakan rumah yang lebih cerdas, efisien, dan tanggap terhadap perubahan cuaca mulai dari jemuran Anda dengan menggunakan GacoRain!
      </p>
    </div>

  </div>

  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
  
</body>
</html>
