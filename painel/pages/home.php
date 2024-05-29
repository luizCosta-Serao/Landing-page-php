<?php
  $usuariosOnline = Painel::listarUsuariosOnline();

  $pegarVisitasTotais = MySql::conectar()->prepare("SELECT * FROM `usuarios_visitas`");
  $pegarVisitasTotais->execute();

  $pegarVisitasTotais = $pegarVisitasTotais->rowCount();

  $pegarVisitasHoje = MySql::conectar()->prepare("SELECT * FROM `usuarios_visitas` WHERE dia = ?");
  $pegarVisitasHoje->execute(array(date('Y-m-d')));

  $pegarVisitasHoje = $pegarVisitasHoje->rowCount();
?>
<div class="box-content">
        <h2>Painel de Controle - <?php echo NOME_EMPRESA ?></h2>

        <div class="box-metricas">
          <div class="box-metricas-single">
            <h2>Usuários Online</h2>
            <p><?php echo count($usuariosOnline); ?></p>
          </div>

          <div class="box-metricas-single">
            <h2>Total de visitas</h2>
            <p><?php echo $pegarVisitasTotais; ?></p>
          </div>

          <div class="box-metricas-single">
            <h2>Visitas Hoje</h2>
            <p><?php echo $pegarVisitasHoje; ?></p>
          </div>
        </div>
    </div>

<div class="box-content">
  <h2>Usuários Online no Site</h2>
  <div class="table-responsive">
    <div class="row">
      <div class="col">
        <span>IP</span>
      </div>
      <div class="col">
        <span>Última Ação</span>
      </div>
    </div>
    <?php
      foreach ($usuariosOnline as $key => $value) {
    ?>
      <div class="row">
        <div class="col">
          <span><?php echo $value['ip']; ?></span>
        </div>
        <div class="col">
          <span><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao'])); ?></span>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<div class="box-content">
  <h2>Usuários do Painel</h2>
  <div class="table-responsive">
    <div class="row">
      <div class="col">
        <span>Nome</span>
      </div>
      <div class="col">
        <span>Cargo</span>
      </div>
    </div>
    <?php
      $usuariosPainel = MySql::conectar()->prepare("SELECT * FROM `usuarios_admin`");
      $usuariosPainel->execute();
      $usuariosPainel = $usuariosPainel->fetchAll();
      foreach ($usuariosPainel as $key => $value) {
    ?>
      <div class="row">
        <div class="col">
          <span><?php echo $value['user']; ?></span>
        </div>
        <div class="col">
          <span><?php echo pegaCargo($value['cargo']); ?></span>
        </div>
      </div>
    <?php } ?>
  </div>
</div>