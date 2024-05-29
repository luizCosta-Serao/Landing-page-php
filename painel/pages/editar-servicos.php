<?php
  
  if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $servico = Painel::select('site_servicos','id = ?',array($id));
  } else {
    Painel::alert('erro','Você precisa passar o parâmetro ID');
    die();
  }

?>
<div class="box-content">
  <h2>Editar Serviço</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        if (Painel::updateServico($_POST)) {
          Painel::alert('sucesso','O serviço foi editado com sucesso');
          $servico = Painel::select('site_servicos','id = ?',array($id));
        } else {
          Painel::alert('erro','Campos vazios não são permitidos');
        }
      }

    ?>

    <div class="form-group">
      <label for="servico">Serviço:</label>
      <textarea name="servico" id="servico"><?php echo $servico['servico']; ?></textarea>
    </div>
    <div class="form-group">
      <input type="hidden" name='id' value="<?php echo $id; ?>">
      <input type="hidden" name="nome_tabela" value="site_servicos">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>