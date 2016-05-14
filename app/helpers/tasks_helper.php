<?php defined('BASEPATH') || exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Helper para auxiliar em algumas tarefas simples
|--------------------------------------------------------------------------
*/

/*
* O escape _html() é um método simples usado para limpar algum dado malicioso nos campos de formulários.
* O CI protege a aplicação de SQ_injection por padrão, por isso não há necessidade de veriricar isso
*/
function escape_html($content = null) {
  if($content) {

    $content = strip_tags($content);
    $content = htmlspecialchars($content, ENT_QUOTES, "UTF-8");

    return $content;
  } else {
    return null;
  }
}

/*
* O random_code() está sendo usado para gerar um código único para os jogos
* Assim podemos gerar urls publicas para os jogos.
* Exemplo: https://geraja.com.br/jogo/123abc
* Para garantir que o código realmente seja único, concatenamos o código gerado por esse método
* com o id único do jogo gerado no banco de dados.
* Também usado para gerar código do usuário
*/
function random_code($length = 10, $merge = null) {

  $characters = "123456789abcdefghijklmnopqrstuvwxyz";

  $string = '';

  if($merge && strlen($merge)) $string = $merge;

  for ($p = 0; $p < $length; $p++) {
    $string .= $characters[mt_rand(0, strlen($characters)-1)];
  }

   if($merge && strlen($merge)) {
    $string = substr( $string, 0, -strlen($merge) );
  }

  return $string;
}

/*
* Exibe uma data do banco de dados em formato mais amigável/legivel para o usuário
* Exemplo: YYYY-MM-DD --> DD/MM/YYYY
*/
function display_date($date = null) {
  $date_format = ($date) ? date_format(date_create($date), 'd/m/Y') : '-';

  return $date_format;
}

/*
* Exibe a hora e minutos em formato mais amigável para o usuário
*/
function display_time($time = null) {
  $time_format = $time ? date_format(date_create($time), 'H:i') : '-';

  return $time_format;
}

function display_datetime($date = null) {
  $date_format = ($date) ? date_format(date_create($date), 'd/m/Y \à H:i') : '-';

  return $date_format;
}


/*
* Função para "encurtar" alguma string quando necessário
*/
function excerpt($string = null, $max_length = 80) {
  if($string && (strlen($string) > $max_length)) {

    $excerpt = substr($string, 0, $max_length);

    $excerpt .= '...';

    return $excerpt;
  } else {
    return $string;
  }
}

/*
* Limpa a formatação da string - como a formatação em salva em tags em muitos casos pode causar quebra na exibição
*/
function clean_tags($string = null, $length = 8) {
  if($string) {
    $string = htmlspecialchars_decode($string);
    $string = trim(strip_tags($string));
    $string = excerpt($string, $length);
  }

  return $string;
}
function get_states() {
  $data = array(
    'AC' => 'Acre',
    'AL' => 'Alagoas',
    'AM' => 'Amazonas',
    'AP' => 'Amapá',
    'BA' => 'Bahia',
    'CE' => 'Ceará',
    'DF' => 'Distrito Federal',
    'ES' => 'Espirito Santo',
    'GO' => 'Goiás',
    'MA' => 'Maranhão',
    'MG' => 'Minas Gerais',
    'MS' => 'Mato Grosso do Sul',
    'MT' => 'Mato Grosso',
    'PA' => 'Pará',
    'PB' => 'Paraíba',
    'PE' => 'Pernambuco',
    'PI' => 'Piauí',
    'PR' => 'Paraná',
    'RJ' => 'Rio de Janeiro',
    'RN' => 'Rio Grande do Norte',
    'RO' => 'Rondônia',
    'RR' => 'Roraima',
    'RS' => 'Rio Grande do Sul',
    'SC' => 'Santa Catarina',
    'SE' => 'Sergipe',
    'SP' => 'São Paulo',
    'TO' => 'Tocantins',
    );

  return $data;
}

/*
* Comentários da página inicial
*/

function comments() {
  $comments = array(
    array('image' => 'home-user-comment.png', 'author' => 'Tiago Oliveira Pereira, Facilitador do Polo de Cultura Digital em Feira de Santana (BA).', 'comment' => 'Gostei das opções que a plataforma oferece para publicar o livro. E principalmente, gostei da facilidade de acesso da plataforma. Considero a plataforma extremamente educacional e construtiva para alunos e professores.'),
    array('image' => 'home-user-comment-4.png', 'author' => 'Professora Francisca Alves, Jati (CE).', 'comment' => 'A plataforma Livros Digitais possibilitou a realização do nosso objetivo: escrever e publicar um livro de crônicas e poesias, falando sobre o rio mais importante da nossa cidade, sem custos e sem dificuldades.'),
    array('image' => 'home-user-comment-2.png', 'author' => 'Professora Agatha Rodrigues da Silva.', 'comment' => 'Os nossos alunos da EJA puderam publicar as suas produções literárias sobre a região em que habitam e sociabilizarem os conhecimentos produzidos sobre ervas medicinais. Nós, professores e alunos, experienciamos uma tecnologia a serviço da aprendizagem!'),
    array('image' => 'home-user-comment-3.png', 'author' => 'Professora Sirlei Pereira dos Reis, Ponta Porã (MS).', 'comment' => 'A plataforma veio ao encontro da ideia que eu tinha de encontrar um ambiente virtual de aprendizagem, que colocasse o aluno como protagonista e valorizasse a sua produção textual. Com isso, a reescrita textual é bem mais explorada e concebida de forma mais ampla. Uma etapa importante da aprendizagem é a exibição da produção textual na plataforma.'),
    );

return $comments;
}

function data_folder() {
  $folder_path = './data/';

  if(is_dir($folder_path)) {
    return $folder_path;
  } else {
    if(mkdir($folder_path, 0777)) {
      if (chmod($folder_path, 0777)) {
        return $folder_path;
      }
    } else {
      return false;
    }
  }
}

function game_folder($id_game = null, $uid = null) {
  if($id_game && $uid) {

    data_folder();

    $folder_path = './data/' . $uid . '/' . $id_game;

    if(is_dir($folder_path)) {
      return $folder_path;
    } else {
      if(mkdir($folder_path, 0777)) {
        if (chmod($folder_path, 0777)) {
          return $folder_path;
        }
      } else {
        return false;
      }
    }
  }
}

function user_folder($uid = null) {
  if($uid) {

    $folder_path = './data/' . $uid;

    if(is_dir($folder_path)) {
      return $folder_path;
    } else {
      if(mkdir($folder_path, 0777)) {
        if (chmod($folder_path, 0777)) {
          return $folder_path;
        }
      } else {
        return false;
      }
    }
  }
}

function delete_dir_tree($dir) {
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}
