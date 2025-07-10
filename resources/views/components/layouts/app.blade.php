<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KASIR PIETO</title>

  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
    }
  </style>
</head>

<body style="background-color: #f0f8ff">
  <div class="sidebar">
    <h5>KASIR PIETO</h5>

    @php
    $user = Auth::user();
    @endphp

    @if ($user && $user->role === 'admin')
    <a href="{{ url('/order') }}" class="{{ request()->is('order*') ? 'active' : '' }}">List Order</a>
    <a href="{{ url('/product') }}" class="{{ request()->is('product*') ? 'active' : '' }}">Produk</a>
    <a href="{{ url('/rekap') }}" class="{{ request()->is('rekap*') ? 'active' : '' }}">Rekapitulasi</a>
    <a href="{{ url('/user-management') }}" class="{{ request()->is('user-management*') ? 'active' : '' }}">Manajemen User</a>
    @elseif ($user && $user->role === 'kasir')
    <a href="{{ url('/pos') }}" class="{{ request()->is('pos*') ? 'active' : '' }}">Transaksi</a>
    <a href="{{ url('/order') }}" class="{{ request()->is('order*') ? 'active' : '' }}">List Order</a>
    @endif

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 2rem;">
      @csrf
      <button type="submit" class="btn btn-outline-danger w-100">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </div>

  <div class="content">
    {{ $slot }}
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  @stack('scripts')
</body>

<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f8f9fa;
  }

  .sidebar {
    min-height: 100vh;
    width: 240px;
    background: #ffffff;
    border-right: 1px solid #dee2e6;
    padding: 2rem 1rem;
    position: fixed;
  }

  .sidebar h5 {
    font-weight: bold;
    color: #343a40;
    text-align: center;
    margin-bottom: 2rem;
  }

  .sidebar a {
    display: block;
    padding: 0.75rem 1rem;
    margin-bottom: 0.75rem;
    border-radius: 8px;
    text-decoration: none;
    color: #495057;
    transition: all 0.3s ease;
    font-weight: 500;
  }

  .sidebar a:hover,
  .sidebar a.active {
    background-color: rgb(236, 166, 5);
    color: #ffffff !important;
  }

  .content {
    margin-left: 240px;
    padding: 2rem;
  }
</style>

</html>