<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Riwayat Data | GacoRain</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <!-- Di dalam <head> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('styles.css') }}" rel="stylesheet">
  <script>
    window.FIREBASE_API_KEY = "{{ config('firebase.api_key') }}";
    window.FIREBASE_AUTH_DOMAIN = "{{ config('firebase.auth_domain') }}";
    window.FIREBASE_DATABASE_URL = "{{ config('firebase.database_url') }}";
    window.FIREBASE_PROJECT_ID = "{{ config('firebase.project_id') }}";
    window.FIREBASE_STORAGE_BUCKET = "{{ config('firebase.storage_bucket') }}";
    window.FIREBASE_MESSAGING_SENDER_ID = "{{ config('firebase.messaging_sender_id') }}";
    window.FIREBASE_APP_ID = "{{ config('firebase.app_id') }}";
    window.FIREBASE_VAPID_KEY = "{{ config('firebase.vapid_key') }}";
    window.IS_ADMIN = {{ $isAdmin ? 'true' : 'false' }};
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
    <div class="text-center mb-3">
      <i class="fas fa-user-circle fa-3x text-light mb-2"></i>
      <p class="text-light mb-0">{{ $user['name'] }}</p>
      <p class="text-light opacity-75 small"><span class="badge {{ $isAdmin ? 'bg-danger' : 'bg-secondary' }}">{{ $isAdmin ? 'Admin' : 'User' }}</span></p>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="#"><i class="fas fa-hourglass-half me-2"></i>Riwayat</a>
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
    <span class="ms-3 badge {{ $isAdmin ? 'bg-danger' : 'bg-secondary' }}">{{ $isAdmin ? 'Admin' : 'User' }}</span>
  </div>
  <form method="POST" action="{{ route('logout') }}" style="margin:0;">
  @csrf
  <button type="submit" class="btn btn-danger btn-sm btn-outline-light">
    <i class="fas fa-sign-out-alt"></i> Logout
  </button>
</form>

</h1>

<div>
  <h3>Filter Riwayat Data</h3>
  Dari: <input type="datetime-local" id="filter-start">
  Sampai: <input type="datetime-local" id="filter-end">
  <button onclick="filterHistoricalData()" class="btn btn-primary">Filter</button>
</div>

@if($isAdmin)
<div class="mt-4">
  <h3>Kelola Riwayat</h3>
  <div class="alert alert-info">
    <i class="fas fa-info-circle"></i> Sebagai Admin, Anda dapat mengelola dan menghapus data riwayat.
  </div>
  <button onclick="clearAllHistory()" class="btn btn-danger">Clear All History</button><br><br>
  Hapus Dari: <input type="datetime-local" id="delete-start">
  Sampai: <input type="datetime-local" id="delete-end">
  <button onclick="deleteDataRange()" class="btn btn-danger">Hapus Rentang Waktu</button>
</div>
@else
<div class="mt-4 alert alert-warning">
  <i class="fas fa-lock"></i> Anda memiliki akses terbatas sebagai User. Hanya Admin yang dapat menghapus data riwayat.
</div>
@endif

<div class="mt-4">
  <table class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <th>Waktu</th>
        <th>Temperature (°C)</th>
        <th>Humidity (%)</th>
        <th>Pressure (hPa)</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody id="history-table-body"></tbody>
  </table>
</div>
<br>
<button onclick="exportKeCSV()" class="btn btn-success">Export Table to CSV</button>

  <!-- Firebase + Chart.js -->
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-database-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/firebase-config.js') }}"></script>
  <script src="{{ asset('js/riwayat-tabel.js') }}"></script>
  <script src="{{ asset('js/riwayat-csv.js') }}"></script>

  <!-- Sebelum </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
