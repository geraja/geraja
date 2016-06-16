<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

  public function index()
  {
    $per_page = 4;
    $data = array();

    $where = array('active' => 1);
    $games = $this->main_model->get_items('games', $where, $per_page, 0, 'id_game', 'desc');

    if($games) {
      $data['games'] = $games;
    }



    $this->template->load('pages-template', 'pages/home-page', $data);
  }

  public function jogos($page = 1)
  {
    $data['page_title'] = 'Jogos';

    // Configuração da paginação
    $per_page = 20;
    $offset = $per_page * ($page - 1);

    $where = array('active' => 1);
    $games = $this->main_model->get_items('games', $where, $per_page, $offset, 'id_game', 'desc');

    $total_games = 0;

    if($games) {
      $data['games'] = $games;

      $total_games = $this->main_model->get_total_items('games', $where);
      $this->load->library('pagination');

      $config['base_url'] = base_url('jogos');
      $config['total_rows'] = $total_games;
      $config['use_page_numbers'] = true;
      $config['num_links'] = 10;
      $config['first_link'] = 'Início';
      $config['last_link'] = 'Fim';
      $config['per_page'] = $per_page;

      $this->pagination->initialize($config);

      $pagination = $this->pagination->create_links();

      if($pagination) {
        $data['pagination'] = $pagination;
      }
    }

    $data['total_games'] = $total_games;

    $this->template->load('pages-template', 'pages/list-games', $data);
  }

  public function jogo($unique_name = null)
  {
    if(!$unique_name) redirect(base_url(''));
    $data['page_title'] = 'Demo';
    $assets_url = false;

    $where = array('code' => $unique_name);
    $game = $this->main_model->get_item('games', $where);

    if($game) {
      // Verificar se o jogo é público.
      $uid = $this->session->userdata('user');

      if(!$game['active'] && $game['uid'] !== $uid) {
        $data['error'] = true;
        $data['error_message'] = 'Não foi possível acessar o jogo. Provavelmente o jogo ainda não foi publicado.';
      }

      $data['game'] = $game;
      $data['page_title'] = 'Jogo: '. $game['name'];
      $assets_url ='../data/' . $game['uid'] . '/' . $game['id_game'] . '/';

      if($game['engine'] == 1) {
        $images = $this->main_model->get_items('assets', array('id_game' => $game['id_game'], 'type' => 1, 'active' => 1));
        if($images) {
          $data['images'] = $images;
        } else {
          if($game['type'] == 1) {
            $data['error'] = true;
            $data['error_message'] = 'Não foi possível carregar os dados do jogo, por favor tente novamente.';
          }
        }

        $audios = $this->main_model->get_items('assets', array('id_game' => $game['id_game'], 'type' => 2, 'active' => 1));

        if($audios) {
          $data['audios'] = $audios;
        } else {
          if($game['type'] == 2) {
            $data['error'] = true;
            $data['error_message'] = 'Não foi possível carregar os dados do jogo, por favor tente novamente.';
          }
        }
      } else if($game['engine'] == 2) {
        $assets_where = array('game_questions.id_game' => $game['id_game'], 'game_questions.active' => 1);
        $assets = $this->main_model->get_game_questions($assets_where, null, 0, 'game_questions.id_asset', 'desc');

        if($assets) {
          $data['questions'] = $assets;

          if($game['type'] == 1) {
            // Jogar vendo(imagens)
            $data['images'] = $assets;
          } else {
            // Jogar ouvindo(audios)
            $data['audios'] = $assets;
          }
        }
      }
    }

    $data['assets_url'] = $assets_url;
    $this->template->load('game-template', 'jogo', $data);
  }

  public function sobre()
  {
    $data['page_title'] = 'Sobre';
    $this->template->load('pages-template', 'pages/about', $data);
  }

  public function criar_conta()
  {
    $data['page_title'] = 'Criar conta';

    $create_user = $this->input->post('btn-create-account');

    if($create_user) {
      // Mensagem de alerta padrão
      $flashdata['alert_type'] = 'alert-danger';

      $user_email = $this->input->post('user-email');
      $user_pass = $this->input->post('user-pass');
      $app_terms = $this->input->post('app-terms');

      $this->form_validation->set_rules('user-email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
      $this->form_validation->set_rules('user-pass', 'Senha', 'trim|required|min_length[6]');
      $this->form_validation->set_rules('app-terms', 'Termos de uso', 'required');

      if ($this->form_validation->run() == true) {
        $salt = sha1(mt_rand());
        $pass_digest = crypt($user_pass, '$2a$12$' . $salt);
        $user_code = random_code(10, $this->main_model->get_last_uid()); // random_code(length, merge)

        $data_insert = array('email' => $user_email, 'pass' => $pass_digest, 'code' => $user_code);
        $create_account = $this->main_model->insert_item('users', $data_insert);

        if($create_account) {
          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = 'A sua conta foi criada com sucesso!<br>Você já pode acessar a sua conta e gerar novos jogos.';
          $this->session->set_flashdata($flashdata);

          redirect(base_url('login'));
        } else {
          $flashdata['alert_message'] = 'Desculpe, ocorreu algum erro e não foi possível criar a sua conta, por favor tente novamente.';
        }
      } else {
        $data['validation_errors'] = true;
      }

      $this->session->set_flashdata($flashdata);
    }

    $this->template->load('pages-template', 'pages/new-user', $data);
  }

  public function termos_de_uso()
  {
    $data['page_title'] = 'Termos de uso';
    $this->template->load('pages-template', 'pages/terms', $data);
  }

  public function contato()
  {
    $data['page_title'] = 'Contato';
    $this->template->load('pages-template', 'pages/contact', $data);
  }

  public function sair()
  {
    $this->session->sess_destroy();
    redirect(base_url());
  }

}

/* End of file App.php */
/* Location: .//home/isanio/projetos/gerador-de-jogos/app/controllers/App.php */
