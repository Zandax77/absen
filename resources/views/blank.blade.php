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
    * { box-sizing: border-box; }
    body { 
      overflow-x: hidden; 
      -webkit-font-smoothing: antialiased;
    }

    /* Prevent mobile browser zoom on form focus */
    @media (max-width: 767.98px) {
      input[type="text"],
      input[type="password"],
      input[type="email"],
      input[type="number"],
      input[type="date"],
      select,
      textarea {
        font-size: 16px !important;
      }
    }

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

    /* Make ALL nav-tabs scrollable by default on mobile */
    @media (max-width: 767.98px) {
      .nav-tabs, .nav-tabs.nav-tabs-bordered {
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 2px;
        display: flex !important;
      }
      .nav-tabs::-webkit-scrollbar, .nav-tabs.nav-tabs-bordered::-webkit-scrollbar { display: none; }
      .nav-tabs .nav-link, .nav-tabs.nav-tabs-bordered .nav-link {
        white-space: nowrap;
        flex-shrink: 0;
      }
    }

    /* Table responsive touch */
    .table-responsive { 
      -webkit-overflow-scrolling: touch; 
      width: 100%;
      margin-bottom: 1rem;
    }

    /* Auth logo responsive */
    .logo-img-auth {
      max-width: 110px;
      max-height: 110px;
      height: auto;
      width: auto;
      object-fit: contain;
    }

    /* ---- Extra small (< 576px) ---- */
    @media (max-width: 575.98px) {
      .card-body { padding: 0.9rem !important; }
      .card-body.p-4, .card-body.p-3 { padding: 0.9rem !important; }
      .container { padding-left: 12px; padding-right: 12px; }
      h4 { font-size: 1.05rem; }
      h5 { font-size: 0.95rem; }
      h6 { font-size: 0.85rem; }

      /* Logo on auth / login */
      .logo-img-auth {
        max-width: 85px !important;
        max-height: 85px !important;
      }
      .section.register {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        min-height: 90vh !important;
      }

      /* Tab buttons smaller */
      .nav-link { font-size: 0.75rem !important; padding: 0.4rem 0.65rem !important; }

      /* Info page heading */
      center h1, .text-center h1 { font-size: 1.25rem !important; }
      center h3, .text-center h3 { font-size: 0.95rem !important; }
      center h5, .text-center h5 { font-size: 0.8rem !important; }

      /* Buttons: make smaller & full-width when stacked */
      .btn { font-size: 0.82rem; }
      .btn-sm { font-size: 0.75rem; }

      /* Stat number on dashboard cards */
      .stat-number { font-size: 1.3rem; }

      /* Dashboard top header */
      .dashboard-header h4 { font-size: 0.88rem; }
      .dashboard-header .badge { font-size: 0.6rem; }
      .dashboard-header img { width: 36px !important; height: 36px !important; }

      /* Action button groups: stack vertically */
      .btn-group.btn-group-sm { flex-direction: column !important; align-items: stretch !important; gap: 4px !important; }
      .btn-group.btn-group-sm > .btn { border-radius: 0.375rem !important; font-size: 0.72rem; width: 100%; }

      /* Admin dashboard header buttons */
      .d-flex.gap-2 .btn { font-size: 0.72rem; padding: 0.35rem 0.6rem; }

      /* Table font size */
      .table { font-size: 0.82rem; }
      .table th, .table td { padding: 0.5rem 0.4rem; }

      /* Pie chart section: single column */
      .row > [class*='col-lg-4']:not([class*='col-md-']):not([class*='col-sm-']) {
        flex: 0 0 100%;
        max-width: 100%;
      }

      /* iframe compact */
      .iframe-container iframe { height: 380px !important; }

      /* Modal styling on mobile */
      .modal-dialog {
        margin: 0.5rem;
      }
      .modal-body { padding: 1rem !important; }
      .modal-footer { padding: 0.75rem !important; flex-wrap: wrap; gap: 0.4rem; }
      .modal-footer .btn { width: 100% !important; margin: 0 !important; }
    }

    /* ---- Small to Medium (576-767px) ---- */
    @media (min-width: 576px) and (max-width: 767.98px) {
      .table { font-size: 0.85rem; }
      .btn-group.btn-group-sm { flex-direction: column !important; align-items: stretch !important; gap: 4px !important; }
      .btn-group.btn-group-sm > .btn { border-radius: 0.375rem !important; width: 100%; }
    }

    /* ---- Medium (768px) ---- */
    @media (max-width: 767.98px) {
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
