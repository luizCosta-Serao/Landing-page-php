<?php
  if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    $selectImagem = MySql::conectar()->prepare("SELECT capa FROM `site_noticias` WHERE id = ?");
    $selectImagem->execute(array($_GET['excluir']));

    $imagem = $selectImagem->fetch()['capa'];
    Painel::deleteFile($imagem);
    Painel::deletar('site_noticias',$idExcluir);
    Painel::redirect(INCLUDE_PATH_PAINEL.'/gerenciar-noticias');
  }

  // Paginação
  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $porPagina = 2;

  $noticias = Painel::selectAll('site_noticias',($paginaAtual - 1) * $porPagina,$porPagina);
?>

<div class="box-content">
  <h2>Notícias Cadastradas</h2>

  <table>
    <tr>
      <td>Título</td>
      <td>Categoria</td>
      <td>Imagem</td>
      <td>Editar</td>
      <td>Deletar</td>
    </tr>
    <?php
      // Inserindo informações da tabela na página
      foreach ($noticias as $key => $value) {
        $nomeCategoria = MySql::conectar()->prepare("SELECT `nome` FROM `site_categorias` WHERE id = ?");
        $nomeCategoria->execute(array($value['categoria_id']));
        $nomeCategoria = $nomeCategoria->fetch();
    ?>
      <tr>
        <td><?php echo $value['titulo']; ?></td>
        <td><?php echo $nomeCategoria['nome']; ?></td>
        <td><img style="width:70px; height:85px;" src="<?php echo INCLUDE_PATH_PAINEL; ?>/uploads/<?php echo $value['capa'] ?>" alt=""></td>
        <td class="editar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/editar-noticia?id=<?php echo $value['id']; ?>">Editar</a></td>
        <td actionBtn="delete" class="deletar"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>/gerenciar-noticias?excluir=<?php echo $value['id'];  ?>">X</a></td>
      </tr>
    <?php } ?>
  </table>
  <div class="paginação">
    <?php
      $totalPaginas = ceil(count(Painel::selectAll('site_noticias'))/ $porPagina);
      
      for($i = 1; $i <= $totalPaginas; $i++) {
        if ($i === $paginaAtual) {
          echo '<a class="active" href="'.INCLUDE_PATH_PAINEL.'/gerenciar-noticias?pagina='.$i.'">'.$i.'</a>';
        } else {
          echo '<a href="'.INCLUDE_PATH_PAINEL.'/gerenciar-noticias?pagina='.$i.'">'.$i.'</a>';
        }
      }
    ?>
  </div>
</div>