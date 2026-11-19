<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $app_title ?? 'Aplikasi Pencatat Kehadiran Siswa Kelas' }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('images/png-transparent-noted-note-pen-notebook-write-icon-thumbnail.png')}}" rel="icon">
  <link href="{{asset('NiceAdmin/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('NiceAdmin/assets/vendor/boxicons/css/boxicons.css')}}" rel="stylesheet">
  <link href="{{asset('NiceAdmin/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('NiceAdmin/assets/vendor/quill/quill.bubble.css')}}">
  <link href="{{asset('NiceAdmin/assets/vendor/remixicon/remixicon.css')}}">
  <link href="{{asset('NiceAdmin/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('NiceAdmin/assets/css/style.css')}}" rel="stylesheet">

  <!-- Mobile Responsive Custom CSS -->
  <style>
    /* ---- Global Mobile Fixes ---- */
    body { overflow-x: hidden; }

    /* Scrollable nav tabs on mobile */
    .nav-tabs-scroll-wrapper {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }
    .nav-tabs-scroll-wrapper::-webkit-scrollbar { display: none; }
    .nav-tabs-scroll-wrapper .nav-tabs {
      flex-wrap: nowrap;
      white-space: nowrap;
      min-width: max-content;
    }

    /* Table responsive touch */
    .table-responsive { -webkit-overflow-scrolling: touch; }

    /* Card padding reduce on mobile */
    @media (max-width: 575.98px) {
      .card-body { padding: 1rem !important; }
      .card-body.p-4 { padding: 1rem !important; }
      .container { padding-left: 12px; padding-right: 12px; }
      h4 { font-size: 1.1rem; }
      h5 { font-size: 1rem; }

      /* Reduce logo size on small screens */
      .logo-img-sm { width: 80px !important; height: 80px !important; }

      /* Petugas action buttons — stack vertically */
      .btn-group-mobile-stack { flex-direction: column !important; gap: 4px; }
      .btn-group-mobile-stack .btn { border-radius: 0.375rem !important; font-size: 0.75rem; padding: 0.3rem 0.5rem; }

      /* Dashboard header compact */
      .dashboard-header h4 { font-size: 0.95rem; }
      .dashboard-header .badge { font-size: 0.65rem; }
      .dashboard-header img { width: 38px !important; height: 38px !important; }

      /* Tab button font */
      .nav-link { font-size: 0.8rem; padding: 0.4rem 0.6rem; }

      /* Info page heading */
      center h1 { font-size: 1.4rem; }
      center h3 { font-size: 1rem; }
      center h5 { font-size: 0.85rem; }
    }

    @media (max-width: 767.98px) {
      /* Dashboard stat cards full width on xs */
      .stat-number { font-size: 1.5rem; }
    }
  </style>

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <div><?php date_default_timezone_set('Asia/Jakarta');?>

        @yield('isi')


  <!-- Vendor JS Files -->
  <script src="{{asset('NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('NiceAdmin/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('NiceAdmin/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('NiceAdmin/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('NiceAdmin/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('NiceAdmin/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('NiceAdmin/assets/js/main.js')}}"></script>
    </div>

</body>

</html>
