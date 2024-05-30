<?php
  if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);

    Painel::deletar('site_categorias',$idExcluir);
    $noticias = MySql::conectar()->prepare("SELECT * FROM `site_noticias` WHERE categoria_id = ?");
    $noticias->execute(array($idExcluir));
    $noticias = $noticias->fetchAll();
    foreach ($noticias as $key => $value) {
      $imgDelete = $value['capa'];
      Painel::deleteFile($imgDelete);
    }
    $noticias = MySql::conectar()->prepare("DELETE FROM `site_noticias` WHERE categoria_id = ?");
    $noticias->execute(array($idExcluir));
    Painel::redirect(INCLUDE_PATH_PAINEL.'/gerenciar-categorias');
  }

  // Paginação
  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $porPagina = 2;

  $categorias = Painel::selectAll('site_categorias',($paginaAtual - 1) * $porPagina,$porPagina);
?>

<div class="box-content">
  <h2>Categorias Cadastradas</h2>

  <table>
    <tr>
      <td>Nome</td>
      <td>Editar</td>
      <td>Deletar</td>
    </tr>
    <?php
      // Inserindo informações da tabela na página
      foreach ($categorias as $key => $value) {
    ?>
      <tr>
        <td><?php echo $value['nome']; ?></td>
        <td class="editar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/editar-categoria?id=<?php echo $value['id']; ?>">Editar</a></td>
        <td actionBtn="delete" class="deletar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/gerenciar-categorias?excluir=<?php echo $value['id'];  ?>">X</a></td>
      </tr>
    <?php } ?>
  </table>
  <div class="paginação">
    <?php
      $totalPaginas = ceil(count(Painel::selectAll('site_categorias'))/ $porPagina);
      
      for($i = 1; $i <= $totalPaginas; $i++) {
        if ($i === $paginaAtual) {
          echo '<a class="active" href="'.INCLUDE_PATH_PAINEL.'/gerenciar-categorias?pagina='.$i.'">'.$i.'</a>';
        } else {
          echo '<a href="'.INCLUDE_PATH_PAINEL.'/gerenciar-categorias?pagina='.$i.'">'.$i.'</a>';
        }
      }
    ?>
  </div>
</div>