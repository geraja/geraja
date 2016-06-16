<section class="page-section">
  <h1>Todos os jogos publicados (<?= $total_games; ?>):</h1>
<?php if(isset($games)): ?>

    <div class="container-games">
      <div class="row">
        <?php foreach($games as $g): ?>
          <div class="col-md-3">

            <div class="game-item <?= $g->type == 1 ? 'game-type-1' : 'game-type-2'; ?>">
              <?php $game_image = ($g->type == 1) ? 'eye.svg' : 'low-vision.svg'; ?>
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

    <?php if(isset($pagination)): ?>
      <div class="pagination">
        <?= $pagination; ?>
      </div>
    <?php endif; ?>

  <?php else: ?>
    <p>Não foi possível carregar os jogos. Iremos resolver o quanto antes, por favor tente acessar novamente mais tarde.</p>
  <?php endif; ?>

  </section>

