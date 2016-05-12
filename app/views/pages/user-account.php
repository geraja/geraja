<section class="page-section">
  <h1>Minha conta</h1>
  <div class="form-container">
    <?php $this->load->view('partials/alert-message'); ?>
    <?php if(isset($validation_errors) && $validation_errors): ?>
      <div class="alert alert-danger">
        <ul>
          <?= validation_errors('<li>', '</li>'); ?>
        </ul>
      </div>
    <?php endif; ?>
    <?= form_open(base_url('gerenciador/minha-conta'), array('class' => 'form-default'), null); ?>
    <div class="form-group">
      <label for="firstname">Nome</label>
      <input type="text" name="firstname" id="firstname" class="input-control input-size-medium" value="<?= $user['firstname']; ?>" required>
    </div>
    <div class="form-group">
      <label for="lastname">Sorenome</label>
      <input type="text" name="lastname" id="lastname" class="input-control input-size-medium" value="<?= $user['lastname']; ?>" required>
    </div>
    <div class="form-group">
      <label for="user-email">Email</label>
      <input type="email" name="user-email" id="user-email" class="input-control input-size-medium" value="<?= $user['email']; ?>" required disabled>
    </div>
    <!--
     <div class="form-group">
      <label for="user-pass">Senha</label>
      <input type="password" name="user-pass" id="user-pass" class="input-control input-size-medium" required>
    </div> -->
    <div class="form-group">
      <input type="submit" class="btn btn-action" title="Criar conta" id="btn-update-account" name="btn-update-account" value="Atualizar meus dados">
    </div>
    <?= form_close(); ?>
  </div>
</section>
