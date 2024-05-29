<div class="box-content">
  <h2>Adicionar Serviço</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        if (Painel::insert($_POST)) {
          Painel::alert('sucesso','Cadastro do serviço realizado com sucesso!');
        } else {
          Painel::alert('erro','Campos vazios não são permitidos');
        }
      }

    ?>

    <div class="form-group">
      <label for="servico">Descreva o serviço:</label>
      <textarea name="servico" id="servico"></textarea>
    </div>
    <div class="form-group">
      <input type="hidden" name="nome_tabela" value="site_servicos">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>