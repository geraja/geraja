<div class="game clearfix">
  <div class="stage">

    <section class="game-page page-select-type active" id="game-page-1">
      <div class="message message-important">
        Selecione um modo de jogo:
      </div>
      <div class="game-type">
        <div class="game-type-item selected" data-game-type="eyes-open">
          <object data="<?= base_url('public/images/eye.svg'); ?>" type="image/svg+xml"></object>
          <h2>Olhos Abertos</h2>
        </div>
        <div class="game-type-item" data-game-type="eyes-close">
          <object data="<?= base_url('public/images/low-vision.svg'); ?>" type="image/svg+xml"></object>
          <h2>Olhos Fechados</h2>
        </div>
      </div>
    </section>

    <section class="game-page" id="game-page-2">
      <div class="message message-info">
        Selecione o nível do jogo
      </div>

      <div class="game-level-options">
        <ul class="list-custom level-items text-center">
          <li class="col-md-2">
            <button type="button" class="btn btn-level selected" data-game-level="1">1</button>
          </li>
          <li class="col-md-2">
            <button type="button" class="btn btn-level" data-game-level="2">2</button>
          </li>
          <li class="col-md-2">
            <button type="button" class="btn btn-level" data-game-level="3">3</button>
          </li>
          <li class="col-md-2">
            <button type="button" class="btn btn-level" data-game-level="4">4</button>
          </li>
          <li class="col-md-2">
            <button type="button" class="btn btn-level" data-game-level="5">5</button>
          </li>
        </ul>

        <button type="button" class="btn btn-action back-page">Voltar</button>
      </div>

    </section>

    <section class="game-page" id="game-page-3">
      <h2>Tela do Jogo</h2>
    </section>

    <section class="game-page" id="game-page-4">
      <h2>Game over</h2>
      <p>
        <button type="button" class="btn btn-action">Jogo novamente</button>
      </p>
    </section>

  </div>
</div>
