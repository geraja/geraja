<?php $this->load->view('partials/alert-message'); ?>
<?php if(!isset($error)): ?>
  <div class="game clearfix">
    <div class="stage">
      <section class="game-page page-loading active">
        <div class="preloader text-center">
          <h2>Carregando...</h2>
          <div class="preloader-status">
            <div class="preloader-bar"></div>
          </div>
        </div>
      </section>

      <section class="game-page page-select-type" id="game-page-1">
        <div class="message message-important">
          Selecione um modo de jogo:
        </div>
        <div class="game-type">
          <div class="game-type-item <?= $game['type'] == 1 ? 'selected' : ''; ?>" data-game-type="vison-version">
            <object data="<?= base_url('public/images/eye.svg'); ?>" type="image/svg+xml"></object>
          </div>
          <div class="game-type-item <?= $game['type'] == 2 ? 'selected' : ''; ?>" data-game-type="audio-version">
            <object data="<?= base_url('public/images/audio-version.svg'); ?>" type="image/svg+xml"></object>
          </div>
        </div>
      </section>

      <section class="game-page" id="game-page-2">
        <div class="message message-info">
          Selecione a dificuldade do jogo
        </div>

        <div class="game-level-options">
          <ul class="list-custom level-items text-center">
            <li class="col-md-2">
              <button type="button" class="btn btn-level" data-game-level="1">1</button>
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
            <li class="col-md-2">
              <button type="button" class="btn btn-level" data-game-level="6">6</button>
            </li>
          </ul>
        </div>

      </section>

      <section class="game-page" id="game-page-3">
        <div class="game-example">
          <div class="score">00/10</div>

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
          <audio id="audio-player" preload="auto">
            <p>Seu navegador não suporta o elemento audio</p>
          </audio>
          <audio class="audio selecione-dificuldade-jogo" preload="auto" src="<?= base_url('public/sounds/selecione-dificuldade-jogo.mp3'); ?>"></audio>
          <audio class="audio clock-tick" preload="auto" src="<?= base_url('public/sounds/clock-tick-v1.mp3'); ?>"></audio>
          <audio class="audio jogar-novamente" preload="auto" src="<?= base_url('public/sounds/jogar-novamente.mp3'); ?>"></audio>
          <!-- <audio class="audio jogar-ouvindo" preload="auto" src="<?= base_url('public/sounds/jogar-ouvindo.mp3'); ?>"></audio> -->
          <!-- <audio class="audio jogar-vendo" preload="auto" src="<?= base_url('public/sounds/jogar-vendo.mp3'); ?>"></audio> -->
          <audio class="audio numero-0" preload="auto" src="<?= base_url('public/sounds/numero-0.mp3'); ?>"></audio>
          <audio class="audio numero-1" preload="auto" src="<?= base_url('public/sounds/numero-1.mp3'); ?>"></audio>
          <audio class="audio numero-2" preload="auto" src="<?= base_url('public/sounds/numero-2.mp3'); ?>"></audio>
          <audio class="audio numero-3" preload="auto" src="<?= base_url('public/sounds/numero-3.mp3'); ?>"></audio>
          <audio class="audio numero-4" preload="auto" src="<?= base_url('public/sounds/numero-4.mp3'); ?>"></audio>
          <audio class="audio numero-5" preload="auto" src="<?= base_url('public/sounds/numero-5.mp3'); ?>"></audio>
          <audio class="audio numero-6" preload="auto" src="<?= base_url('public/sounds/numero-6.mp3'); ?>"></audio>
          <audio class="audio numero-7" preload="auto" src="<?= base_url('public/sounds/numero-7.mp3'); ?>"></audio>
          <audio class="audio numero-8" preload="auto" src="<?= base_url('public/sounds/numero-8.mp3'); ?>"></audio>
          <audio class="audio numero-9" preload="auto" src="<?= base_url('public/sounds/numero-9.mp3'); ?>"></audio>
          <audio class="audio numero-10" preload="auto" src="<?= base_url('public/sounds/numero-10.mp3'); ?>"></audio>
          <audio class="audio muito-bem" preload="auto" src="<?= base_url('public/sounds/muito-bem.mp3'); ?>"></audio>
          <audio class="audio right-answer" preload="auto" src="<?= base_url('public/sounds/right-answer.mp3'); ?>"></audio>
          <audio class="audio wrong-answer" preload="auto" src="<?= base_url('public/sounds/wrong-answer.mp3'); ?>"></audio>
          <!-- <audio class="audio selecione-modo-jogo" preload="auto" src="<?= base_url('public/sounds/selecione-modo-jogo.mp3'); ?>"></audio> -->
          <!-- <audio class="audio passou-nivel" preload="auto" src="<?= base_url('public/sounds/voce-passou-nivel.mp3'); ?>"></audio> -->
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
<?php else: ?>
  <div style="margin: 240px 20px 0;">
    <div class="alert alert-danger text-center">
      <?php echo $error_message; ?>
    </div>
    <p><a class="btn btn-default" href="javascript:history.back();">Voltar</a></p>
  </div>
<?php endif; ?>
