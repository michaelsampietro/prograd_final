<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require_once 'utils.php';
  require_once 'includes/header.php';

  $anoSelecionadoPOST = htmlspecialchars($_GET['anos']);

  if (isset($_GET['tipo']))
      $tipo = htmlspecialchars($_GET['tipo']);

  $arrayUnidades      = array(
      'Goiânia' => 0,
      'Jataí' => 0,
      'Catalão' => 0,
      'Goiás' => 0
  );
  $arrayGrauAcademico = array(
      'BACHARELADO' => 0,
      'BACHARELADO E LIC.' => 0,
      'GRAU NÃO DEFINIDO' => 0,
      'LICENCIATURA' => 0
  );
  $arrayLeiDeCotas = array(
      'UFGInclui - Escola Pública' => 0,
      'UFGInclui - Negro Escola Pública' => 0,
      'UFGInclui - Indígena' => 0,
      'UFGInclui - Quilombola' => 0,
      'UFGInclui - Surdo' => 0,
  );
  $arrayRendas = array(
      '(DC Renda Inferior)' => 0,
      '(PPI Renda Inferior)' => 0,
      '(DC Renda Superior)' => 0,
      '(PPI Renda Superior)' => 0,
  );
  $arrayBackgroundColor = array(
      'Goiânia' => "rgba(54, 162, 235, .7)",
      'Jataí' => "rgba(184, 18, 0, 0.7)",
      'Catalão' => "rgba(0, 66, 10, 0.7)",
      'Goiás' => "rgba(209, 206, 0, 0.7)",
  );
  // O array abaixo inclui todas as categorias de acao afirmativa
  $arrayAcoesAfirmativas = array(
    // 'UFGInclui - Escola Pública' => 0,
    // 'UFGInclui - Negro Escola Pública' => 0,
    '(DC Renda Inferior)' => 0,
    '(PPI Renda Inferior)' => 0,
    '(DC Renda Superior)' => 0,
    '(PPI Renda Superior)' => 0,
    'UFGInclui - Indígena' => 0,
    'UFGInclui - Quilombola' => 0,
    'UFGInclui - Surdo' => 0,
  );

  // Pegando array de anos
  $sql = "SELECT distinct ano_ingresso FROM `$anoSelecionadoPOST` where ano_ingresso >= 2011 order by ano_ingresso asc";
  $arrayAnos = consultaSimplesRetornaArray($sql);
?>

