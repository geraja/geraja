<section class="page-section">
  <h1>Criar conta</h1>
  <div class="form-container">
    <?php $this->load->view('partials/alert-message'); ?>
    <?php if(isset($validation_errors) && $validation_errors): ?>
      <div class="alert alert-danger">
        <ul>
          <?= validation_errors('<li>', '</li>'); ?>
        </ul>
      </div>
    <?php endif; ?>
    <?= form_open(base_url('criar-conta'), array('class' => 'form-default'), null); ?>
    <div class="form-group">
      <label for="user-email">Email</label>
      <input type="email" name="user-email" id="user-email" class="input-control input-size-medium" value="<?= set_value('user-email'); ?>" required>
    </div>
    <div class="form-group">
      <label for="user-pass">Senha</label>
      <input type="password" name="user-pass" id="user-pass" class="input-control input-size-medium" required>
    </div>
    <div class="form-group">
      <p>
        <a href="<?= base_url('termos-de-uso'); ?>">Termos de uso</a>
      </p>
      <label for="app-terms" class="custom-checkbox">
        <input type="checkbox" name="app-terms" id="app-terms" required <?php if(set_value('app-terms')) { echo 'checked'; } ?>> Li e concordo com os termos de uso.
      </label>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-action" title="Criar conta" id="btn-create-account" name="btn-create-account" value="Criar minha conta">
    </div>
    <?= form_close(); ?>
  </div>
</section>
