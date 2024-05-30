<?php
  $url = explode('/',$_GET['url']);
  if(!isset($url[2])) {
?>

<section class="header-noticias">
  <h2>Acompanhe as últimas notícias do portal</h2>
</section>

<section class="container-portal">
  <div class="sidebar">
    <div class="box-content-sidebar">
      <h3>Realizar uma busca:</h3>
      <form action="">
        <input type="text" name="busca" placeholder="O que deseja procurar?">
        <input type="submit" name="acao" value="pesquisar">
      </form>
    </div>

    <div class="box-content-sidebar">
      <h3>Selecione a categoria:</h3>
      <form action="">
        <select name="categoria_portal" id="">
          <option value="" selected disabled>Categorias</option>
          <option value="esportes">Esportes</option>
          <option value="geral">Geral</option>
        </select>
      </form>
    </div>

    <div class="box-content-sidebar">
      <h3>Sobre o Autor</h3>
      <img src="<?php echo INCLUDE_PATH; ?>/assets/photo.jpeg" alt="Foto Autor">
      <h2>Luiz Antonio</h2>
      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos saepe, vero accusantium iure dignissimos excepturi pariatur velit consequatur officia cumque, blanditiis repellendus aperiam tenetur incidunt?</p>
    </div>
  </div>

  <div class="conteudo-portal">
    <?php
      if (isset($_POST['categoria_portal'])) {
    ?>
      <h2>Visualizando posts em <span>Esportes</span></h2>
    <?php } else { ?>
      <h2>Visualizando todos os <span>posts</span></h2>
    <?php } ?>

    <?php
      for($i = 0; $i < 5; $i++) {
    ?>
      <div class="box-single-conteudo">
        <h2>19/05/2024 - Conheça os eleitos para ganhar...</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut deserunt nobis ullam totam consequuntur quod maxime sed ipsum incidunt quis! Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis consequuntur voluptatibus rerum commodi nulla illo, qui nostrum dolores reiciendis voluptatum atque dignissimos, numquam, magnam odit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci esse autem, rerum eius incidunt consequuntur. ...</p>
        <a class="leia-mais" href="<?php echo INCLUDE_PATH ?>/noticias/esportes/nome-do-post">Leia mais</a>
      </div>
    <?php } ?>

    <div class="paginacao">
        <a class="active-page" href="">1</a>
        <a href="">2</a>
        <a href="">3</a>
        <a href="">4</a>
    </div>
  </div>
</section>

<?php } else {
  include('noticia-single.php');
} ?>