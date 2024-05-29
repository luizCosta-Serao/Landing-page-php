<?php
  if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    Painel::deletar('site_servicos',$idExcluir);
    Painel::redirect(INCLUDE_PATH_PAINEL.'/listar-servicos');
  }

  // Paginação
  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $porPagina = 2;

  $servicos = Painel::selectAll('site_servicos',($paginaAtual - 1) * $porPagina,$porPagina);
?>

<div class="box-content">
  <h2>Depoimentos Cadastrados</h2>

  <table>
    <tr>
      <td>Serviço</td>
      <td>Editar</td>
      <td>Deletar</td>
    </tr>
    <?php
      // Inserindo informações da tabela na página
      foreach ($servicos as $key => $value) {
    ?>
      <tr>
        <td><?php echo $value['servico']; ?></td>
        <td class="editar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/editar-servicos?id=<?php echo $value['id']; ?>">Editar</a></td>
        <td actionBtn="delete" class="deletar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/listar-servicos?excluir=<?php echo $value['id'];  ?>">X</a></td>
      </tr>
    <?php } ?>
  </table>
  <div class="paginação">
    <?php
      $totalPaginas = ceil(count(Painel::selectAll('site_servicos'))/ $porPagina);
      
      for($i = 1; $i <= $totalPaginas; $i++) {
        if ($i === $paginaAtual) {
          echo '<a class="active" href="'.INCLUDE_PATH_PAINEL.'/listar-servicos?pagina='.$i.'">'.$i.'</a>';
        } else {
          echo '<a href="'.INCLUDE_PATH_PAINEL.'/listar-servicos?pagina='.$i.'">'.$i.'</a>';
        }
      }
    ?>
  </div>
</div>