<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda Pengguna')</title>
  <!-- Bootstrap (CDN HTTPS) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome (CDN HTTPS) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- AdminLTE CSS via templates (HTTPS) -->
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
