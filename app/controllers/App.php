<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

  public function index()
  {
    $data['title'] = 'Página Inicial';
    $this->template->load('main-template', 'pagina-inicial', $data);
  }

  public function jogo($unique_name = null)
  {
    if(!$unique_name) redirect(base_url(''));
  }

}

/* End of file App.php */
/* Location: .//home/isanio/projetos/gerador-de-jogos/app/controllers/App.php */
