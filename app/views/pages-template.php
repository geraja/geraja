<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php

  $the_title = isset($page_title) ? "$page_title | GeraJá" : "GeraJá";

  ?>
  <title><?= $the_title; ?></title>
  <link rel="stylesheet" href="<?= base_url('public/css/main.css?v=' . md5(rand())) ?>">
  <link rel="icon" href="<?= base_url('public/images/favicon.png'); ?>">
</head>
<body class="page-template">
  <div class="container clearfix">
    <?php $this->load->view('partials/menu-pages'); ?>
    <?php
    /*
    |----------------------------------------------------
    | About $body
    |----------------------------------------------------
    | $body is provider by controller and passed to the
    | template library (in libraries folder).
    */
    ?>
    <section class="main-content">
      <?= $body; ?>
    </section>
</div>

<script src="<?php echo base_url('public/js/main.js?v=' . md5(rand())); ?>"></script>
</body>
</html>
