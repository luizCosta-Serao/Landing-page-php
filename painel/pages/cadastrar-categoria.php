<div class="box-content">
  <h2>Cadastrar Categoria</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        $nome = $_POST['nome'];
        
        if($nome === '') {
          Painel::alert('erro','Preencha o campo Nome');
        } else {
          $verifica = MySql::conectar()->prepare("SELECT * FROM `site_categorias` WHERE nome = ?");
          $verifica->execute(array($nome));
          if ($verifica->rowCount() === 0) {
            $slug = Painel::generateSlug($nome);
            $arr = [
              'nome'=>$nome,
              'slug'=>$slug,
              'nome_tabela'=>'site_categorias',
            ];
            Painel::insert($arr);
            Painel::alert('sucesso','Cadastro da categoria realizado com sucesso!');
          } else {
            Painel::alert('erro', 'Já existe uma categoria com este nome');
          }
        }
      }

    ?>

    <div class="form-group">
      <label for="nome">Nome da Categoria:</label>
      <input type="text" name="nome">
    </div>

    <div class="form-group">
      <input type="hidden" name="nome_tabela" value="site_slides">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>