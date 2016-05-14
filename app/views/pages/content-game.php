<section class="page-section">
  <?php $game_name = isset($game) ? ' - <span>' . $game['name'] . '</span>' : '';  ?>
  <div class="row section-header">
    <div class="col-md-8">
      <h1>Configuração do jogo<?= $game_name; ?></h1>
    </div>
    <div class="col-md-4">
      <a class="btn btn-default" href="<?= base_url('gerenciador'); ?>">Voltar</a>
    </div>
  </div>

  <?php $this->load->view('partials/alert-message'); ?>

  <?php if(isset($game)): ?>
    <?php

    $hiddens = array('id_game' => $game['id_game']);
    $path_assets = base_url('data/' . $game['uid'] . '/' . $game['id_game']) . '/';

    ?>

    <div class="game-config">
      <div class="game-content">
        <h2 class="game-content-title">Imagens do jogo (<span>versão para jogar vendo</span>)</h2>
        <div class="alert alert-info">
          <p><b>Confira algumas informações importantes sobre as imagens:</b></p>
          <ul>
            <li>As imagens devem ser nos formatos <b>.png</b> ou <b>.jpg</b>.</li>
            <li>As imagens devem ter o tamanho minimo de <b>16 pixels(px)</b> na largura.</li>
          </ul>
        </div>
        <div class="game-content-form clearfix">
          <?= form_open_multipart(base_url('gerenciador/adicionar-asset/imagem'), array('class' => 'form-default'), $hiddens); ?>
          <div class="form-group">
            <?php

            echo form_upload(array('name' => 'game-asset', 'id' => 'game-asset','required' => 'required'));

            ?>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-green col-md-3" value="Adicionar imagem ao jogo" name="btn-add-imagem" id="btn-add-imagem">
          </div>
          <?= form_close(); ?>
        </div>
        <div class="game-content-list">
          <?php if(isset($images)): ?>
            <table class="table">
              <thead>
                <tr>
                  <th>Imagem</th>
                  <th>Adicionada em</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($images as $i): ?>
                  <tr>
                    <td>
                      <img src="<?= $path_assets . $i->name; ?>" alt="Imagem do jogo">
                    </td>
                    <td><?= display_date($i->inserted_at); ?></td>
                    <td>
                      <a class="btn btn-red btn-small" href="#">Desativar imagem</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
      <div class="game-content">
        <h2 class="game-content-title">Áudios do jogo (<span>versão para jogar ouvindo</span>)</h2>
        <div class="alert alert-info">
          <p><b>Confira algumas informações importantes sobre os áudios:</b></p>
          <ul>
            <li>Os áudios devem ser no formato <b>.mp3</b>.</li>
            <li>Clique <a href="#">aqui</a> para conferir alguns exemplos de áudios que recomendamos.</li>
          </ul>
        </div>
        <div class="game-content-form clearfix">
          <?= form_open_multipart(base_url('gerenciador/adicionar-asset/audio'), array('class' => 'form-default'), $hiddens); ?>
          <div class="form-group">
            <?php

            echo form_upload(array('name' => 'game-asset', 'id' => 'game-asset','required' => 'required'));

            ?>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-green col-md-3" value="Adicionar áudio ao jogo" name="btn-add-audio" id="btn-add-audio">
          </div>
          <?= form_close(); ?>
        </div>
        <div class="game-content-list">
          <?php if(isset($audios)): ?>
            <table class="table">
              <thead>
                <tr>
                  <th>Áudio</th>
                  <th>Adicionado em</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($audios as $a): ?>
                  <tr>
                    <td>
                      <audio src="<?= $path_assets . $a->name; ?>" controls></audio>
                    </td>
                    <td><?= display_date($a->inserted_at); ?></td>
                    <td>
                      <a class="btn btn-red btn-small" href="#">Desativar áudio</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
    </div>

  <?php else: ?>
    <div class="alert alert-danger">
      Desculpe, não foi possível carregar os dados do jogo para iniciar a configuração, por favor tente novamente e se o problema persistir <a href="<?= base_url('contato'); ?>">entre em contato</a>.
    </div>
  <?php endif; ?>
</section>
