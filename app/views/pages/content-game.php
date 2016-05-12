<section class="page-section">
  <div class="row section-header">
    <div class="col-md-8">
      <h1>Configuração do jogo</h1>
    </div>
    <div class="col-md-4">
      <a class="btn btn-default" href="javascript:history.back();">Voltar</a>
    </div>
  </div>

  <?php if(isset($game)): ?>

  <?php else: ?>
    <div class="alert alert-danger">
      Desculpe, não foi possível carregar os dados do jogo para iniciar a configuração, por favor tente novamente e se o problema persistir <a href="<?= base_url('contato'); ?>">entre em contato</a>.
    </div>
  <?php endif; ?>

  <?php $this->load->view('partials/alert-message'); ?>
</section>
