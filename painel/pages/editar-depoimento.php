<?php
  
  if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $depoimento = Painel::select('site_depoimentos','id = ?',array($id));
  } else {
    Painel::alert('erro','Você precisa passar o parâmetro ID');
    die();
  }

?>
<div class="box-content">
  <h2>Editar Depoimentos</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        if (Painel::update($_POST)) {
          Painel::alert('sucesso','O depoimento foi editado com sucesso');
          $depoimento = Painel::select('site_depoimentos','id = ?',array($id));
        } else {
          Painel::alert('erro','Campos vazios não são permitidos');
        }
      }

    ?>

    <div class="form-group">
      <label for="nome">Nome da pessoa:</label>
      <input type="text" name="nome" value="<?php echo $depoimento['nome']; ?>">
    </div>
    <div class="form-group">
      <label for="depoimento">Depoimento:</label>
      <textarea name="depoimento" id="depoimento"><?php echo $depoimento['depoimento']; ?></textarea>
    </div>
    <div class="form-group">
      <label for="data">Data:</label>
      <input type="text" name="data" id="data" value="<?php echo $depoimento['data']; ?>"></input>
    </div>
    <div class="form-group">
      <input type="hidden" name='id' value="<?php echo $id; ?>">
      <input type="hidden" name="nome_tabela" value="site_depoimentos">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>