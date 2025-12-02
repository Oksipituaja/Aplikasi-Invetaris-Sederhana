<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Autentikasi Sistem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap & Font Awesome CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap">
      <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Theme style -->
    <link rel="stylesheet" href="https://aplikasi-invetaris-sederhana.sevalla.app/templates/dist/css/adminlte.min.css">

    {{-- Optional Custom Styling --}}
    <style>
        body {
            background-color: #f8f9fa;
        }
        .auth-box {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>

<main class="d-flex justify-content-center align-items-center vh-100">
    <div class="auth-box bg-white p-4 rounded shadow">
        @yield('content')
    </div>
</main>

</body>
</html>
