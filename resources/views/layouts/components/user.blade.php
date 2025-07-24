<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Beranda Pengguna')</title>

  <!-- AdminLTE + Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap">
  <link rel="stylesheet" href="{{ asset('templates/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('templates/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition layout-top-nav">

<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
      <a href="#" class="navbar-brand"><i class="fas fa-box-open me-1"></i>Inventaris</a>
      <div class="navbar-nav ms-auto">
        @auth
          <span class="nav-item nav-link">Halo, {{ auth()->user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-danger">Logout</button>
          </form>
        @endauth
      </div>
    </div>
  </nav>

  <div class="content-wrapper">
    <div class="content-header"><div class="container"><h3>@yield('title')</h3></div></div>
    <div class="content"><div class="container">@yield('content')</div></div>
  </div>

  <footer class="main-footer text-center small">
    &copy; {{ date('Y') }} Inventaris • Versi Pengguna
  </footer>
</div>

<script src="{{ asset('templates/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('templates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('templates/dist/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>