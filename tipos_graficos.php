<?php
require_once 'utils.php';
require_once 'includes/header.php';

$anoSelecionadoPOST = htmlspecialchars($_POST['anos']);
?>

<div class="container text-center">
  <h1>Gráficos Baseados no Ano de <?php echo $anoSelecionadoPOST; ?></h1>

  <h3><a href="#">Gráficos de Contagem</a></h3>
  <h3><a href="#">Gráficos de Porcentagem</a></h3>
  <h3><a href="#">Gráficos de Média</a></h3>
</div>

<?php
require_once 'includes/footer.php';
?>
