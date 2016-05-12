<section class="page-section">
  <div class="row section-header">
    <div class="col-md-8">
      <h1>Apagar jogo</h1>
    </div>
    <div class="col-md-4">
      <a class="btn btn-default" href="javascript:history.back();">Voltar</a>
    </div>
  </div>
  <?php $this->load->view('partials/alert-message'); ?>
  <p>
    Tem certeza que deseja apagar esse jogo?
  </p>
  <p>
    <a class="btn btn-action" href="javascript:history.back();">Não, cancelar</a>
    <a class="btn btn-red" href="#">Sim, pode apagar</a>
  </p>
</section>
