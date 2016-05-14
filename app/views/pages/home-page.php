<section class="page-section">
  <h2 class="text-center">Confira alguns jogos criados por usuários</h2>
  <div class="container-games">
    <div class="row">
      <div class="col-md-3">
        <div class="game-item">
          <div class="game-thumb"></div>
          <h3 class="game-title"><a href="#">Jogo Exemplo</a></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="game-item">
          <div class="game-thumb"></div>
          <h3 class="game-title"><a href="#">Jogo Exemplo</a></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="game-item">
          <div class="game-thumb"></div>
          <h3 class="game-title"><a href="#">Jogo Exemplo</a></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="game-item">
          <div class="game-thumb"></div>
          <h3 class="game-title"><a href="#">Jogo Exemplo</a></h3>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="page-section">
  <?= form_open(base_url('cadastro'), array('role' => 'search')); ?>
  <div class="form-group">
    <h2 class="text-center">Pesquise outros jogos</h2>
    <input type="text" class="input-control input-search" placeholder="Exemplo de pesquisa: Bolhas, Amarelinha, Sons cósmicos">
  </div>
  <?= form_close(); ?>
</section>
