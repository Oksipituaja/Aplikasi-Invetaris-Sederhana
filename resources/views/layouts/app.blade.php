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

    {{-- MODIFIKASI: Mengubah header menjadi navbar yang fungsional --}}
    <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
        
        <a class="navbar-brand me-4" href="{{ route('user.home') }}">
            <i class="fas fa-archive me-2"></i> Inventaris | Pengguna
        </a>
        
        {{-- Tombol Toggle Navbar untuk Mobile (membutuhkan Bootstrap JS) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNavContent" aria-controls="userNavContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="userNavContent">

            {{-- Info User & Logout (Pindahkan ke kanan) --}}
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <span class="btn btn-sm btn-outline-primary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> {{ auth()->user()?->name }}
                    </span>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-id-card me-2"></i> Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    {{-- AKHIR MODIFIKASI HEADER --}}

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="text-center py-3 text-muted small">
         &copy; {{ date('Y') }} Inventaris | Versi Pengguna
    </footer>

    {{-- TAMBAHAN: Script Bootstrap 5 untuk mengaktifkan dropdown dan navbar toggle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
 @stack('scripts')
</body>
</html>
