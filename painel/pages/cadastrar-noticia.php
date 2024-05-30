<div class="box-content">
  <h2>Cadastrar Notícia</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        $categoria_id = $_POST['categoria_id'];
        $titulo = $_POST['titulo'];
        $conteudo = $_POST['conteudo'];
        $capa = $_FILES['capa'];

        if ($titulo === '' || $conteudo === '') {
          Painel::alert('erro', 'Campos vazios não são permitidos');
        } else if($capa['tmp_name'] === '') {
          Painel::alert('erro', 'A imagem de capa precisa ser selecionada');
        } else {
          if(Painel::imagemValida($capa)) {
            $verifica = MySql::conectar()->prepare("SELECT * FROM `site_noticias` WHERE titulo = ?");
            $verifica->execute(array($titulo));
            if ($verifica->rowCount() === 0) {
              $imagem = Painel::uploadFile($capa);
              $slug = Painel::generateSlug($titulo);
              $arr = [
                'categoria_id' => $categoria_id,
                'titulo' => $titulo,
                'conteudo' => $conteudo,
                'capa' => $imagem,
                'slug' => $slug,
                'nome_tabela' => 'site_noticias'
              ];
              if (Painel::insert($arr)) {
                Painel::alert('sucesso', 'O cadastro da notícia foi realizado com sucesso');
              }
            } else {
              Painel::alert('erro', 'Já existe uma notícia com esse nome');
            }
          } else {
            Painel::alert('erro', 'Selecione uma imagem válida');
          }
        }
      }

    ?>

    <div class="form-group">
      <label for="categoria_id">Categoria:</label>
      <select name="categoria_id" id="categoria_id">
        <?php
          $categorias = Painel::selectAll('site_categorias');
          foreach ($categorias as $key => $value) {
        ?>
          <option <?php if($value['id'] === @$_POST['categoria_id']) echo 'selected'; ?> value="<?php echo $value['id'] ?>">
            <?php echo $value['nome'] ?>
          </option>
        <?php }; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="titulo">Título da Notícia:</label>
      <input type="text" name="titulo" value="<?php recoverPost('titulo') ?>">
    </div>

    <div class="form-group">
      <label for="conteudo">Conteúdo da Notícia:</label>
      <textarea class="tinymce" name="conteudo">
        <?php recoverPost('conteudo') ?>
      </textarea>
    </div>

    <div class="form-group">
      <label for="capa">Capa da Notícia:</label>
      <input type="file" name="capa">
    </div>
    <div class="form-group">
      <input type="hidden" name="nome_tabela" value="site_categorias">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>