<?php defined('BASEPATH') || exit('No direct script access allowed');

class Auth extends CI_Session {

	public $logged_in = false;

	public function __construct() {
		$this->is_logged_in();
	}

	public function is_logged_in() {

		$logged = $this->userdata('logged_in');

		$this->logged_in = ($logged) ? true : false;

		// Instancia do Codeigniter
		$CI =& get_instance();

		// Páginas que podem ser acessadas sem necessidade de um usuário autenticado
		$public_pages = array();

		// Classe e método acessado
		$controller = $CI->router->class;
		$app_method = $CI->router->method;

		// Verifica se o usuário está logado
		if(!$logged) {
			if(($controller === 'gerenciador' || $controller === 'admin') && !in_array($app_method, $public_pages)) {
				// Redireciona o usuário para o login
				redirect(base_url('login'));
			}

		}
	}

}
