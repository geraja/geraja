<section class="page-section">
  <h2 class="text-center">Confira alguns jogos criados por usuários</h2>
  <div class="row text-center">
    <div class="col-md-4">
      <p><b>1.</b> Crie uma conta apenas com email e senha.</p>
    </div>
    <div class="col-md-4">
      <p><b>2.</b> Gere jogos para jogar vendo ou jogar ouvindo</p>
    </div>
    <div class="col-md-4">
      <p><b>3.</b> Compartilhe os jogos com outros usuários</p>
    </div>
  </div>
</section>

<?php if(isset($games)): ?>
  <section class="page-section">
    <h2 class="text-center">Confira alguns jogos criados por usuários</h2>
    <div class="container-games">
      <div class="row">
        <?php foreach($games as $g): ?>
          <div class="col-md-3">

            <div class="game-item <?= $g->type == 1 ? 'game-type-1' : 'game-type-2'; ?>">
              <?php $game_image = ($g->type == 1) ? 'eye.svg' : 'audio-version.svg'; ?>
              <?php $game_url = base_url('jogo/' . $g->code); ?>
              <div class="game-thumb">
                <a href="<?= $game_url; ?>"><img src="<?= base_url('public/images/' . $game_image); ?>" alt="<?= $g->name; ?>" width="60"></a>
                <div class="game-type-text"><a href="<?= $game_url; ?>">para <?= ($g->type == 1) ? 'jogar vendo' : 'jogar ouvindo'; ?></a></div>
              </div>
              <h3 class="game-title">
                <a target="_blank" href="<?= $game_url; ?>"><?= $g->name; ?></a>
              </h3>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <p class="text-center">
    <a class="btn btn-action" href="<?= base_url('jogos'); ?>">Ver todos os jogos</a>
  </p>
<?php endif; ?>
