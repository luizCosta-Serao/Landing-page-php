<div class="box-content">
  <h2>Cadastrar Slide</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        $nome = $_POST['nome'];
        $imagem = $_FILES['imagem'];
        
        if($nome === '') {
          Painel::alert('erro','Preencha o campo Nome');
        } else {
          if (Painel::imagemValida($imagem) === false) {
            Painel::alert('erro','O formato da imagem não é suportado');
          } else {
            $imagem = Painel::uploadFile($imagem);
            $arr = [
              'nome'=>$nome,
              'slide'=>$imagem,
              'nome_tabela'=>'site_slides',
            ];
            Painel::insert($arr);
            Painel::alert('sucesso','Cadastro do slide realizado com sucesso!');
          }
        }
      }

    ?>

    <div class="form-group">
      <label for="nome">Nome do Slide:</label>
      <input type="text" name="nome">
    </div>

    <div class="form-group">
      <label for="imagem">Imagem:</label>
      <input type="file" name="imagem">
    </div>
    <div class="form-group">
      <input type="hidden" name="nome_tabela" value="site_slides">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>