<?php
  if (isset($_COOKIE['lembrar'])) {
    $user = $_COOKIE['user'];
    $password = $_COOKIE['password'];
    $sql = MySql::conectar()->prepare('SELECT * FROM `usuarios_admin` WHERE user = ? AND password = ?');
    $sql->execute(array($user,$password));
    if($sql->rowCount() === 1) {
      $info = $sql->fetch();
      $_SESSION['login'] = true;
      $_SESSION['user'] = $user;
      $_SESSION['password'] = $password;
      $_SESSION['cargo'] = $info['cargo'];
      $_SESSION['nome'] = $info['nome'];
      $_SESSION['img'] = $info['img'];

      Painel::redirect(INCLUDE_PATH_PAINEL);
      die();
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>/styles/style.css">
  <title>Painel de Controle</title>
</head>
<body>
  <div class="box-login">
    <?php

      if (isset($_POST['acao'])) {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $sql = MySql::conectar()->prepare('SELECT * FROM `usuarios_admin` WHERE user = ? AND password = ?');
        $sql->execute(array($user,$password));
        if ($sql->rowCount() === 1) {
          $info = $sql->fetch();

          $_SESSION['login'] = true;
          $_SESSION['user'] = $user;
          $_SESSION['password'] = $password;
          $_SESSION['cargo'] = $info['cargo'];
          $_SESSION['nome'] = $info['nome'];
          $_SESSION['img'] = $info['img'];
          if (isset($_POST['lembrar'])) {
            setcookie('lembrar',true, time()+(60*60*24),'/');
            setcookie('user',$user,time()+(60*60*24),'/');
            setcookie('password',$password,time()+(60*60*24),'/');
          }
          Painel::redirect(INCLUDE_PATH_PAINEL);
          die();
        } else {
          echo '<div class="error-box">Usuário ou Senha incorretos</div>';
        }
      }
    ?>
    <h2>Efetue o Login</h2>
    <form action="" method="post">
      <input type="text" name="user" placeholder="Login" required>
      <input type="password" name="password" placeholder="Password" required>
      <div class="form-group-login">
        <input type="submit" name="acao" value="Logar" required>
      </div>
      <div class="form-group-login">
        <label for="lembrar">Lembrar-me</label>
        <input type="checkbox" name="lembrar" id="lembrar">
      </div>
    </form>
  </div>
</body>
</html>