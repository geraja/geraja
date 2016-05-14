<section class="page-section">
  <div class="row section-header">
    <div class="col-md-8">
      <h1>Editar jogo</h1>
    </div>
    <div class="col-md-4">
      <a class="btn btn-default" href="javascript:history.back();">Voltar</a>
    </div>
  </div>

  <?php $this->load->view('partials/alert-message'); ?>
  <?php if(isset($game)): ?>
    <div class="form-container">
      <?php $this->load->view('partials/alert-message'); ?>

      <?php if(isset($validation_errors) && $validation_errors): ?>
        <div class="alert alert-danger">
          <ul>
            <?= validation_errors('<li>', '</li>'); ?>
          </ul>
        </div>
      <?php endif; ?>

      <?= form_open(base_url('gerenciador/atualizar-jogo/' . $game['id_game']), array('class' => 'form-default'), array('id_game' => $game['id_game'])); ?>

      <div class="form-group">
        <label for="name">Nome do jogo</label>
        <input type="name" name="name" id="name" class="input-control input-size-medium" value="<?= $game['name']; ?>">
      </div>
      <div class="form-group">
        <label for="active">Tornar o jogo público para outros usuários acessarem?</label>
        <?php

        $options = array(0 => 'Não, ainda vou finalizar o jogo', 1 => 'Sim, o jogo já está pronto');
        echo form_dropdown('active', $options, $game['active'], array('class' => 'input-control'));

        ?>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-action" title="Atualizar jogo" id="btn-update-game" name="btn-update-game" value="Atualizar jogo">
      </div>

      <?= form_close(); ?>
    </div>
  <?php else: ?>
    <div class="alert alert-danger">
    Desculpe, não foi possível carregar os dados do jogo para iniciar a edição, por favor tente novamente e se o problema persistir <a href="<?= base_url('contato'); ?>">entre em contato</a>.
    </div>
  <?php endif; ?>
</section>
