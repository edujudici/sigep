<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Powered-By: www.galithx.com.br');
header('X-XSS-Protection: 1');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Vary: Accept-Encoding');

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Galithx Logistica</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/frameworks/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/frameworks/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/frameworks/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/frameworks/adminlte/css/adminlte.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="<?php echo site_url(); ?>"><b>Galithx</b>MarketPlace</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name" style="font-size: 1.3em;">BEM VINDO</div>
  <br><br>
  <div class="row" align="center">
        <?php if ($admin_link): ?>
                    <div class="row"><a style="width: 100%; margin-top: 10px;" class="btn btn-primary" href="<?php echo site_url('admin'); ?>">ENTRAR</a></div>
        <?php endif; ?>

        <?php if ($logout_link): ?>
                    <div class="row"><a style="width: 100%; margin-top: 30px;" class="btn btn-danger" href="<?php echo site_url(); ?>/auth/logout/public">Sair</a></div>
        <?php else: ?>
                    <div> <a style="width: 100%;" class="btn btn-success" href="<?php echo site_url(); ?>/auth/login">Fazer Login</a></div>
        <?php endif; ?>

  </div>
  <br><br>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2017-<?= date('Y') ?> <br> <b><a href="http://www.galithx.com.br" class="text-black">Galithx Labs</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->
<script src="<?= base_url(); ?>/assets/frameworks/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url(); ?>/assets/frameworks/bootstrap/js/bootstrap.min.js"></script>
    <div class="modal fade eventos" tabindex="-1"  >
      <div class="modal-dialog " role="document">
        <div class="modal-cosntent text-center">
            <?php if ($this->session->flashdata('successo') != NULL) {
                    echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>'
                    . $this->session->flashdata('successo') . '</div>';
                } else if ($this->session->flashdata('error') != NULL) {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>'
                    . $this->session->flashdata('error') . '</div>';
                } else if (validation_errors() != NULL) {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>'
                    . validation_errors() . '</div>';
                } ?>
        </div>
      </div>
    </div>

        <script type="text/javascript">
    <?php if ($this->session->flashdata('successo') != NULL  OR  validation_errors() != NULL OR $this->session->flashdata('error') != NULL) {   ?>
        $('.eventos').modal('show');
        <?php } ?>
    </script>
</body>
</html>

