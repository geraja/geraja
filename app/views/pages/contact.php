<section class="page-section">
  <h1>Contato</h1>

  <?php $this->load->view('partials/alert-message'); ?>

  <p>Preencha os campos abaixo para entrar em contato.</p>
  <?= form_open(base_url('contato'), array('class' => 'form-default')); ?>
  <div class="form-group">
    <label for="user-name">Nome</label>
    <input type="text" name="user-name" id="user-name" class="input-control input-size-medium" required>
  </div>
  <div class="form-group">
    <label for="user-email">E-mail para contato</label>
    <input type="email" name="user-email" id="user-email" class="input-control input-size-medium" required>
  </div>
  <div class="form-group">
    <label for="subject">Assunto</label>
    <input type="text" name="subject" id="subject" class="input-control input-size-medium" required>
  </div>
  <div class="form-group">
    <label for="message">Mensagem</label>
    <textarea name="message" id="message" rows="10" class="input-control input-size-medium" required></textarea>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-main" type="submit" name="send-contact" id="send-contact" value="Enviar mensagem">
  </div>
  <?= form_close(); ?>
</section>
