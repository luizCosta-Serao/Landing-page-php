<?php

  session_start();
  date_default_timezone_set('America/Sao_Paulo');

  $autoload = function($class) {
    if ($class === 'Email') {
      require_once('classes/phpmailer/PHPMailerAutoLoad.php');
    }
    include('classes/'.$class.'.php');
  };

  spl_autoload_register($autoload);

  define('INCLUDE_PATH', 'http://localhost/desenv_web/site_dinamico');
  define('INCLUDE_PATH_PAINEL', INCLUDE_PATH.'/painel');

  define('BASE_DIR_PAINEL',__DIR__.`/painel`);

  // Conectar com o banco de dados
  define('HOST','localhost');
  define('USER','root');
  define('PASSWORD','');
  define('DATABASE', 'projeto_1');

  // Constantes para o painel de controle
  define('NOME_EMPRESA','Coding');

  // Variáveis ~cargo painel
  // Funções
  function pegaCargo($indice) {
    return Painel::$cargos[$indice];
  }

  function selecionadoMenu($par) {
    $url = explode('/',@$_GET['url']);
    if($url[0] === $par) {
      echo 'class="menu-active"';
    }
  }

  function verificaPermissaoMenu($permissao) {
    if ($_SESSION['cargo'] >= $permissao) {
      return;
    } else {
       echo 'style="display: none;"';
    }
  }

  function verificaPermissaoPagina($permissao) {
    if ($_SESSION['cargo'] >= $permissao) {
      return;
    } else {
       include('painel/pages/permissao-negada.php');
       die();
    }
  }

  function recoverPost($post) {
    if (isset($_POST[$post])) {
      echo $_POST[$post];
    }
  }

?>