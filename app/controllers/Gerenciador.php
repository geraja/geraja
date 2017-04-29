<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gerenciador extends CI_Controller {

  var $uid;

  public function __construct()
  {
    parent::__construct();
    $this->uid = $this->session->userdata('user');

    if($this->_is_admin()) {
      $this->session->set_userdata(array('is_admin' => true));
    } else {
      $this->session->unset_userdata('is_admin');
    }

    // error_reporting(-1);
    // ini_set('display_errors', 1);
  }

  public function index($offset = 1)
  {
    $data['page_title'] = 'Meus Jogos';

    // Configuração da paginação
    $per_pages = 30;

    $where = array('uid' => $this->uid);
    $games = $this->main_model->get_items('games', $where, $per_pages, 0, 'id_game', 'desc');

    if($games) {
      $data['games'] = $games;
    }

    $this->template->load('pages-template', 'pages/panel', $data);
  }

  public function minha_conta()
  {
    $data['page_title'] = 'Minha conta';

    $where = array('uid' => $this->uid);
    $user = $this->main_model->get_item('users', $where);

    if($user) {
      $data['user'] = $user;

      // Atualizar conta
      $update_account = $this->input->post('btn-update-account');

      if($update_account) {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');

        $this->form_validation->set_rules('firstname', 'Nome', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Sobrenome', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
          $object_update = array('firstname' => $firstname, 'lastname' => $lastname);
          $update_user = $this->main_model->update_item('users', $where, $object_update);

          if($update_user) {
            $flashdata['alert_type'] = 'alert-success';
            $flashdata['alert_message'] = 'Os dados da sua conta foram atualizados com sucesso.';
            $this->session->set_flashdata($flashdata);
            redirect(base_url('gerenciador'));
          }
        }
      }

    } else {
      $flashdata['alert_type'] = 'alert-warning';
      $flashdata['alert_message'] = 'Não foi possível carregar os dados da sua conta, por favor tente novamente mais tarde.';
      $this->session->set_flashdata($flashdata);
      redirect(base_url('gerenciador'));
    }

    $this->template->load('pages-template', 'pages/user-account', $data);
  }

  public function novo_jogo()
  {
    $data['page_title'] = 'Novo jogo';

    $create_game = $this->input->post('btn-create-game');

    if($create_game) {
      $name = $this->input->post('name');
      $type = $this->input->post('type');

      if($name && $type) {
        $game_code = random_code(10, $this->main_model->get_last_id_game()); // random_code(length, merge)

        $object_insert = array(
          'uid' => $this->uid,
          'name' => $name,
          'code' => $game_code,
          'type' => $type,
          'engine' => 2,
          );

        $save_game = $this->main_model->insert_item('games', $object_insert);

        if($save_game) {
          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = "O jogo <b>$name</b> foi criado com sucesso!.";
          $this->session->set_flashdata($flashdata);
          redirect(base_url('gerenciador/jogo/' . $save_game),'refresh');
        } else {
          $flashdata['alert_type'] = 'alert-danger';
          $flashdata['alert_message'] = 'Não foi possível criar o jogo, por favor tente novamente.';
          $this->session->set_flashdata($flashdata);
        }
      }
    }

    $this->template->load('pages-template', 'pages/new-game', $data);
  }

  public function jogo($jogo = null)
  {
    $data['page_title'] = 'Configuração do Jogo';

    $where = array('id_game' => $jogo, 'uid' => $this->uid);
    $game = $this->main_model->get_item('games', $where);

    if($game) {
      $data['game'] = $game;

      $assets_where = array('game_questions.id_game' => $game['id_game']);
      $assets = $this->main_model->get_game_questions($assets_where, null, 0, 'game_questions.id_asset', 'desc');

      if($assets) $data['assets'] = $assets;
    }

    $this->template->load('pages-template', 'pages/content-game-engine-2', $data);
  }

  public function adicionar_asset($tipo = null)
  {
    switch ($tipo) {
      case 'imagem':
      $btn = $this->input->post('btn-add-imagem');

      if($btn) {
        $this->_adicionar_imagem();
      }
      break;

      case 'audio':
      $btn = $this->input->post('btn-add-audio');

      if($btn) {
        $this->_adicionar_audio();
      }
      break;
    }
  }

  private function _adicionar_imagem()
  {
    $id_game = $this->input->post('id_game');
    $this->form_validation->set_rules('id_game', 'Imagem', 'required');

    $question_options = $this->input->post('question_options');
    $first_option = $this->input->post('first-option');
    $second_option = $this->input->post('second-option');
    $third_option = $this->input->post('third-option');
    $fourth_option = $this->input->post('fourth-option');
    $correct_answer = $this->input->post('correct-answer');
    $images_options = $this->input->post('images-as-options');

    // Essa validação é apenas para a Engine 2 onde o usuário cadastra as alternativas
    // Ao contrário da Engine 1 que gera as alternativas de forma automatica e aleatoria.
    if($question_options && !$images_options) {
      $this->form_validation->set_rules('first-option', 'Cadastre a Alternativa A', 'required');
      $this->form_validation->set_rules('second-option', 'Cadastre a Alternativa B', 'required');
      $this->form_validation->set_rules('third-option', 'Cadastre a Alternativa C', 'required');
      $this->form_validation->set_rules('fourth-option', 'Cadastre a Alternativa D', 'required');
      $this->form_validation->set_rules('correct-answer', 'Selecione a alternativa correta', 'required');
    }

    if ($this->form_validation->run() == TRUE) {

      $user_folder = user_folder($this->uid);
      $game_folder = game_folder($id_game, $this->uid);

      $this->load->library('upload');

      $config['upload_path'] = $game_folder;
      $config['allowed_types'] = 'png|jpg|jpeg';
      $config['min_width'] = 60;
      $this->upload->initialize($config);

      if($this->upload->do_upload('game-asset')){

        $image = $this->upload->data();

        $object_insert = array(
          'id_game' => $id_game,
          'name' => $image['file_name'],
          'type' => 1,
          'active' => 1,
          );

        $save = $this->main_model->insert_item('assets', $object_insert);

        if($save) {
          $id_asset = $save;

          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = 'A imagem foi adicionada com sucesso!';

          if($question_options) {

            if($images_options) {

              $this->upload->initialize($config);
              if($this->upload->do_upload('first-option')) {

                $question_image = $this->upload->data();
                $first_option = $question_image['file_name'];

                $this->_resize_question_image($question_image);
              }

              $this->upload->initialize($config);
              if($this->upload->do_upload('second-option')) {

                $question_image = $this->upload->data();
                $second_option = $question_image['file_name'];

                $this->_resize_question_image($question_image);
              }

              $this->upload->initialize($config);
              if($this->upload->do_upload('third-option')) {

                $question_image = $this->upload->data();
                $third_option = $question_image['file_name'];

                $this->_resize_question_image($question_image);
              }

              $this->upload->initialize($config);

              if($this->upload->do_upload('fourth-option')) {

                $question_image = $this->upload->data();
                $fourth_option = $question_image['file_name'];

                $this->_resize_question_image($question_image);
              }

            }

            $object_insert = array(
              'id_game' => $id_game,
              'id_asset' => $id_asset,
              'first_option' => $first_option,
              'second_option' => $second_option,
              'third_option' => $third_option,
              'fourth_option' => $fourth_option,
              'correct_answer' => $correct_answer
              );

              if($images_options) $object_insert['type'] = 2;

            $save_question = $this->main_model->insert_item('game_questions', $object_insert);

            if($save_question) {
              $flashdata['alert_message'] = 'A questão foi adicionada com sucesso!';
            } else {
              $flashdata['alert_type'] = 'alert-danger';
              $flashdata['alert_message'] = 'Ocorreu um erro ao tentar cadastrar a <b>Questão</b>, por favor tente novamente.';
            }
          }

          // Ajuste do tamanho da imagem
          $width_control = 32;
          $height_control = 400;

          if($question_options) {
            $width_control = 500;
            $height_control = 500;
          }

          if($image['image_width'] > $width_control || $image['image_height'] > $height_control) {
            $this->load->library('image_lib');

            $config['image_library'] = 'gd2';
            $config['source_image'] = "$game_folder/" . $image['file_name'];
            $config['create_thumb'] = false;
            $config['master_dim'] = 'width';
            $config['maintain_ratio'] = true;
            $config['width'] = $width_control;
            $config['height'] = $width_control;

            $this->image_lib->initialize($config);

            $this->image_lib->resize();
          }
        } else {
          $flashdata['alert_type'] = 'alert-danger';
          $flashdata['alert_message'] = 'O correu um erro ao salvar a imagem no banco de dados, por favor tente novamente.';
        }
      } else {
        $flashdata['alert_type'] = 'alert-danger';
        $flashdata['alert_message'] = $this->upload->display_errors();
      }

    } else {
      $flashdata['alert_type'] = 'alert-danger';
      $flashdata['alert_message'] = 'Não foi possível carregar a imagem, por favor tente novamente.';
    }

    $this->session->set_flashdata($flashdata);
    redirect(base_url('gerenciador/jogo/' . $id_game));
  }

  private function _resize_question_image($image = null) {
    if(is_array($image) && isset($image['image_width']) && isset($image['image_height'])) {

      $width_control = 400;
      $height_control = 400;

      if($image['image_width'] > $width_control || $image['image_height'] > $height_control) {
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = $image['full_path'];
        $config['create_thumb'] = false;
        $config['master_dim'] = 'width';
        $config['maintain_ratio'] = true;
        $config['width'] = $width_control;
        $config['height'] = $width_control;

        $this->image_lib->initialize($config);

        $this->image_lib->resize();
      }

    } else {
      return null;
    }
  }

  private function _adicionar_audio()
  {
    $id_game = $this->input->post('id_game');
    $this->form_validation->set_rules('id_game', 'Áudio', 'required');

    $question_options = $this->input->post('question_options');
    $first_option = $this->input->post('first-option');
    $second_option = $this->input->post('second-option');
    $third_option = $this->input->post('third-option');
    $fourth_option = $this->input->post('fourth-option');
    $correct_answer = $this->input->post('correct-answer');

    if ($this->form_validation->run() == TRUE) {

      $user_folder = user_folder($this->uid);
      $game_folder = game_folder($id_game, $this->uid);

      $config['upload_path'] = $game_folder;
      $config['allowed_types'] = 'mp3';

      $this->load->library('upload', $config);

      if($this->upload->do_upload('game-asset')){

        $audio = $this->upload->data();

        $object_insert = array(
          'id_game' => $id_game,
          'name' => $audio['file_name'],
          'type' => 2,
          'active' => 1,
          );

        $save = $this->main_model->insert_item('assets', $object_insert);

        if($save) {
          $id_asset = $save;

          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = 'O áudio foi adicionada com sucesso!';

          if($question_options) {

            $this->upload->initialize($config);

            if($this->upload->do_upload('first-option')) {

              $audio = $this->upload->data();
              $first_audio = $audio['file_name'];
            }

            $this->upload->initialize($config);

            if($this->upload->do_upload('second-option')) {

              $audio = $this->upload->data();
              $second_audio = $audio['file_name'];
            }

            $this->upload->initialize($config);

            if($this->upload->do_upload('third-option')) {
              $audio = $this->upload->data();
              $third_audio = $audio['file_name'];
            }

            if($this->upload->do_upload('fourth-option')) {
              $audio = $this->upload->data();
              $fourth_audio = $audio['file_name'];
            }

            $object_insert = array(
              'id_game' => $id_game,
              'id_asset' => $id_asset,
              'first_option' => $first_audio,
              'second_option' => $second_audio,
              'third_option' => $third_audio,
              'fourth_option' => $fourth_audio,
              'correct_answer' => $correct_answer
              );

            $save_question = $this->main_model->insert_item('game_questions', $object_insert);

            if($save_question) {
              $flashdata['alert_message'] = 'A questão foi adicionada com sucesso!';
            } else {
              $flashdata['alert_type'] = 'alert-danger';
              $flashdata['alert_message'] = 'Ocorreu um erro ao tentar cadastrar a <b>Questão</b>, por favor tente novamente.';
            }
          }
        } else {
          $flashdata['alert_type'] = 'alert-danger';
          $flashdata['alert_message'] = 'O correu um erro ao salvar a imagem no banco de dados, por favor tente novamente.';
        }
      } else {
        $flashdata['alert_type'] = 'alert-danger';
        $flashdata['alert_message'] = $this->upload->display_errors();
      }

    } else {
      $flashdata['alert_type'] = 'alert-danger';
      $flashdata['alert_message'] = 'Não foi possível carregar o áudio, por favor tente novamente.';
    }

    $this->session->set_flashdata($flashdata);
    redirect(base_url('gerenciador/jogo/' . $id_game));
  }

  public function editar_jogo($jogo = null)
  {
    $data['page_title'] = 'Editar jogo';

    $where = array('id_game' => $jogo, 'uid' => $this->uid);
    $game = $this->main_model->get_item('games', $where);

    if($game) {
      $data['game'] = $game;
    }

    $this->template->load('pages-template', 'pages/edit-game', $data);
  }

  public function atualizar_jogo($jogo = null)
  {
    $data['page_title'] = 'Atualizar jogo';
    $update_game = $this->input->post('btn-update-game');

    if($update_game) {
      $id_game = $this->input->post('id_game');
      $name = $this->input->post('name');
      $active = $this->input->post('active');

      if($name && $id_game) {

        $object_update = array('name' => $name, 'active' => $active);
        $where = array('id_game' => $id_game, 'uid' => $this->uid);

        $save_game = $this->main_model->update_item('games', $where, $object_update);

        if($save_game) {
          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = "O jogo <b>$name</b> foi atualizado com sucesso!.";
          $this->session->set_flashdata($flashdata);
        } else {
          $flashdata['alert_type'] = 'alert-danger';
          $flashdata['alert_message'] = 'Não foi possível atualizar o jogo, por favor tente novamente.';
          $this->session->set_flashdata($flashdata);
        }
      }
    }

    redirect(base_url('gerenciador'));
  }

  public function alterar_status($tipo = null)
  {
    if($tipo) {
      switch ($tipo) {
        case 'questao':
          $question_status = $this->input->post('question_status');
          $question_status = intval($question_status);
          $id_game = $this->input->post('id_game');
          $id_question = $this->input->post('id_question');

          if($question_status !== null && $id_game && $id_question) {

            $object_update = array('active' => $question_status);
            $where = array('id_game' => $id_game, 'id_game_question' => $id_question);

            $update_question = $this->main_model->update_item('game_questions', $where, $object_update);

            if($update_question) {
              $flashdata['alert_type'] = 'alert-success';
              $flashdata['alert_message'] = "O status da questão foi atualizado com sucesso!.";
              $this->session->set_flashdata($flashdata);
            } else {
              $flashdata['alert_type'] = 'alert-danger';
              $flashdata['alert_message'] = 'Não foi possível o status da questão, por favor tente novamente.';
              $this->session->set_flashdata($flashdata);
            }

            redirect(base_url("gerenciador/jogo/$id_game"));
          } else {
            $flashdata['alert_type'] = 'alert-danger';
              $flashdata['alert_message'] = 'Não foi possível carregar os dados para atualziar o status da questão, por favor tente novamente.';
              $this->session->set_flashdata($flashdata);
            redirect(base_url("gerenciador/jogo/$id_game"));
          }
          break;
      }
    } else {
      redirect(base_url('gerenciador'));
    }
  }

  public function admin($page = 1) {
    if(!$this->_is_admin()) {
      redirect('gerenciador');
    }

    $data['page_title'] = 'Painel Administrativo';

    // Configuração da paginação
    $per_pages = 20;
    $offset = $per_pages * ($page - 1);

    $where = null;
    $games = $this->main_model->get_items('games', $where, $per_pages, $offset, '', 'desc');

    if($games) {
      $data['games'] = $games;
    }

    $total_games = $this->main_model->get_total_items('games');
    $data['total_games'] = $total_games;

    $this->load->library('pagination');
    $config['base_url'] = base_url('gerenciador/admin/') ;
    $config['total_rows'] = $total_games;
    $config['per_page'] = $per_pages;
    $config['use_page_numbers'] = TRUE;
    $config['num_links'] = 10;
    $config['first_link'] = 'Início';
    $config['last_link'] = 'Fim';

    $this->pagination->initialize($config);
    $data['pagination'] = $this->pagination->create_links();

    $this->template->load('pages-template', 'pages/admin', $data);
  }

  private function _is_admin() {
    $where = array('uid' => $this->uid);
    return $this->main_model->get_item('users_admin', $where);
  }

}

/* End of file Gerenciador.php */
/* Location: .//home/isanio/projetos/gerador-de-jogos/app/controllers/Gerenciador.php */
