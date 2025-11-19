<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>LOGIN</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?= env('application.desc') ?>">
<meta name="author" content="rullywahyubintoro@gmail.com">
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url() ?>design/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?= base_url() ?>design/plugins/Ionicons/css/ionicons.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url() ?>design/plugins/toastr/toastr.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="<?= base_url() ?>design/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url() ?>design/dist/css/adminlte.min.css">
<link rel="stylesheet" href="<?= base_url() ?>design/dist/css/custom.adminlte.css">
<!-- Google Font: Source Sans Pro -->
<!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->

<!-- jQuery -->
<script src="<?= base_url() ?>design/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>design/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>design/dist/js/adminlte.min.js"></script>
<!-- Validation -->
<script src="<?= base_url() ?>design/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>design/plugins/jquery-validation/localization/messages_id.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>design/plugins/toastr/toastr.min.js"></script>

<script>
const base_url = "<?= base_url() ?>";
</script>
<script src="<?= base_url() ?>assets/jController/CtrlLogin.js" type="text/javascript"></script>
</head>

<body class="hold-transition login-page">
<!-- <div class="wallpaper"></div> -->
<div class="login-box">
  <div class="card card-outline">
    <div class="card-header text-center">
      <a href="#!" class="h1"><?= env('application.name') ?></a>
    </div>
    <div class="card-body login-card-body">
      <p class="login-box-message">Masukkan username & kata sandi.</p>
      <form id="form_login">
        <div class="input-group mb-3 form-group">
          <input type="text" class="form-control no-spacing" placeholder="Username" id="username" name="username" autocomplete="off" onkeyup="pressEnter(event,'#btn_login');">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3 form-group">
          <input type="password" class="form-control" placeholder="Kata sandi" id="password" name="password" autocomplete="new-password" onkeyup="pressEnter(event,'#btn_login');">
          <div class="input-group-append">
            <div class="input-group-text show-password">
              <span class="fa fa-lock" style="cursor: pointer;"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="icheck-primary">
            <input type="checkbox" id="remember_me" name="remember_me">
            <label for="remember_me">
              Ingat Saya
            </label>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-12">
          <a href="#!" class="btn btn-default btn-block btn-flat" id="btn_login" onclick="login('<?= $url ?>')">Masuk</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>