<section class="page-section">
  <h1>Login</h1>
  <div class="form-container">
    <?php $this->load->view('partials/alert-message'); ?>
    <?= form_open(base_url('login/auth'), array('class' => 'form-default')); ?>
    <div class="form-group">
      <label for="user-email">Email</label>
      <input type="email" name="user-email" id="user-email" class="input-control input-size-medium" required>
    </div>
    <div class="form-group">
      <label for="user-pass">Senha</label>
      <input type="password" name="user-pass" id="user-pass" class="input-control input-size-medium" required>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-action" title="Entrar" id="btn-login" name="btn-login" value="Entrar">
    </div>
    <?= form_close(); ?>
  </div>
  <p>
    <a href="<?= base_url('criar-conta'); ?>">Ainda não tem conta? Cadastre-se grátis.</a>
  </p>
</section>
