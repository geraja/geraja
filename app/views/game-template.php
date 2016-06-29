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
<body class="game-template game-engine-<?= $game['engine'] ?>">
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
  var questions = {};
  var urlAssets = '<?= $assets_url; ?>';

  <?php if(isset($images)): ?>

    <?php foreach($images as $a): ?>
      images.push('<?= $a->name; ?>');
    <?php endforeach; ?>

  <?php endif; ?>

  <?php if(isset($audios)): ?>

    <?php foreach($audios as $a): ?>
      var soundName = "<?= substr($a->name, 0, -4); ?>";
      sounds.push(soundName);

      var soundUrl = "<?= $assets_url . $a->name; ?>";
      soundsAssets[soundName] = soundUrl;
    <?php endforeach; ?>

  <?php endif; ?>

  <?php if(isset($questions)): ?>

    <?php foreach($questions as $a): ?>
      var question = {};

      <?php if($game['type'] == 1): ?>
      question['asset'] = '<?= $a->name; ?>';
      question['answers'] = ['<?= $a->first_option; ?>', '<?= $a->second_option; ?>', '<?= $a->third_option; ?>', '<?= $a->fourth_option; ?>'];
      question['correct_answer'] = parseInt('<?= $a->correct_answer; ?>');
      question['type'] = parseInt('<?= $a->type; ?>');

      questions[(Object.keys(questions).length + 1)] = question;

      <?php else: ?>
        question['asset'] = '<?= substr($a->name, 0, -4); ?>';
        question['answers'] = ['<?= substr($a->first_option, 0, -4); ?>', '<?= substr($a->second_option, 0, -4); ?>', '<?= substr($a->third_option, 0, -4); ?>', '<?= substr($a->fourth_option, 0, -4); ?>'];
        question['correct_answer'] = '<?= $a->correct_answer; ?>';

        questions[(Object.keys(questions).length + 1)] = question;

        var soundUrl;
        var audioEl;

        // Alternativa A
        soundName = "<?= substr($a->first_option, 0, -4); ?>";
        sounds.push(soundName);
        soundUrl = "<?= $assets_url . $a->first_option; ?>";
        soundsAssets[soundName] = soundUrl;

        // Alternativa B
        soundName = "<?= substr($a->second_option, 0, -4); ?>";
        sounds.push(soundName);
        soundUrl = "<?= $assets_url . $a->second_option; ?>";
        soundsAssets[soundName] = soundUrl;

        // Alternativa C
        soundName = "<?= substr($a->third_option, 0, -4); ?>";
        sounds.push(soundName);
        soundUrl = "<?= $assets_url . $a->third_option; ?>";
        soundsAssets[soundName] = soundUrl;

        // Alternativa D
        soundName = "<?= substr($a->fourth_option, 0, -4); ?>";
        sounds.push(soundName);
        soundUrl = "<?= $assets_url . $a->fourth_option; ?>";
        soundsAssets[soundName] = soundUrl;

      <?php endif; ?>

    <?php endforeach; ?>

  <?php endif; ?>

</script>

<script src="<?php echo base_url('public/js/main.js?v=' . md5(rand())); ?>"></script>
</body>
</html>
