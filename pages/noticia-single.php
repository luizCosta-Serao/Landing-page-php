<?php
  $url = explode('/',$_GET['url']);
  $verificaCategoria = MySql::conectar()->prepare("SELECT * FROM `site_categorias` WHERE slug = ?");
  $verificaCategoria->execute(array($url[1]));
  if ($verificaCategoria->rowCount() == 0) {
    Painel::redirect(INCLUDE_PATH.'/noticias');
  } else {
    $categoria_info = $verificaCategoria->fetch();
    $post = MySql::conectar()->prepare("SELECT * FROM `site_noticias` WHERE slug = ? AND categoria_id = ?");
    $post->execute(array($url[2],$categoria_info['id']));
    
    if ($post->rowCount() === 0) {
      Painel::redirect(INCLUDE_PATH.'/noticias');
    } else {
      $post = $post->fetch();
    }
  }
?>

<section class="noticia-single">
  <article>
    <header>
      <span class="bread-crumb"><a href="<?php echo INCLUDE_PATH ?>/noticias/nome-categoria">Categoria</a> > <?php echo $post['titulo']; ?></span>
      <h1><?php echo $post['titulo']; ?></h1>
      <span><?php echo $post['data']; ?></span>
    </header>
    <?php echo $post['conteudo']; ?>
  </article>
</section>