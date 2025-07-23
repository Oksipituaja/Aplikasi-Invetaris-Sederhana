<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Autentikasi Sistem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap & Font Awesome CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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