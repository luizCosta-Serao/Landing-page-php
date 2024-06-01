<?php
  $url = explode('/',$_GET['url']);
  if(!isset($url[2])) {
    $categoria = MySql::conectar()->prepare("SELECT * FROM `site_categorias` WHERE slug = ?");
    
    $categoria->execute(array(@$url[1]));
    $categoria = $categoria->fetch();
?>

<section class="header-noticias">
  <h2>Acompanhe as últimas notícias do portal</h2>
</section>

<section class="container-portal">
  <div class="sidebar">
    <div class="box-content-sidebar">
      <h3>Realizar uma busca:</h3>
      <form class="buscar-noticia" method="post" action="">
        <input type="text" name="parametro" placeholder="O que deseja procurar?">
        <input type="submit" name="buscar" value="pesquisar">
      </form>
    </div>

    <div class="box-content-sidebar">
      <h3>Selecione a categoria:</h3>
      <form action="">
        <select name="categoria_portal" id="">
          <option value="" selected>Todas as Categorias</option>
          <?php
            $categorias = MySql::conectar()->prepare("SELECT * FROM `site_categorias`");
            $categorias->execute();
            $categorias = $categorias->fetchAll();
            foreach ($categorias as $key => $value) {
          ?>
            <option <?php if($value['slug'] === @$url[1]) echo 'selected' ?> value="<?php echo $value['slug']; ?>"><?php echo $value['nome']; ?></option>
          <?php } ?>
        </select>
      </form>
    </div>

    <div class="box-content-sidebar">
      <h3>Sobre o Autor</h3>
      <img src="<?php echo INCLUDE_PATH; ?>/assets/photo.jpeg" alt="Foto Autor">
      <?php
        $infoSite = MySql::conectar()->prepare("SELECT * FROM `site_config`");
        $infoSite->execute();
        $infoSite = $infoSite->fetch();
      ?>
      <h2><?php echo $infoSite['nome_autor']; ?></h2>
      <p><?php echo $infoSite['descricao'] ?></p>
    </div>
  </div>

  <div class="conteudo-portal">
    <?php
      if (!@$categoria['nome']) {
    ?>
      <h2>Visualizando todos os <span>posts</span></h2>
    <?php } else { ?>
      <h2>Visualizando posts em <span><?php echo $categoria['nome'] ?></span></h2>
    <?php } ?>

    <?php
      
      $query = "";
      if(@$categoria['nome']) {
        $categoria['id'] = (int)$categoria['id'];
        $query.="SELECT * FROM `site_noticias` WHERE categoria_id = $categoria[id]";
        
      } else {
        $query = "SELECT * FROM `site_noticias`";
      }
      if (isset($_POST['parametro'])) {
        $busca = $_POST['parametro'];
        if(strstr($query, 'WHERE') !== false) {
          $query.=" AND titulo LIKE '%$busca%'";
        } else {
          $query.=" WHERE titulo LIKE '%$busca%'";
        }
      }
      $porPagina = 2;
      if (isset($_GET['pagina'])) {
        $pagina = (int)$_GET['pagina'];
        $queryPg = ($pagina - 1) * $porPagina;
        $query.=" LIMIT $queryPg,$porPagina";
      } else {
        $pagina = 1;
        $query.= " LIMIT 0,$porPagina";
      }
      $sql = MySql::conectar()->prepare($query);
      $sql->execute();
      $noticias = $sql->fetchAll();
    ?>

    <?php
      foreach ($noticias as $key => $value) {
        $categoriaNome = MySql::conectar()->prepare("SELECT `slug` FROM `site_categorias` WHERE id = ?");
        $categoriaNome->execute(array($value['categoria_id']));
        $categoriaNome = $categoriaNome->fetch()['slug'];
    ?>
      <div class="box-single-conteudo">
        <h2><?php echo date('d/m/y',strtotime($value['data'])); ?> - <?php echo $value['titulo']; ?></h2>
        <p><?php echo substr(strip_tags($value['conteudo']), 0, 400).'...'; ?></p>
        <a class="leia-mais" href="<?php echo INCLUDE_PATH ?>/noticias/<?php echo $categoriaNome; ?>/<?php echo $value['slug']; ?>">Leia mais</a>
      </div>
    <?php } ?>


    <?php
      $query = "SELECT * FROM `site_noticias`";
      if(@$categoria['nome']) {
        $categoria['id'] = (int)$categoria['id'];
        $query.=" WHERE categoria_id = $categoria[id]";
      }
      if (isset($_POST['parametro'])) {
        $busca = $_POST['parametro'];
        if(strstr($query, 'WHERE') !== false) {
          $query.=" AND titulo LIKE '%$busca%'";
        } else {
          $query.=" WHERE titulo LIKE '%$busca%'";
        }
      }
      $totalPaginas = MySql::conectar()->prepare($query);
      $totalPaginas->execute();
      $totalPaginas = ceil($totalPaginas->rowCount() / $porPagina);
    ?>
    <div class="paginacao">
      <?php
        $catStr = is_array($categoria) && $categoria['nome'] ? '/'.$categoria['slug'] : '';
        for($i = 1; $i <= $totalPaginas; $i++) {
          if($pagina === $i) {
            echo '<a class="active-page" href="'.INCLUDE_PATH.'/noticias?pagina='.$i.''.'">'.$i.'</a>';
          } else {
            echo '<a href="'.INCLUDE_PATH.'/noticias'.$catStr.'?pagina='.$i.''.'">'.$i.'</a>';
          }
        }
      ?>
    </div>
  </div>
</section>

<?php } else {
  include('noticia-single.php');
} ?>