<div class="row">
  <div class="col-sm-3 col-lg-2">
    <div class="sidebar-nav">
      <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="visible-xs navbar-brand">Menu</span>
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="./">Início</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categorias <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="divider"></li>
                <li class="dropdown-header">Tipos de Gráficos</li>
                <li><a href="./handler_novo.php?anos=<?php echo $anoSelecionadoPOST ?>">Contagem</a></li>
                <li><a href="./porcentagem.php?anos=<?php echo $anoSelecionadoPOST ?>">Porcentagem</a></li>
                <li><a href="#">Médias</a></li>
                <li><a href="#">Todos</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="col-sm-9 col-lg-10"> <!-- Conteudo -->
    <!-- Porcentagem de Estudantes matriculados por regional -->
    <!-- Gráfico de BARRA -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel panel-heading">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Regional</div>
          <div class="panel-body">
            <div id="porcentagem-faixa-etaria" style="width:100%; height:400px;"></div>
          </div>
        </div>    <!--./panel -->
      </div>      <!--./col-md-6 -->
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel panel-heading">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Regional</div>
          <div class="panel-body">
            <?php $arrayIntervaloIdades = array ("< 18",  "18 a 20", "21 a 23", "24 a 26", "27 a 29", "30 a 35", "36 a 40", "41 a 45", "> 45"); ?>
            <!-- auto generated code -->
            <table id="tabela-porcentagem-faixa-etaria"
              class="table"
              data-toggle="table"
              data-click-to-select="true">
              <thead>
                <th data-sortable="true">Regional</th>
                <?php
                for ($i=0; $i < sizeof($arrayIntervaloIdades); $i++)
                    echo "<th data-sortable='true'>$arrayIntervaloIdades[$i]</th>";
                ?>
              </thead>
              <tbody>
                <?php
                //replacing "A" com "AND" para usar no banco
                for ($i=0; $i < sizeof($arrayIntervaloIdades); $i++)
                    $arrayIntervaloIdades[$i] = preg_replace("/a/", "and", $arrayIntervaloIdades[$i]);

                foreach ($arrayUnidades as $unidade => $value) {
                    echo "<tr>";
                    echo "<td>$unidade</td>";
                    foreach ($arrayIntervaloIdades as $intervalo) {
                        echo "<td>";
                        if(preg_match('/and/i', $intervalo))
                            $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN $intervalo and `Regional` = '$unidade'";
                        else
                            $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) $intervalo AND `Regional` = '$unidade'";

                        consultaSimplesRetornaUmValor($sql);
                        echo "%</td>";
                    }
                    echo "</tr>";
                }
                ?>
              </tbody>
              <tfoot>
                <th>Total</th>
                <?php foreach ($arrayIntervaloIdades as $intervalo) {
                  echo "<th>";
                  if(preg_match('/and/i', $intervalo))
                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN $intervalo";
                  else
                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) $intervalo";

                  consultaSimplesRetornaUmValor($sql);
                  echo "%</th>";
                } ?>
              </tfoot>
            </table>
          </div>
        </div>    <!--./panel -->
      </div>      <!--./col-md-6 -->
    </div>        <!--./row -->
    <script>
      <?php  // Gerar opcoes do gráfico
      $arrayCategories  = array();    // Categorias do gráfico
      // Inserindo valores no array de categorias
      foreach ($arrayIntervaloIdades as $intervalo) {
        $arrayCategories[] = $intervalo;
      }

      $tipo       = 'column';               // Tipo do gráfico
      $titulo     = '';                     // Título Gráfico
      $subtitulo  = '';                     // Subtítulo do Gráfico
      $legendaY   = 'Porcentagem de Estudantes'; // Legenda eixo Y

      $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
      ?>

      $(function () {
      var myChart = Highcharts.chart('porcentagem-faixa-etaria', {
        <?php echo $opcoes; ?>
        tooltip: {
          pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}%</b><br/>',
          shared: true
        },
        series: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $aux = "";
            foreach ($arrayIntervaloIdades as $intervalo) {
              if(preg_match('/and/i', $intervalo))
                $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN $intervalo and `Regional` = '$unidade'";
              else
                $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) $intervalo AND `Regional` = '$unidade'";

              $aux .= consultaSimplesRetornaUmValor2($sql).",";
            }
            echo "{name: '$unidade', data:[$aux]},";
          }
          ?>
        ]
      });
    });
    </script>
    <!-- ./Porcentagem de Estudantes matriculados por regional -->

    <!-- Porcentagem de Estudantes matriculados por regional -->
    <!-- Gráfico de BARRA -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel panel-heading">Porcentagem da media global dos alunos <?php echo $anoSelecionadoPOST; ?> por Regional</div>
          <div class="panel-body">
            <div id="porcentagem-media-global" style="width:100%; height:400px;"></div>
          </div>
        </div>    <!--./panel -->
      </div>      <!--./col-md-6 -->
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel panel-heading">Porcentagem da media global dos alunos <?php echo $anoSelecionadoPOST; ?> por Regional</div>
          <div class="panel-body">
            <table id="tabela-porcentagem-media-global"
            class="table"
            data-toggle="table"
            data-single-select="true"
            data-click-to-select="true"
            data-show-export="true">
              <thead>
                <tr>
                  <th></th>
                  <th colspan="10" class="text-center">Faixas das Médias</th>
                </tr>
                <tr>
                  <th data-sortable="true">Regional</th>
                  <?php
                  for ($index = 0; $index < 10; $index++) {
                    $aux = $index + 1;
                    echo "<th data-sortable='true'>$index e $aux</th>";
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($arrayUnidades as $unidade => $value) {
                  echo "<tr>";
                  echo "<td>$unidade</td>";
                  for ($index = 0; $index < 10; $index++) {

                      $aux = $index + 1;
                      $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `media_global` <> 0 AND `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > $index and `media_global` <= $aux AND `Regional` = '$unidade'";


                      echo "<td>";
                      consultaSimplesRetornaUmValor($sql);
                      echo "%</td>";
                  }
                  echo "</tr>";
                }
                ?>
              </tbody>
              <tfoot>
                <?php echo "<th>Total</th>";
                for ($index = 0; $index < 10; $index++) {
                  $aux = $index + 1;
                  $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `media_global` <> 0) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > $index and `media_global` <= $aux";

                  echo "<th>";
                  consultaSimplesRetornaUmValor($sql);
                  echo "%</th>";
                } ?>
              </tfoot>
            </table>
          </div>
        </div>    <!--./panel -->
      </div>      <!--./col-md-6 -->
    </div>        <!--./row -->
    <script>
      <?php  // Gerar opcoes do gráfico
      $arrayCategories  = array();    // Categorias do gráfico
      // Inserindo valores no array de categorias
      for ($i=1; $i <= 10; $i++) {
        $arrayCategories[] = $i;
      }

      $tipo       = 'column';               // Tipo do gráfico
      $titulo     = '';                     // Título Gráfico
      $subtitulo  = '';                     // Subtítulo do Gráfico
      $legendaY   = 'Porcentagem de Estudantes'; // Legenda eixo Y

      $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
      ?>

      $(function () {
      var myChart = Highcharts.chart('porcentagem-media-global', {
        <?php echo $opcoes; ?>
        tooltip: {
          pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}%</b><br/>',
          shared: true
        },
        series: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $aux = "";
            for ($index = 0; $index < 10; $index++) {
              $aux = $index + 1;
              $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `media_global` <> 0 AND `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > $index and `media_global` <= $aux AND `Regional` = '$unidade'";

              $aux .= consultaSimplesRetornaString2($sql);
            }
            echo "{name: '$unidade', data:[$aux]},";
          }
          ?>
        ]
      });
    });
    </script>
    <!-- ./Porcentagem de Estudantes matriculados por regional -->

  </div>
</div>

  <?php require_once('includes/footer.php'); ?>
