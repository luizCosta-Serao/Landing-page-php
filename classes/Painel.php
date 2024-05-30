<?php

  class Painel {
    public static  $cargos = [
      '0' => 'Normal',
      '1' => 'Sub Administrador',
      '2' => 'Administrador'
    ];

    // Gerador de slug
    public static function generateSlug($str) {
      $str = mb_strtolower($str);
      $str = preg_replace('/(â|á|ã)/', 'a', $str);
      $str = preg_replace('/(ê|é)/', 'e', $str);
      $str = preg_replace('/(í|Í)/', 'i', $str);
      $str = preg_replace('/(ú)/', 'u', $str);
      $str = preg_replace('/(ó|ô|õ|Ô)/', 'o', $str);
      $str = preg_replace('/(_|\/|!|\?|#)/', '', $str);
      $str = preg_replace('/( )/', '-', $str);
      $str = preg_replace('/ç/', 'c', $str);
      $str = preg_replace('/(-[-]{1,})/', '-', $str);
      $str = preg_replace('/(,)/', '-', $str);
      $str = strtolower($str);
      return $str;
    }
    
    public static function logado() {
      return isset($_SESSION['login']) ? true : false;
    }

    public static function loggout() {
      session_destroy();
      setcookie('lembrar',true,time()-1,'/');
      header('Location: '.INCLUDE_PATH_PAINEL);
    }

    public static function carregarPagina() {
      if(isset($_GET['url'])) {
        $url = explode('/',$_GET['url']);
        if(file_exists('pages/'.$url[0].'.php')) {
          include('pages/'.$url[0].'.php');
        } else {
          header('Location: '.INCLUDE_PATH_PAINEL);
        }
      } else {
        include('pages/home.php');
      }
    }

    // Listar usuários online
    public static function listarUsuariosOnline() {
      self::limparUsuariosOnline();
      $sql = MySql::conectar()->prepare("SELECT * FROM `usuarios_online`");
      $sql->execute();
      return $sql->fetchAll();
    }

    // Limpar usuários online
    public static function limparUsuariosOnline() {
      $date = date('Y-m-d H:i:s');
      $sql = MySql::conectar()->exec("DELETE FROM `usuarios_online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE");
    }

    // Inserir uma mensagem de sucesso ou erro
    public static function alert($tipo,$mensagem) {
      if($tipo === 'sucesso') {
        echo '<div class="sucesso">'.$mensagem.'</div>';
      } else if ($tipo === 'erro') {
        echo '<div class="erro">'.$mensagem.'</div>';
      }
    }

    // Verifica se imagem é válida
    public static function imagemValida($imagem) {
      if (
        $imagem['type'] === 'image/jpeg' ||
        $imagem['type'] === 'image/jpg' ||
        $imagem['type'] == 'image/png'
      ) {
        $tamanho = intval($imagem['size'] / 1024);
        if ($tamanho < 1000) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

    // Inserir arquivo de imagem
    public static function uploadFile($file) {
      if (
        !isset($file['tmp_name']) ||
        !is_uploaded_file($file['tmp_name'])) {
        return false;
      }

      // Define a pasta de destino
      $uploadDir = BASE_DIR_PAINEL.'/painel/uploads';

      // Gera um nome único para o arquivo
      $formatoArquivo = explode('.', $file['name']);
      $imagemNome = uniqid() . '.' . end($formatoArquivo);
      
      // Move o arquivo para a pasta de destino
      if (move_uploaded_file($file['tmp_name'], $uploadDir.'/'.$imagemNome)) {
        return $imagemNome;
      } else {
        return false;
      }
    }

    // Deletar Arquivo
    public static function deleteFile($file) {
      @unlink(`/uploads/`.$file);
    }

    // Inserir novos dados na tabela do banco de dados
    public static function insert($arr) {
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];
      $query = "INSERT INTO `$nome_tabela` VALUES(null";
      foreach ($arr as $key => $value) {
        $nome = $key;
        $valor = $value;
        if ($nome === 'acao' || $nome === 'nome_tabela') {
          continue;
        }
        if ($value === '') {
          $certo = false;
          break;
        }
        $query.=",?";
        $parametros[] = $value; 
      }
      $query.=")";
      if ($certo === true) {
        $sql = MySql::conectar()->prepare($query);
        $sql->execute($parametros);
      }
  
      return $certo;
    }

    // Puxar todos os dados de uma tabela
    public static function selectAll($tabela,$start = null,$end = null) {
      if ($start === null && $end === null) {
        $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela`");
        $sql->execute();
      } else {
        $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` LIMIT $start,$end");
        $sql->execute();
      }
      return $sql->fetchAll();
    }

    // Deletar um dado da tabela
    public static function deletar($tabela,$id=false) {
      if($id === false) {
        $sql = MySql::conectar()->prepare("DELETE FROM `$tabela`");
      } else {
        $sql = MySql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
      }
      $sql->execute();
    }

    // Redirecionar para outra url
    public static function redirect($url) {
      echo '<script>location.href="'.$url.'"</script>';
      die();
    }

    // Obter apenas um registro da tabela
    public static function select($table,$query,$arr) {
      $sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
        $sql->execute($arr);
        return $sql->fetch();
    }

    // Atualizar registro da tabela
    public static function update($arr) {
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];

      $id = $arr['id'];
      $nome = $arr['nome'];
      $depoimento = $arr['depoimento'];
      $data = $arr['data'];
      
      $sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET nome = ?, depoimento = ?, data = ? WHERE id = ?");
      $sql->execute(array($nome,$depoimento,$data,$id));
  
      return $certo;
    }

    // Atualizar registro da tabela site_servicos
    public static function updateServico($arr) {
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];
    
      $id = $arr['id'];
      $servico = $arr['servico'];
          
      $sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET servico = ? WHERE id = ?");
      $sql->execute(array($servico,$id));
      
      return $certo;
    }

    // Atualizar registro da tabela slide
    public static function updateSlide($arr) {
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];

      $id = $arr['id'];
      $nome = $arr['nome'];
      $slide = $arr['slide'];
      
      $sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET nome = ?, slide = ? WHERE id = ?");
      $sql->execute(array($nome,$slide,$id));
  
      return $certo;
    }

    // Atualizar registro da tabela site_config
    public static function updateSiteConfig($arr) {
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];

      $id = 1;
      $titulo = $arr['titulo'];
      $nomeAutor = $arr['nome_autor'];
      $descricao = $arr['descricao'];
      $icone_1 = $arr['icone_1'];
      $descricao_1 = $arr['descricao_1'];
      $icone_2 = $arr['icone_2'];
      $descricao_2 = $arr['descricao_2'];
      $icone_3 = $arr['icone_3'];
      $descricao_3 = $arr['descricao_3'];
      
      

      $sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET titulo = ?, nome_autor = ?,
      descricao = ?, icone_1 = ?, descricao_1 = ?, icone_2 = ?, descricao_2 = ?, icone_3 = ?, descricao_3 = ? WHERE id = ?");
      $sql->execute(array($titulo,$nomeAutor,$descricao,$icone_1,$descricao_1,$icone_2,$descricao_2,$icone_3,$descricao_3,$id));
  
      return $certo;
    }

      // Atualizar registro da tabela site_categorias
    public static function updateCategoria($arr) {
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];

      $id = $arr['id'];
      $nome = $arr['nome'];
      $slug = $arr['slug'];
      
      $sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET nome = ?, slug = ? WHERE id = ?");
      $sql->execute(array($nome,$slug,$id));
  
      return $certo;
    }

    public static function updateNoticia($arr) {
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];
  
      $titulo = $arr['titulo'];
      $conteudo = $arr['conteudo'];
      $capa = $arr['capa'];
      $slug = $arr['slug'];
      $id = $arr['id'];
      $categoria_id = $arr['categoria_id'];
      
      $sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET categoria_id = ?, titulo = ?, conteudo = ?, capa = ? , slug = ? WHERE id = ?");
      $sql->execute(array($categoria_id,$titulo,$conteudo,$capa,$slug,$id));
  
      return $certo;
    }
  }

?>