<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->renderSection('title') ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= env('application.desc') ?>">
  <meta name="author" content="rullywahyubintoro@gmail.com">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">
  <!-- Favicon -->
  <!-- <link rel="icon" type="image/png" href=""> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/Ionicons/css/ionicons.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/toastr/toastr.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/pace-progress/themes/pace-theme-minimal.css">
  <!-- Animate -->
  <link rel="stylesheet" href="<?= base_url() ?>design/dist/css/animate.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/summernote/summernote-bs4.min.css">
  <!-- bs-tagsinput -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/bs-tagsinput/bootstrap-tagsinput.css">
  <!-- date-range-picker -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/daterangepicker/daterangepicker.css">
  <!-- Ion Slider -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/ion-rangeslider/css/ion.rangeSlider.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>design/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>design/dist/css/custom.adminlte.css">
  <!-- Datatable -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url() ?>design/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <?= $this->renderSection('style') ?>
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->

  <!-- jQuery -->
  <script src="<?= base_url() ?>design/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url() ?>design/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url() ?>design/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- moment -->
  <script src="<?= base_url() ?>design/plugins/moment/moment-with-locales.min.js"></script>
  <!-- Validation -->
  <script src="<?= base_url() ?>design/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?= base_url() ?>design/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?= base_url() ?>design/plugins/jquery-validation/localization/messages_id.min.js"></script>
  <!-- Toastr -->
  <script src="<?= base_url() ?>design/plugins/toastr/toastr.min.js"></script>
  <!-- pace-progress -->
  <script src="<?= base_url() ?>design/plugins/pace-progress/pace.min.js"></script>
  <!-- Select2 -->
  <script src="<?= base_url() ?>design/plugins/select2/js/select2.full.min.js"></script>
  <!-- InputMask -->
  <script src="<?= base_url() ?>design/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url() ?>design/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- FormatPrice -->
  <script src="<?= base_url() ?>design/plugins/jquery-priceformat/jquery.price_format.min.js"></script>
  <!-- Rotate -->
  <script src="<?= base_url() ?>design/plugins/jquery-rotate/jquery.rotate.js"></script>
  <!-- Ekko Lightbox -->
  <script src="<?= base_url() ?>design/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="<?= base_url() ?>design/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- summernote -->
  <script src="<?= base_url() ?>design/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- bs-tagsinput -->
  <script src="<?= base_url() ?>design/plugins/bs-tagsinput/bootstrap-tagsinput.js"></script>
  <!-- date-range-picker -->
  <script src="<?= base_url() ?>design/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Ion Slider -->
  <script src="<?= base_url() ?>design/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
  <!-- Highchart -->
  <script src="<?= base_url() ?>design/plugins/highchart/code/highcharts.js"></script>
  <script src="<?= base_url() ?>design/plugins/highchart/code/modules/series-label.js"></script>
  <!-- Datatable -->
  <script src="<?= base_url() ?>design/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>design/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url() ?>design/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url() ?>design/dist/js/demo.js"></script>
  <script>
    const base_url = "<?= base_url() ?>";
    const image_default_url = "<?= base_url() ?>design/images/comp/img_default.png";
  </script>

  <script src="<?= base_url() ?>assets/jController/CtrlSystem.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?= base_url() ?>design/plugins/sweetalert2/sweetalert2.min.js"></script>

  <?= $this->renderSection('script') ?>

</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed pace-primary">
  <div id="loader" style="display: none;">
    <div class="spinner"></div>
  </div>
  
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" data-enable-remember="true" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
          <?php if (session()->get('id')) : ?>
            <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url() ?>design/images/comp/user_default.png" class="user-image img-circle elevation-2" alt="User Image">
              <span class="d-none d-md-inline"><?= session()->get('name') ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <li class="user-header bg-dark">
                <img src="<?= base_url() ?>design/images/comp/user_default.png" class="img-circle elevation-2" alt="User Image">
                <p>
                  <?= session()->get('name') ?>
                  <small><?= request()->getIPAddress() ?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="btn-group btn-block">
                  <a href="#!" class="btn btn-info btn-flat btn-sm" onclick="_UserProfile.getData()">Akun <i class="fa fa-user"></i></a>
                  <a href="#!" class="btn btn-warning btn-flat btn-sm" onclick="_UserProfile.getGroup()">Akses <i class="fa fa-cog"></i></a>
                </div>
                <a href="<?= base_url() ?>logout" class="btn btn-danger btn-block btn-sm">Keluar <i class="fa fa-sign-out-alt"></i></a>
              </li>
            </ul>
          <?php else : ?>
            <a href="<?= base_url() ?>login" class="nav-link">
              <img src="<?= base_url() ?>design/images/comp/user_default.png" class="user-image img-circle elevation-2" alt="User Image">
              <span class="d-none d-md-inline">Login</span>
            </a>
          <?php endif; ?>
        </li>
      </ul>
    </nav>