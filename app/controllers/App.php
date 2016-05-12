<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

  public function index()
  {
    $this->template->load('pages-template', 'pages/home-page');
  }

  public function jogo($unique_name = null)
  {
    if(!$unique_name) redirect(base_url(''));

    $data['page_title'] = 'Demo';
    $this->template->load('main-template', 'jogo', $data);
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
