<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Inventaris Sederhana</title>

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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('layouts.components.navbar')

  <!-- Sidebar -->
  @include('layouts.components.sidebar')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
      <div class="container-fluid">
        @yield('header')
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> Tester
    </div>
    <strong>Copyright &copy; 2025 <a href="#">Admin Cihuy</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- jQuery via templates (HTTPS) -->
<script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap via templates (HTTPS) -->
<script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE via templates (HTTPS) -->
<script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/dist/js/adminlte.min.js"></script>
</body>
</html>
