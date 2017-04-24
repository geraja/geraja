<section class="page-section">
  <div class="row section-header">
    <div class="col-md-8">
      <h1>Painel Administrativo</h1>
    </div>
  </div>

  <?php $this->load->view('partials/alert-message'); ?>

  <?php if(isset($games)): ?>
    <p>Total de jogos (<?= $total_games; ?>)</p>

    <div class="table-reponsive">
      <table class="table">
        <thead>
          <th>Nome</th>
          <th>Tipo</th>
          <th>Publicado</th>
          <th>Criado em</th>
          <th></th>
          <th></th>
          <th></th>
        </thead>
        <tbody>
          <?php foreach($games as $g): ?>
            <tr>
              <td><?= $g->name; ?></td>
              <td>
                <?= $g->type == 1 ? 'Jogar Vendo' : 'Jogar Ouvindo'; ?>
              </td>
              <td>
                <?= $g->active == 1 ? 'Sim' : 'Não'; ?>
              </td>
              <td><?= display_date($g->inserted_at); ?></td>
              <td></td>
              <td></td>
              <td>
                <a target="_blank" class="btn btn-small btn-link" href="<?= base_url('jogo/' . $g->code); ?>">Visualizar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

       <?php if(isset($pagination)): ?>
	    <div class="pagination">
	      <?= $pagination; ?>
	     </div>
	  <?php endif; ?>

    </div>
  <?php else: ?>
    <p>Vocẽ ainda não criou nenhum jogo.</p>
  <?php endif; ?>
</section>
