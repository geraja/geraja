<section class="page-section">
  <?php $game_name = isset($game) ? ' - <span>' . $game['name'] . '</span>' : '';  ?>
  <div class="row section-header">
    <div class="col-md-8">
      <h1>Configuração do jogo<?= $game_name; ?></h1>
    </div>
    <div class="col-md-3 text-right">
      <?php if(isset($assets)): ?>
        <a target="_blank" class="btn btn-green btn-small" href="<?= base_url('jogo/' . $game['code']); ?>">Visualizar o jogo</a>
      <?php endif; ?>
    </div>
    <div class="col-md-1 text-right">
      <a class="btn btn-default" href="<?= base_url('gerenciador'); ?>">Voltar</a>
    </div>
  </div>

  <?php $this->load->view('partials/alert-message'); ?>

  <?php if(isset($game)): ?>
    <?php

    $hiddens = array('id_game' => $game['id_game'], 'question_options' => true);
    $path_assets = base_url('data/' . $game['uid'] . '/' . $game['id_game']) . '/';

    ?>

    <div class="game-config">
      <?php if($game['type'] == 1): ?>
        <div class="game-content">
          <div class="row">
            <div class="col-md-12">
              <h2 class="game-content-title">Imagem da Questão</h2>
            </div>
          </div>

          <div class="game-content-form clearfix">
            <?= form_open_multipart(base_url('gerenciador/adicionar-asset/imagem'), array('class' => 'form-default'), $hiddens); ?>

            <div class="form-group">
              <div class="row">
                <div class="col-md-7">
                  <div class="alert alert-info">
                    <p><b><label for="game-asset">Selecione a imagem que será usada como pergunta nessa questão:</label></b></p>
                  </div>
                </div>
                <div class="col-md-5">
                  <?= form_upload(array('name' => 'game-asset', 'id' => 'game-asset', 'class' => 'input-control', 'required' => 'required')); ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <h2>Configure as alternativas que serão exibidas para o usuário:</h2>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="first-option" class="label-control col-md-1">A</label>
                <input type="text" name="first-option" id="first-option" placeholder="Alternativa A (máximo de 80 caracteres)" class="input-control col-md-10"
                required="required" value="<?= set_value('first-option'); ?>" maxlength="80">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="second-option" class="label-control col-md-1">B</label>
                <input type="text" name="second-option" id="second-option" placeholder="Alternativa B (máximo de 80 caracteres)" class="input-control col-md-10"
                required="required" value="<?= set_value('second-option'); ?>" maxlength="80">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="third-option" class="label-control col-md-1">C</label>
                <input type="text" name="third-option" id="third-option" placeholder="Alternativa C (máximo de 80 caracteres)" class="input-control col-md-10"
                required="required" value="<?= set_value('third-option'); ?>" maxlength="80">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="fourth-option" class="label-control col-md-1">D</label>
                <input type="text" name="fourth-option" id="fourth-option" placeholder="Alternativa D (máximo de 80 caracteres)" class="input-control col-md-10"
                required="required" value="<?= set_value('fourth-option'); ?>" maxlength="80">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="form-group">
                  <span class="col-md-1"></span>
                  <?php

                  $options = array('' => 'Selecione a alternativa correta', 1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D');
                  echo form_dropdown('correct-answer', $options, set_value('correct-answer'), array('class' => 'input-control col-md-3', 'required' => 'required'));

                  ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <span class="col-md-1"></span>
                <input type="submit" class="btn btn-blue col-md-2" value="Cadastrar" name="btn-add-imagem" id="btn-add-imagem">
              </div>
            </div>
            <?= form_close(); ?>
          </div>

          <div class="game-content-list">
            <h2>Questões cadastradas</h2>

            <?php if(isset($assets)): ?>
              <div class="game-questions">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Imagem da questão</th>
                      <th>Alternativas</th>
                      <th>Alternativa Correta</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach($assets as $a): ?>
                      <tr>
                        <td>
                          <img src="<?= $path_assets . $a->name; ?>" alt="Imagem da questão">
                        </td>
                        <td>
                          <b>A - </b> <?= $a->first_option; ?><br>
                          <b>B - </b> <?= $a->second_option; ?><br>
                          <b>C - </b> <?= $a->third_option; ?><br>
                          <b>D - </b> <?= $a->fourth_option; ?>
                        </td>
                        <td>
                          <?php
                          $answers_name = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D');
                          echo $answers_name[$a->correct_answer];
                          ?>
                        </td>
                        <td>
                          <div class="clearfix" style="padding: 0 0 20px;">
                            <?= form_open(base_url('gerenciador/alterar-status/questao'), '', $hiddens); ?>
                              <input type="hidden" name="id_question" id="id_question" value="<?= $a->id_game_question ?>">

                            <?php if($a->active): ?>
                              <input type="hidden" name="question_status" id="question_status" value="0">
                              <button type="submit" class="btn btn-red btn-small" href="<?= base_url('gerenciador/alterar-status/questao'); ?>">Desativar questão</button>
                            <?php else: ?>
                              <input type="hidden" name="question_status" id="question_status" value="1">
                              <button type="submit" class="btn btn-green btn-small" href="<?= base_url('gerenciador/alterar-status/questao'); ?>">Ativar questão</button>
                            <?php endif; ?>

                            <?= form_close(); ?>
                          </div>
                          <a class="btn btn-default btn-small" href="#">Editar</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>

                </table>
              </div>
            <?php endif; ?>

          </div>
        </div>
      <?php endif; ?>

      <?php if($game['type'] == 2): ?>
        <div class="game-content">
          <h2 class="game-content-title">Áudio da Questão</h2>
          <div class="game-content-form clearfix">
            <?= form_open_multipart(base_url('gerenciador/adicionar-asset/audio'), array('class' => 'form-default'), $hiddens); ?>

            <div class="form-group">
              <div class="row">
                <div class="col-md-7">
                  <div class="alert alert-info">
                    <p><b><label for="game-asset">Selecione o áudio que será usada como pergunta nessa questão:</label></b></p>
                  </div>
                </div>
                <div class="col-md-5">
                  <?= form_upload(array('name' => 'game-asset', 'id' => 'game-asset', 'class' => 'input-control', 'required' => 'required')); ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <h2>Configure as alternativas que serão exibidas para o usuário:</h2>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="first-option" class="label-control col-md-1">A</label>
                <?= form_upload(array('name' => 'first-option', 'id' => 'first-option', 'class' => 'input-control col-md-10', 'required' => 'required')); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="second-option" class="label-control col-md-1">B</label>
                <?= form_upload(array('name' => 'second-option', 'id' => 'second-option', 'class' => 'input-control col-md-10', 'required' => 'required')); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="third-option" class="label-control col-md-1">C</label>
                <?= form_upload(array('name' => 'third-option', 'id' => 'third-option', 'class' => 'input-control col-md-10', 'required' => 'required')); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="fourth-option" class="label-control col-md-1">D</label>
                <?= form_upload(array('name' => 'fourth-option', 'id' => 'fourth-option', 'class' => 'input-control col-md-10', 'required' => 'required')); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="form-group">
                  <span class="col-md-1"></span>
                  <?php

                  $options = array('' => 'Selecione a alternativa correta', 1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D');
                  echo form_dropdown('correct-answer', $options, set_value('correct-answer'), array('class' => 'input-control col-md-3', 'required' => 'required'));

                  ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <span class="col-md-1"></span>
                <input type="submit" class="btn btn-blue col-md-2" value="Cadastrar" name="btn-add-audio" id="btn-add-audio">
              </div>
            </div>

            <?= form_close(); ?>
          </div>

          <div class="game-content-list">
            <?php if(isset($assets)): ?>
              <div class="game-questions">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Áudio</th>
                      <th>Áudios de Alternativas</th>
                      <th>Resposta</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach($assets as $a): ?>
                      <tr>
                        <td>
                          <div><audio src="<?= $path_assets . $a->name; ?>" controls></audio></div>
                        </td>
                        <td>
                          <div>
                            <span class="col-md-1">A.</span><audio src="<?= $path_assets . $a->first_option; ?>" controls></audio>
                          </div>
                          <div>
                            <span class="col-md-1">B.</span><audio src="<?= $path_assets . $a->second_option; ?>" controls></audio>
                          </div>
                          <div>
                            <span class="col-md-1">C.</span><audio src="<?= $path_assets . $a->third_option; ?>" controls></audio>
                          </div>
                          <div>
                            <span class="col-md-1">D.</span><audio src="<?= $path_assets . $a->fourth_option; ?>" controls></audio>
                          </div>
                        </td>
                        <td>
                          <?php
                          $answers_name = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D');
                          echo $answers_name[$a->correct_answer];
                          ?>
                        </td>
                        <td>
                          <div class="clearfix" style="padding: 0 0 20px;">
                            <?= form_open(base_url('gerenciador/alterar-status/questao'), '', $hiddens); ?>
                              <input type="hidden" name="id_question" id="id_question" value="<?= $a->id_game_question ?>">

                            <?php if($a->active): ?>
                              <input type="hidden" name="question_status" id="question_status" value="0">
                              <button type="submit" class="btn btn-red btn-small" href="<?= base_url('gerenciador/alterar-status/questao'); ?>">Desativar questão</button>
                            <?php else: ?>
                              <input type="hidden" name="question_status" id="question_status" value="1">
                              <button type="submit" class="btn btn-green btn-small" href="<?= base_url('gerenciador/alterar-status/questao'); ?>">Ativar questão</button>
                            <?php endif; ?>

                            <?= form_close(); ?>
                          </div>
                          <a class="btn btn-default btn-small" href="#">Editar</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>

                </table>
              </div>

            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

  <?php else: ?>
    <div class="alert alert-danger">
      Desculpe, não foi possível carregar os dados do jogo para iniciar a configuração, por favor tente novamente e se o problema persistir <a href="<?= base_url('contato'); ?>">entre em contato</a>.
    </div>
  <?php endif; ?>
</section>
