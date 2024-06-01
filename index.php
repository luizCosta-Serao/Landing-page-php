<?php include('config.php'); ?>
<?php Site::updateUsuarioOnline(); ?>
<?php Site::contadorVisitas(); ?>
<?php
  $infoSite = MySql::conectar()->prepare("SELECT * FROM `site_config`");
  $infoSite->execute();
  $infoSite = $infoSite->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="descrição do site">
  <meta name="keywords", content="palavras-chave, site, estudo">
  <meta name="author", content="Seu nome">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>/styles/index.css">
  <title><?php echo $infoSite['titulo']; ?></title>
</head>
<body>
  <?php

    $url = isset($_GET['url']) ? $_GET['url'] : 'home';
    switch($url) {
      case 'sobre':
        echo '<target target="sobre" />';
        break;
      case 'servicos':
        echo '<target target="servicos" />';
        break;
    }

  ?>
  <header class="header">
    <div class="logo">
      <p>Meu Website</p>
    </div>
    <nav class="menu">
      <ul>
        <li><a href="<?php echo INCLUDE_PATH; ?>/">Home</a></li>
        <li><a href="<?php echo INCLUDE_PATH; ?>/sobre">Sobre</a></li>
        <li><a href="<?php echo INCLUDE_PATH; ?>/servicos">Serviços</a></li>
        <li><a href="<?php echo INCLUDE_PATH; ?>/contato">Contato</a></li>
        <li><a href="<?php echo INCLUDE_PATH; ?>/noticias">Notícias</a></li>
      </ul>
    </nav>
  </header>

  <?php
    $url = isset($_GET['url']) ? $_GET['url'] : 'home';
    if (file_exists('pages/'.$url.'.php')) {
      include('pages/'.$url.'.php');
    } else {
      if ($url === 'sobre' || $url === 'servicos') {
        include('pages/home.php');
      } else {
        $urlPar = explode('/', $url)[0];
        if ($urlPar !== 'noticias') {
          $notFound = true;
          include('pages/not-found.php');
        } else {
          include('pages/noticias.php');
        }
      }
    }

  ?>

  <footer class="<?php if(isset($notFound) && $notFound) echo 'footer-fixed' ?> footer">
    <p>Todos os direitos reservados</p>
  </footer>

  <script src="<?php echo INCLUDE_PATH; ?>/js/jquery-3.7.1.min.js"></script>
  <script src="<?php echo INCLUDE_PATH; ?>/js/index.js"></script>

  <?php
    if(is_array($url) && strstr($url[0],'noticias')) {
  ?>
    <script>
      const base = 'http://localhost/desenv_web/site_dinamico/'
      $(function() {
        $('select').change(function() {
          location.href=base+'noticias/'+$(this).val();
        })
      })
    </script>
  <?php }?>
</body>
</html>