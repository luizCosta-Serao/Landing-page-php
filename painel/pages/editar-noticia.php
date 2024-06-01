<?php
  if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $noticia = Painel::select('site_noticias','id = ?',array($id));
  } else {
    Painel::alert('erro','Você precisa passar o parâmetro ID');
    die();
  }

?>
<div class="box-content">
  <h2>Editar Notícia</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php

      if(isset($_POST['acao'])) {
        $nome = $_POST['titulo'];
        $conteudo = $_POST['conteudo'];
        $imagem = $_FILES['capa'];
        $imagem_atual = $_POST['imagem_atual'];

        $verifica = MySql::conectar()->prepare("SELECT `id` FROM `site_noticias` WHERE titulo = ? AND id != ?");
        $verifica->execute(array($nome,$id));
        if ($verifica->rowCount() === 0) {
          if ($imagem['name'] !== '') {
            if (Painel::imagemValida($imagem)) {
              Painel::deleteFile($imagem_atual);
              $imagem = Painel::uploadFile($imagem);
              $slug = Painel::generateSlug($nome);
              $arr = [
                'categoria_id'=>$_POST['categoria_id'],
                'data' => date('Y-m-d'),
                'titulo'=>$nome,
                'conteudo'=>$conteudo,
                'capa'=>$imagem,
                'slug'=>$slug,
                'id'=>$id,
                'nome_tabela'=>'site_noticias',
              ];
              Painel::updateNoticia($arr);
              $slide = Painel::select('site_noticias','id = ?',array($id));
              Painel::alert('sucesso','A notícia foi editada com sucesso');
            } else {
              Painel::alert('erro','O formato da imagem não é válido');
            }
          } else {
            $imagem = $imagem_atual;
            $slug = Painel::generateSlug($nome);
            $arr = [
              'titulo'=>$nome,
              'conteudo'=>$conteudo,
              'capa'=>$imagem,
              'slug'=>$slug,
              'id'=>$id,
              'nome_tabela'=>'site_noticias',
            ];
            Painel::updateSlide($arr);
            $slide = Painel::select('site_noticias','id = ?',array($id));
            Painel::alert('sucesso','O Slide foi editado com sucesso');
          }
        } else {
          Painel::alert('erro', 'Já existe uma notícia com esse nome');
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
          <option <?php if($value['id'] === $noticia['categoria_id']) echo 'selected'; ?> value="<?php echo $value['id'] ?>">
            <?php echo $value['nome'] ?>
          </option>
        <?php }; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="titulo">Título da Notícia:</label>
      <input type="text" name="titulo" required value="<?php echo $noticia['titulo']; ?>">
    </div>

    <div class="form-group">
      <label for="conteudo">Conteúdo da Notícia:</label>
      <textarea class="tinymce" type="text" name="conteudo" required>
        <?php echo $noticia['conteudo']; ?>
      </textarea>
    </div>

    <div class="form-group">
      <label for="imagem">Imagem:</label>
      <input type="file" name="capa">
      <input type="hidden" name="imagem_atual" value="<?php echo $noticia['capa'] ?>">
    </div>
    <div class="form-group">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>