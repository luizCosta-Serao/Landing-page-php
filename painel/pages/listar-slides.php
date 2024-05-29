<?php
  if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    $selectImagem = MySql::conectar()->prepare("SELECT slide FROM `site_slides` WHERE id = ?");
    $selectImagem->execute(array($_GET['excluir']));

    $imagem = $selectImagem->fetch()['slide'];
    Painel::deleteFile($imagem);
    Painel::deletar('site_slides',$idExcluir);
    Painel::redirect(INCLUDE_PATH_PAINEL.'/listar-slides');
  }

  // Paginação
  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $porPagina = 2;

  $slides = Painel::selectAll('site_slides',($paginaAtual - 1) * $porPagina,$porPagina);
?>

<div class="box-content">
  <h2>Slides Cadastrados</h2>

  <table>
    <tr>
      <td>Nome</td>
      <td>Slide</td>
      <td>Editar</td>
      <td>Deletar</td>
    </tr>
    <?php
      // Inserindo informações da tabela na página
      foreach ($slides as $key => $value) {
    ?>
      <tr>
        <td><?php echo $value['nome']; ?></td>
        <td><img style="width:70px; height:85px;" src="<?php echo INCLUDE_PATH_PAINEL; ?>/uploads/<?php echo $value['slide'] ?>" alt=""></td>
        <td class="editar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/editar-slide?id=<?php echo $value['id']; ?>">Editar</a></td>
        <td actionBtn="delete" class="deletar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/listar-slides?excluir=<?php echo $value['id'];  ?>">X</a></td>
      </tr>
    <?php } ?>
  </table>
  <div class="paginação">
    <?php
      $totalPaginas = ceil(count(Painel::selectAll('site_slides'))/ $porPagina);
      
      for($i = 1; $i <= $totalPaginas; $i++) {
        if ($i === $paginaAtual) {
          echo '<a class="active" href="'.INCLUDE_PATH_PAINEL.'/listar-slides?pagina='.$i.'">'.$i.'</a>';
        } else {
          echo '<a href="'.INCLUDE_PATH_PAINEL.'/listar-slides?pagina='.$i.'">'.$i.'</a>';
        }
      }
    ?>
  </div>
</div>