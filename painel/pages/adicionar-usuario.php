<?php
  verificaPermissaoPagina(2)
?>
<div class="box-content">
  <h2>Adicionar Usuário</h2>

  <form action="" method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])) {
        $login = $_POST['login'];
        $nome = $_POST['nome'];
        $senha = $_POST['password'];
        $imagem = $_FILES['imagem'];
        $cargo = $_POST['cargo'];
        
        if($login === '') {
          Painel::alert('erro','Preencha o campo Login');
        } else if ($nome === '') {
          Painel::alert('erro','Preencha o campo Nome');
        } else if ($senha === '') {
          Painel::alert('erro','Preencha o campo Senha');
        } else if ($cargo === '') {
          Painel::alert('erro','Selecione o cargo');
        } else if ($imagem['name'] === '') {
          Painel::alert('erro','Insira uma imagem para o perfil');
        } else {
          if ($cargo >= $_SESSION['cargo']) {
            Painel::alert('erro','Você só pode selecionar cargos menores que o seu');
          } else if (Painel::imagemValida($imagem) === false) {
            Painel::alert('erro','O formato da imagem não é suportado');
          } else if (Usuario::userExists($login)) {
            Painel::alert('erro','O login já existe, selecione outro valor para Login');
          } else {
            $usuario = new Usuario;
            $imagem = Painel::uploadFile($imagem);
            $usuario->cadastrarUsuario($login,$senha,$imagem,$nome,$cargo);
            Painel::alert('sucesso','Cadastro realizado com sucesso!');
          }
        }
      }

    ?>

    <div class="form-group">
      <label for="login">Login:</label>
      <input type="text" name="login">
    </div>
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" name="nome">
    </div>
    <div class="form-group">
      <label for="password">Senha:</label>
      <input type="password" name="password">
    </div>
    <div class="form-group">
      <label for="cargo">Cargos</label>
      <select name="cargo" id="cargo">
        <?php
          foreach (Painel::$cargos as $key => $value) {
            if ($key < $_SESSION['cargo']) {
              echo '<option value="'.$key.'">'.$value.'</option>';
            }
          }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="imagem">Imagem:</label>
      <input type="file" name="imagem">
    </div>
    <div class="form-group">
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>

</div>