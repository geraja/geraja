<section class="page-section">
  <h1></h1>

  <?php if(isset($games)): ?>

    <div class="row">
      <div class="col-md-12">
        <form action="" class="form-search center-block ">
          <input type="text" class="field-search" placeholder="Ache seu jogo...">
          <input type="image" src="<?= base_url('public/images/search.png'); ?>"  class="pull-right button-search">
        </form>
      </div>
    </div>

    <br>

    <div class="container-games">

      <?php $row_control = 1; ?>
      <?php foreach($games as $g): ?>

        <?php if($row_control == 1): ?>
          <div class="row">
        <?php endif; ?>

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

        <?php if($row_control == 4): ?>
          <?php $row_control = 0; ?>
          </div>
        <?php endif; ?>

        <?php $row_control++; ?>
      <?php endforeach; ?>

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
