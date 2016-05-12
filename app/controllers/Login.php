<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function index()
  {
    $data['page_title'] = 'Login';
    $this->template->load('pages-template', 'pages/login', $data);
  }

  public function auth()
  {
    $data['page_title'] = 'Login';

    $email = $this->input->post('user-email');
    $pass = $this->input->post('user-pass');

    $this->form_validation->set_rules('user-email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('user-pass', 'Senha', 'trim|required');

    if ($this->form_validation->run() == true) {
      $where = array('email' => $email);
      $user = $this->main_model->get_item('users', $where);

      if($user) {
        $pass_digest = $user['pass'];

        if(crypt($pass, $pass_digest) == $pass_digest) {
          $session_data = array(
            'user' => $user['uid'],
            'logged_in' => true
            );
          $this->session->set_userdata($session_data);

          redirect(base_url('gerenciador'));
        } else {
          $flashdata['alert_message'] = 'Email ou Senha não conferem.';
        }
      } else {
        $flashdata['alert_message'] = 'Email ou Senha não conferem.';
      }

      $flashdata['alert_type'] = 'alert-danger';
      $this->session->set_flashdata($flashdata);
    }

    $this->template->load('pages-template', 'pages/login', $data);
  }

}

/* End of file Login.php */
/* Location: .//home/isanio/projetos/rac/app/controllers/Login.php */
