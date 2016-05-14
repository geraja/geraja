<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php

  $the_title = isset($page_title) ? "$page_title - GeraJá" : "GeraJá";

  ?>
  <title><?= $the_title; ?></title>
  <link rel="stylesheet" href="<?= base_url('public/css/main.css') ?>">
  <link rel="icon" href="<?= base_url('public/images/favicon.png'); ?>">
</head>
<body class="game-template">
  <div class="container clearfix">
    <?php
  /*
  |----------------------------------------------------
  | About $body
  |----------------------------------------------------
  | $body is provider by controller and passed to the
  | template library (in libraries folder).
  */
  ?>
  <?= $body; ?>
</div>

<script>
  var images = [];
  var sounds = [];
  var soundsAssets = {};
  var urlAssets = null;

  <?php if(isset($assets_url)): ?>
    var urlAssets = '<?= $assets_url; ?>';
  <?php endif; ?>

  <?php if(isset($images)): ?>
    <?php foreach($images as $a): ?>
      images.push('<?= $a->name; ?>');
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if(isset($audios)): ?>
    <?php foreach($audios as $a): ?>
      var soundName = "<?= substr($a->name, 0, -4); ?>";
      sounds.push(soundName);

      <?php if(isset($assets_url)): ?>
        var soundUrl = "<?= $assets_url . $a->name; ?>";
        soundsAssets[soundName] = soundUrl;
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</script>

<script src="<?php echo base_url('public/js/main.js'); ?>"></script>
</body>
</html>
