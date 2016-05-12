<section class="page-section">
  <header class="row section-header">
    <div class="col-md-8">
      <h1>Painel de controle</h1>
    </div>
    <div class="col-md-4">
      <a class="btn btn-green" href="<?= base_url('gerenciador/novo-jogo'); ?>">Criar novo jogo</a>
    </div>
  </header>
  <?php $this->load->view('partials/alert-message'); ?>

  <?php if(isset($games)): ?>
    <p>Seus jogos (<?= count($games); ?>)</p>

    <div class="table-reponsive">
      <table class="table">
        <thead>
          <th>#id</th>
          <th>Nome</th>
          <th>Público</th>
          <th>Criado em</th>
          <th></th>
        </thead>
        <tbody>
          <?php foreach($games as $g): ?>
            <tr>
              <td><?= $g->id_game; ?></td>
              <td><?= $g->name; ?></td>
              <td>
                <?= $g->active == 1 ? 'Sim' : 'Não'; ?>
              </td>
              <td><?= display_date($g->inserted_at); ?></td>
              <td>
                <a href="<?= base_url('gerenciador/jogo/' . $g->id_game); ?>" class="btn btn-small btn-blue">Configurar</a>
                <a href="<?= base_url('gerenciador/editar-jogo/' . $g->id_game); ?>" class="btn btn-small btn-default">Editar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p>Vocẽ ainda não criou nenhum jogo.</p>
  <?php endif; ?>
</section>
