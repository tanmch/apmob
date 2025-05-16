<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Control | GacoRain</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('styles.css') }}" rel="stylesheet">
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
        <a class="nav-link text-white" href="dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="riwayat"><i class="fas fa-hourglass-half me-2"></i>Riwayat</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href
