<?php
require_once 'utils.php';
require_once 'includes/header.php';

$anoSelecionadoPOST = htmlspecialchars($_GET['ano']);
?>

<div class="container text-center">
  <h1>Gráficos Baseados no Ano de <?php echo $anoSelecionadoPOST ?></h1>

  <a href="handler.php?anos=<?php echo $anoSelecionadoPOST ?>">Teste</a>

</div>

<?php
require_once 'includes/footer.php';
?>
