<?php
require_once 'utils.php';
require_once 'includes/header.php';

$anoSelecionadoPOST = htmlspecialchars($_GET['ano']);
?>

<div class="container">
  <h1 class="text-center">Gráficos Baseados no Ano de <?php echo $anoSelecionadoPOST ?></h1>

  <h3><a href="handler.php?anos=<?php echo $anoSelecionadoPOST ?>&tipo=contagem">Gráficos de Contagem</a></h3>
  <h3><a href="handler.php?anos=<?php echo $anoSelecionadoPOST ?>&tipo=porcentagem">Gráficos de Porcentagem</a></h3>
  <h3><a href="handler.php?anos=<?php echo $anoSelecionadoPOST ?>&tipo=media">Gráficos de Média</a></h3>
  <br>
  <h3><a href="handler.php?anos=<?php echo $anoSelecionadoPOST ?>">Todos os Gráficos</a></h3>

</div>

<?php
require_once 'includes/footer.php';
?>