<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {

 protected $ci;

 public function __construct()
 {
  $this->ci =& get_instance();
 }

 function load($template, $view = null, $data = null) {
   if (!is_null($view)){

     if ( file_exists( APPPATH.'views/'.$template.'/'.$view ) )
     {
       $view_path = $template.'/'.$view;
     }
     else if ( file_exists( APPPATH.'views/'.$template.'/'.$view.'.php' ) )
     {
       $view_path = $template.'/'.$view.'.php';
     }
     else if ( file_exists( APPPATH.'views/'.$view ) )
     {
       $view_path = $view;
     }
     else if ( file_exists( APPPATH.'views/'.$view.'.php' ) )
     {
       $view_path = $view.'.php';
     }
     else
     {
       show_error('Não foi possível carregar o arquivo solicitado: ' . $template.'/'.$view.'.php');
     }

     $body = $this->ci->load->view($view_path, $data, TRUE);

     if ( is_null($data) )
     {
       $data = array('body' => $body);
     }
     else if ( is_array($data) )
     {
       $data['body'] = $body;
     }
     else if ( is_object($data) )
     {
       $data->body = $body;
     }
   }

   $this->ci->load->view($template, $data);
 }

}

/* End of file template-site.php */
/* Location: ./application/libraries/template-site.php */
