<section class="page-section">

  <div class="row section-header">
    <div class="col-md-8">
      <h1>Novo jogo</h1>
    </div>
    <div class="col-md-4">
      <a class="btn btn-default" href="javascript:history.back();">Voltar</a>
    </div>
  </div>

  <div class="form-container">
    <?php $this->load->view('partials/alert-message'); ?>

    <?php if(isset($validation_errors) && $validation_errors): ?>
      <div class="alert alert-danger">
        <ul>
          <?= validation_errors('<li>', '</li>'); ?>
        </ul>
      </div>
    <?php endif; ?>

    <?= form_open(base_url('gerenciador/novo-jogo'), array('class' => 'form-default'), null); ?>

    <div class="form-group">
      <label for="name">Nome do jogo</label>
      <input type="name" name="name" id="name" class="input-control input-size-medium" value="<?= set_value('name'); ?>" required>
    </div>

    <div class="form-group">
      <label for="type">Tipo de jogo (essa opção não poderá ser alterada depois)</label>
        <?php

        $options = array('' => 'Seleciona uma opção', 1 => 'Jogo para jogar vendo (imagens)', 2 => 'Jogo para jogar ouvindo (sons)');
        echo form_dropdown('type', $options, set_value('type'), array('class' => 'input-control input-size-medium', 'required' => 'required'));

        ?>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-action" title="Criar jogo" id="btn-create-game" name="btn-create-game" value="Criar jogo">
    </div>

    <?= form_close(); ?>
  </div>
</section>
