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
    }

    $this->template->load('pages-template', 'pages/content-game', $data);
  }

  public function editar_jogo($jogo = null)
  {
    $data['page_title'] = 'Editar jogo';
    $this->template->load('pages-template', 'pages/edit-game', $data);
  }

  public function atualizar_jogo($jogo = null)
  {
    $data['page_title'] = 'Atualizar jogo';
    $this->template->load('pages-template', 'pages/edit-game', $data);
  }

}

/* End of file Gerenciador.php */
/* Location: .//home/isanio/projetos/gerador-de-jogos/app/controllers/Gerenciador.php */
