<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gerenciador extends CI_Controller {

  var $uid;

  public function __construct()
  {
    parent::__construct();
    $this->uid = $this->session->userdata('user');
  }

  public function index($offset = 1)
  {
    $data['page_title'] = 'Painel de controle';

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

      if($name) {
        $game_code = random_code(10, $this->main_model->get_last_id_game()); // random_code(length, merge)

        $object_insert = array(
          'uid' => $this->uid,
          'name' => $name,
          'code' => $game_code,
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
      /*
      |-----------
      | Assets
      |-----------
      */
      /* images */
      $images = $this->main_model->get_items('assets', array('id_game' => $game['id_game'], 'type' => 1));
      if($images) $data['images'] = $images;

      /* Audios */
      $audios = $this->main_model->get_items('assets', array('id_game' => $game['id_game'], 'type' => 2));
      if($audios) $data['audios'] = $audios;
    }

    $this->template->load('pages-template', 'pages/content-game', $data);
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

    if ($this->form_validation->run() == TRUE) {

      $user_folder = user_folder($this->uid);
      $game_folder = game_folder($id_game, $this->uid);

      $config['upload_path'] = $game_folder;
      $config['allowed_types'] = 'png|jpg';
      $config['min_width'] = 16;

      $this->load->library('upload', $config);

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
          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = 'A imagem foi adicionada com sucesso!';

          // Ajuste do tamanho da imagem
          if($image['image_width'] > 32 || $image['image_height'] > 400) {
            $this->load->library('image_lib');

            $config['image_library'] = 'gd2';
            $config['source_image'] = "$game_folder/" . $image['file_name'];
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = true;
            $config['width'] = 32;
            $config['height'] = 32;

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

  private function _adicionar_audio()
  {
    $id_game = $this->input->post('id_game');
    $this->form_validation->set_rules('id_game', 'Áudio', 'required');

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
          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = 'O áudio foi adicionada com sucesso!';
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

}

/* End of file Gerenciador.php */
/* Location: .//home/isanio/projetos/gerador-de-jogos/app/controllers/Gerenciador.php */
