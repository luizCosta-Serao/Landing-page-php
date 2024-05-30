<?php
  
  if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $categoria = Painel::select('site_categorias','id = ?',array($id));
  } else {
    Painel::alert('erro','Você precisa passar o parâmetro ID');
    die();
  }

?>
<div class="box-content">
  <h2>Editar Categoria</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        $slug = Painel::generateSlug($_POST['nome']);
        $arr = array_merge($_POST, array('slug'=>$slug));
        $verificar = MySql::conectar()->prepare("SELECT * FROM `site_categorias` WHERE nome = ? AND id != ?");
        $verificar->execute(array($_POST['nome'],$id));
        if ($verificar->rowCount() == 1) {
          Painel::alert('erro','Já existe uma categoria com este nome');
        } else {
          if (Painel::updateCategoria($arr)) {
            Painel::alert('sucesso','A categoria foi editada com sucesso');
            $categoria = Painel::select('site_categorias','id = ?',array($id));
          } else {
            Painel::alert('erro','Campos vazios não são permitidos');
          }
        }
      }

    ?>

    <div class="form-group">
      <label for="nome">Nome Categoria:</label>
      <input type="text" name="nome" id="nome" value="<?php echo $categoria['nome'] ?>" >
    </div>
    <div class="form-group">
      <input type="hidden" name='id' value="<?php echo $id; ?>">
      <input type="hidden" name="nome_tabela" value="site_categorias">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>