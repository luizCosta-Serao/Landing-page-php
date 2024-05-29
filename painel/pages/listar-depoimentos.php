<?php
  if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    Painel::deletar('site_depoimentos',$idExcluir);
    Painel::redirect(INCLUDE_PATH_PAINEL.'/listar-depoimentos');
  }

  // Paginação
  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $porPagina = 2;

  $depoimentos = Painel::selectAll('site_depoimentos',($paginaAtual - 1) * $porPagina,$porPagina);
?>

<div class="box-content">
  <h2>Depoimentos Cadastrados</h2>

  <table>
    <tr>
      <td>Nome</td>
      <td>Data</td>
      <td>Editar</td>
      <td>Deletar</td>
    </tr>
    <?php
      // Inserindo informações da tabela na página
      foreach ($depoimentos as $key => $value) {
    ?>
      <tr>
        <td><?php echo $value['nome']; ?></td>
        <td><?php echo $value['data']; ?></td>
        <td class="editar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/editar-depoimento?id=<?php echo $value['id']; ?>">Editar</a></td>
        <td actionBtn="delete" class="deletar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/listar-depoimentos?excluir=<?php echo $value['id'];  ?>">X</a></td>
      </tr>
    <?php } ?>
  </table>
  <div class="paginação">
    <?php
      $totalPaginas = ceil(count(Painel::selectAll('site_depoimentos'))/ $porPagina);
      
      for($i = 1; $i <= $totalPaginas; $i++) {
        if ($i === $paginaAtual) {
          echo '<a class="active" href="'.INCLUDE_PATH_PAINEL.'/listar-depoimentos?pagina='.$i.'">'.$i.'</a>';
        } else {
          echo '<a href="'.INCLUDE_PATH_PAINEL.'/listar-depoimentos?pagina='.$i.'">'.$i.'</a>';
        }
      }
    ?>
  </div>
</div>