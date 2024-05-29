<?php
  if (isset($_GET['loggout'])) {
    Painel::loggout();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>/styles/style.css">
  <title>Painel de Controle</title>
</head>
<body>

  <div class="topo-painel">
    <aside class="menu">
      <div class="box-usuario">

        <?php
          if ($_SESSION['img'] === '') {

        ?>

          <div class="avatar-usuario">
            <img src="<?php echo INCLUDE_PATH ?>/assets/account_circle.svg" alt="">  
          </div>
        
        <?php } else { ?>
        
          <div class="imagem-usuario">
            <img src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/<?php echo $_SESSION['img']; ?>" alt="">  
          </div>
        
        <?php } ?>
        
          <div class="nome-usuario">
          <p><?php echo $_SESSION['nome']; ?></p>
          <p><?php echo pegaCargo($_SESSION['cargo']); ?></p>
        </div>
      </div>
      <div class="itens-menu">
          <h2>Cadastro</h2>
          <a <?php selecionadoMenu('cadastrar-depoimento') ?> href="<?php echo INCLUDE_PATH_PAINEL ?>/cadastrar-depoimento">Cadastrar Depoimento</a>
          <a <?php selecionadoMenu('cadastrar-servico') ?> href="<?php echo INCLUDE_PATH_PAINEL ?>/cadastrar-servico">Cadastrar Serviço</a>
          <a <?php selecionadoMenu('cadastrar-slides') ?> href="<?php echo INCLUDE_PATH_PAINEL ?>/cadastrar-slides">Cadastrar Slides</a>
          <h2>Gestão</h2>
          <a <?php selecionadoMenu('listar-depoimento') ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>/listar-depoimentos">Listar Depoimentos</a>
          <a <?php selecionadoMenu('listar-servicos') ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>/listar-servicos">Listar Serviços</a>
          <a <?php selecionadoMenu('listar-slides') ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>/listar-slides">Listar Slides</a>
          <h2>Administração do Painel</h2>
          <a <?php selecionadoMenu('editar-usuario') ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>/editar-usuario">Editar Usuário</a>
          <a <?php selecionadoMenu('adicionar-usuario') ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>/adicionar-usuario">Adicionar Usuários</a>
          <h2>Configuração Geral</h2>
          <a <?php selecionadoMenu('editar-site') ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>/editar-site">Editar Site</a>
      </div>
    </aside>
    <header>
      <div class="menu-btn">
        <img src="<?php echo INCLUDE_PATH ?>/assets/menu.svg" alt="Menu">
      </div>
      <div class="btn-home">
        <a href="<?php echo INCLUDE_PATH_PAINEL ?>">Home</a>
      </div>
      <div class="loggout">
        <a href="<?php echo INCLUDE_PATH_PAINEL ?>/?loggout"><span>X</span>Sair</a>
      </div>
    </header>
  </div>

  <div class="content">
    <?php

      Painel::carregarPagina();

    ?>
  </div>

  <script src="<?php echo INCLUDE_PATH ?>/js/jquery-3.7.1.min.js"></script>
  <script src="<?php echo INCLUDE_PATH_PAINEL ?>/js/main.js"></script>
</body>
</html>