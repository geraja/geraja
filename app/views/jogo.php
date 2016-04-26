<div class="game clearfix">
  <div class="stage">

  <section class="game-page page-select-type" id="game-page-1">
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
      <div class="game-example">
        <div class="score">00</div>

        <div class="treadmill">

          <div class="question-container question-move">
            <div class="question-items"></div>
            <div class="question-base"></div>
          </div>

          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
          <img src="<?= base_url('public/images/cog.svg'); ?>" alt="Encrenagem da esteira" width="25" height="25" class="rotating">
        </div>

        <div class="answers">
          <ul class="list-custom list-answers">
            <li>
              <button type="button" class="btn btn-answer selected" data-answer="5">5</button>
            </li>
            <li>
              <button type="button" class="btn btn-answer" data-answer="13">13</button>
            </li>
            <li>
              <button type="button" class="btn btn-answer" data-answer="4">4</button>
            </li>
            <li>
              <button type="button" class="btn btn-answer" data-answer="8">8</button>
            </li>
          </ul>
        </div>
      </div>

      <div class="sounds-effects">
        <audio src="<?= base_url('public/sounds/right-answer.mp3') ?>" class="audio right-answer">
          <p>Seu navegador não suporta o elemento audio</p>
        </audio>
        <audio src="<?= base_url('public/sounds/wrong-answer.mp3') ?>" class="audio wrong-answer">
          <p>Seu navegador não suporta o elemento audio</p>
        </audio>
      </div>
    </section>

    <section class="game-page page-start-again" id="game-page-4">
      <h2>Parabéns!<br>Você conseguiu 10 pontos.</h2>
      <p>Tente jogar novamente em outro nível.</p>
      <p>
        <button type="button" class="btn btn-action">Jogar Novamente</button>
      </p>
    </section>

  </div>
</div>
