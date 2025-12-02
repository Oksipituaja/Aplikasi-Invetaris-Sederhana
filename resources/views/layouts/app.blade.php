<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda Pengguna')</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://aplikasi-invetaris-sederhana.sevalla.app/templates/dist/css/adminlte.min.css">
</head>
<body class="bg-light text-dark">

    <header class="navbar navbar-light bg-white shadow-sm px-4">
        <span class="navbar-brand">Inventaris | Pengguna</span>
        <div>
            <span class="me-2">Halo, {{ auth()->user()?->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
        </div>
    </header>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="text-center py-3 text-muted small">
        &copy; {{ date('Y') }} Inventaris | Versi Pengguna
    </footer>

    @stack('scripts')
</body>
</html>
