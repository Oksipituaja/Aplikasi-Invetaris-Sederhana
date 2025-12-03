<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Invetaris Sederhana</title>
<!-- Bootstrap 4 (CSS & JS) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome (untuk ikon) -->
<link rel="stylesheet" href="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/fontawesome-free/css/all.min.css">

<!-- Tempus Dominus Bootstrap 4 -->
<link rel="stylesheet" href="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/jquery/jquery.min.js"></script>
<script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/moment/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone.min.js"></script>
<script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://aplikasi-invetaris-sederhana.sevalla.app/templates/dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.components.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.components.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    @yield('header')
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->

            <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button"
                aria-label="Scroll to top">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> Tester
            </div>
            <strong>Copyright &copy; 2025 <a href="#">Admin Cihuy</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/plugins/bootstrap/js/bootstrap.bundle.min.js">
    </script>
    <!-- AdminLTE -->
    <script src="https://aplikasi-invetaris-sederhana.sevalla.app/templates/dist/js/adminlte.min.js"></script>

</html>
