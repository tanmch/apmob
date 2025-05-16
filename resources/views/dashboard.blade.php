<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard | GacoRain</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('styles.css') }}" rel="stylesheet">
  
  <!-- Firebase Config -->
  <script>
    window.FIREBASE_API_KEY = "{{ config('firebase.api_key') }}";
    window.FIREBASE_AUTH_DOMAIN = "{{ config('firebase.auth_domain') }}";
    window.FIREBASE_DATABASE_URL = "{{ config('firebase.database_url') }}";
    window.FIREBASE_PROJECT_ID = "{{ config('firebase.project_id') }}";
    window.FIREBASE_STORAGE_BUCKET = "{{ config('firebase.storage_bucket') }}";
    window.FIREBASE_MESSAGING_SENDER_ID = "{{ config('firebase.messaging_sender_id') }}";
    window.FIREBASE_APP_ID = "{{ config('firebase.app_id') }}";
    window.FIREBASE_VAPID_KEY = "{{ config('firebase.vapid_key') }}";
  </script>
</head>
<body>

<!-- Sidebar -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="#"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="riwayat"><i class="fas fa-hourglass-half me-2"></i>Riwayat</a>
      </li>
    </ul>
  </div>
</div>

<h1>
  <div style="display:flex; align-items:center;">
    <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
      <i class="fas fa-bars"></i>
    </button>
    <span>🌤️ GacoRain</span>
  </div>
  <form method="POST" action="{{ route('logout') }}" style="margin:0;">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm btn-outline-light">
      <i class="fas fa-sign-out-alt"></i> Logout
    </button>
  </form>
</h1>

<div class="section">
  <div class="grid">
    <div class="card">
      <i id="weather-icon" class="weather-icon fas fa-sun"></i>
      <h3 id="weather-condition">Sunny</h3>
      <p id="weather-recommendation">Good conditions for drying clothes.</p>
      <small id="weather-updated">Updated -</small>
    </div>
    <div class="card">
      <i id="servo-icon" class="servo-icon fas fa-door-closed"></i>
      <h3 id="servo-status">Closed</h3>
      <p id="servo-details">Clothes are currently protected from the weather</p>
      <small id="servo-updated">Updated -</small>
    </div>
    <div class="card">
      <h3>Temperature</h3>
      <p><span id="temperature-value">-</span></p>
      <div class="gauge-bar"><div id="temperature-gauge" class="gauge-fill" style="background:#f39c12;width:0%"></div></div>
    </div>
    <div class="card">
      <h3>Humidity</h3>
      <p><span id="humidity-value">-</span></p>
      <div class="gauge-bar"><div id="humidity-gauge" class="gauge-fill" style="background:#3498db;width:0%"></div></div>
    </div>
    <div class="card">
      <h3>Pressure</h3>
      <p><span id="pressure-value">-</span></p>
      <div class="gauge-bar"><div id="pressure-gauge" class="gauge-fill" style="background:#2ecc71;width:0%"></div></div>
    </div>
  </div>
</div>

<section class="app-section">
  <h2>Detailed Analysis</h2>
  <div class="chart-container">
    <div class="chart-card">
      <h3>Temperature History</h3>
      <canvas id="temperature-chart"></canvas>
    </div>
    <div class="chart-card">
      <h3>Humidity History</h3>
      <canvas id="humidity-chart"></canvas>
    </div>
    <div class="chart-card">
      <h3>Pressure History</h3>
      <canvas id="pressure-chart"></canvas>
    </div>
  </div>
</section>
<br>
<button id="export" class="btn btn-primary">Export Chart to PDF</button>
<button id="notification-permission" class="btn btn-primary">Enable Notifications</button>

<!-- Scripts -->
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-database-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Scripts -->
<script src="{{ asset('js/firebase-config.js') }}"></script>
<script src="{{ asset('js/notifications.js') }}"></script>
<script src="{{ asset('js/sensor-charts.js') }}"></script>
<script src="{{ asset('js/pdf-export.js') }}"></script>
</body>
</html>
