<?php
  verificaPermissaoPagina(2)
?>
<div class="box-content">
  <h2>Adicionar Depoimentos</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        if (Painel::insert($_POST)) {
          Painel::alert('sucesso','Cadastro do depoimento realizado com sucesso!');
        } else {
          Painel::alert('erro','Campos vazios não são permitidos');
        }
      }

    ?>

    <div class="form-group">
      <label for="nome">Nome da pessoa:</label>
      <input type="text" name="nome">
    </div>
    <div class="form-group">
      <label for="depoimento">Depoimento:</label>
      <textarea name="depoimento" id="depoimento"></textarea>
    </div>
    <div class="form-group">
      <label for="data">Data:</label>
      <input type="text" name="data" id="data"></input>
    </div>
    <div class="form-group">
      <input type="hidden" name="nome_tabela" value="site_depoimentos">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>