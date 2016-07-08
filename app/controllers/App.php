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

    $send_contact = $this->input->post('send-contact');

    if($send_contact) {
      $user_name = $this->input->post('user-name');
      $user_email = $this->input->post('user-email');
      $subject = $this->input->post('subject');
      $message = $this->input->post('message');

      $this->form_validation->set_rules('user-name', 'Nome', 'trim|required');
      $this->form_validation->set_rules('user-email', 'E-mail', 'trim|required');
      $this->form_validation->set_rules('subject', 'Assunto', 'trim|required');
      $this->form_validation->set_rules('message', 'Mensagem', 'trim|required');

      $flashdata['alert_type'] = 'alert-danger';

      if ($this->form_validation->run() == true) {
        $send_email = true;

        $this->load->library('email');

        $this->email->from($user_email, $user_name);
        $this->email->to('isanioweb@gmail.com');

        $email_body = "<p>Contato realizado pelo site " . base_url() . '.</p>';
        $email_body .= "<p><b>Nome:</b> $user_name<br>";
        $email_body .= "<b>E-mail:</b> $user_email<br>";
        $email_body .= "<b>Assunto:</b> $subject";
        $email_body .= "</p>";
        $email_body .= "<p>";
        $email_body .= "<b>Mensagem:</b><br>";
        $email_body .= "$message";
        $email_body .= "</p>";

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from('no-reply@geraja.com.br', $user_name);
        $this->email->reply_to($user_email, $user_name);
        // $this->email->to('isanioweb@gmail.com');
        $this->email->to('maryandrioli@gmail.com');
        $this->email->subject('Novo mensagem da plataforma GeraJa');
        $this->email->message($email_body);

        if($this->email->send()) {
          $flashdata['alert_type'] = 'alert-success';
          $flashdata['alert_message'] = 'A sua mensagem foi enviada com sucesso!<br>Entraremos em contato em breve.';
          $this->session->set_flashdata($flashdata);
        } else {
          $flashdata['alert_message'] = 'Desculpe, não foi possível enviar a mensagem, por favor tente novamente.';
        }
      } else {
        $data['validation_errors'] = true;
        $flashdata['alert_message'] = 'Preencha todos os campos.';
      }

      $this->session->set_flashdata($flashdata);
    }

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
