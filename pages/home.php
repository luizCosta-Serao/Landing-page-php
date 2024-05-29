

<section class="hero">
    <div style="background-image: url('<?php echo INCLUDE_PATH; ?>/assets/hero-bg-1.jpg');" class="hero-bg"></div>
    <div style="background-image: url('<?php echo INCLUDE_PATH; ?>/assets/hero-bg-2.jpg');" class="hero-bg"></div>
    <div style="background-image: url('<?php echo INCLUDE_PATH; ?>/assets/hero-bg-3.jpg');" class="hero-bg"></div>
    <div class="bg-effect"></div>
    <form action="" class="hero-form">
      <label for="">Qual o seu melhor email?</label>
      <input type="email" name="email" required>
      <input type="submit" name="acao" value="Cadastrar!">
    </form>
  </section>

  <section id="sobre" class="description-author">
    <div class="description-author-content">
      <h2><?php echo $infoSite['nome_autor']; ?></h2>
      <p>
        <?php echo $infoSite['descricao']; ?>
      </p>
    </div>
    <div class="description-author-img">
      <img src="<?php echo INCLUDE_PATH; ?>/assets/photo.jpeg" alt="photo author">
    </div>
  </section>

  <section class="especialidades">
    <h2 class="title">Especialidades</h2>
    <ul class="lista-especialidades">
      <li class="box-especialidades">
        <h3><?php echo $infoSite['icone_1']; ?></h3>
        <p><?php echo $infoSite['descricao_1']; ?></p>
      </li>
      <li class="box-especialidades">
        <h3><?php echo $infoSite['icone_2']; ?></h3>
        <p><?php echo $infoSite['descricao_2']; ?></p>
      </li>
      <li class="box-especialidades">
        <h3><?php echo $infoSite['icone_3']; ?></h3>
        <p><?php echo $infoSite['descricao_3']; ?></p>
      </li>
    </ul>
  </section>

  <section id="servicos" class="depoimentos-servicos">
    <div class="depoimentos">
      <h2>Depoimentos dos nossos clientes</h2>
      <ul class="lista-depoimentos">
        <?php
          $sql = MySql::conectar()->prepare("SELECT * FROM `site_depoimentos`");
          $sql->execute();
          $depoimentos = $sql->fetchAll();

          foreach ($depoimentos as $key => $value) {
            
        ?>
          <li class="box-depoimentos">
            <p><?php echo $value['depoimento']; ?></p>
            <h3><?php echo $value['nome']; ?> - <?php echo $value['data']; ?></h3>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="servicos">
      <h2>Serviços</h2>
      <ul class="lista-servicos">
        <?php
          $sql = MySql::conectar()->prepare("SELECT * FROM `site_servicos`");
          $sql->execute();
          $servicos = $sql->fetchAll();

          foreach ($servicos as $key => $value) {
        ?>
          <li class="box-servicos"><?php echo $value['servico']; ?></li>
        <?php } ?>
      </ul>
    </div>
  </section>