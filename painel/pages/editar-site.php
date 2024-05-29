<?php
  $siteConfig = MySql::conectar()->prepare("SELECT * FROM `site_config`");
  $siteConfig->execute();
  $siteConfig = $siteConfig->fetch();
?>

<div class="box-content">
  <h2>Editar Configurações do Site</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        
        if (Painel::updateSiteConfig($_POST)) {
          Painel::alert('sucesso','O site foi editado com sucesso');
          $siteConfig = MySql::conectar()->prepare("SELECT * FROM `site_config`");
          $siteConfig->execute();
          $siteConfig = $siteConfig->fetch();
        } else {
          Painel::alert('erro','Campos vazios não são permitidos');
        }
      }

    ?>

    <div class="form-group">
      <label for="titulo">Titulo do Site:</label>
      <input type="text" name="titulo" id="titulo" value="<?php echo $siteConfig['titulo']; ?>" />
    </div>

    <div class="form-group">
      <label for="nome_autor">Titulo do Site:</label>
      <input type="text" name="nome_autor" id="nome_autor" value="<?php echo $siteConfig['nome_autor']; ?>" />
    </div>
    
    <div class="form-group">
      <label for="descricao">Descrição Autor:</label>
      <textarea name="descricao" id="descricao"><?php echo $siteConfig['descricao']; ?>></textarea>
    </div>
    
    <div class="form-group">
      <label for="icone_1">Icone 1:</label>
      <input type="text" name="icone_1" id="icone_1" value="<?php echo $siteConfig['icone_1']; ?>" />
    </div>
    
    <div class="form-group">
      <label for="descricao_1">Descrição 1:</label>
      <textarea name="descricao_1" id="descricao_1"><?php echo $siteConfig['descricao_1']; ?>></textarea>
    </div>
    
    <div class="form-group">
      <label for="icone_2">Icone 2:</label>
      <input type="text" name="icone_2" id="icone_2" value="<?php echo $siteConfig['icone_2']; ?>" />
    </div>
    
    <div class="form-group">
      <label for="descricao_2">Descrição 2:</label>
      <textarea name="descricao_2" id="descricao_2"><?php echo $siteConfig['descricao_2']; ?>></textarea>
    </div>
    
    <div class="form-group">
      <label for="icone_3">Icone 3:</label>
      <input type="text" name="icone_3" id="icone_3" value="<?php echo $siteConfig['icone_3']; ?>" />
    </div>
    
    <div class="form-group">
      <label for="descricao_3">Descrição 3:</label>
      <textarea name="descricao_3" id="descricao_3"><?php echo $siteConfig['descricao_3']; ?>></textarea>
    </div>
    
    <div class="form-group">
      <input type="hidden" name="nome_tabela" value="site_config">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>