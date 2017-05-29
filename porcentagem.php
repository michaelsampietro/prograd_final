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
            <li class="divider-vertical"><hr></li>
            <li><a href="./handler.php?anos=<?php echo $anoSelecionadoPOST ?>">Contagem</a></li>
            <li><a href="./porcentagem.php?anos=<?php echo $anoSelecionadoPOST ?>">Porcentagem</a></li>
            <li><a href="./media.php?anos=<?php echo $anoSelecionadoPOST ?>">Médias</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="col-sm-9 col-lg-10">
    <!-- Porcentagem de Estudantes matriculados por regional -->
    <!-- Gráfico de BARRA -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel panel-heading">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Idade e Regional</div>
          <div class="panel-body">
            <div id="porcentagem-faixa-etaria" style="width:100%; height:400px;"></div>
          </div>
        </div>    <!--./panel -->
      </div>      <!--./col-md-6 -->
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel panel-heading">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Idade e Regional</div>
          <div class="panel-body">
            <?php $arrayIntervaloIdades = array ("< 18",  "18 a 20", "21 a 23", "24 a 26", "27 a 29", "30 a 35", "36 a 40", "41 a 45", "> 45"); ?>
            <!-- auto generated code -->
            <table id="tabela-porcentagem-faixa-etaria"
              class="table"
              data-toggle="table"
              data-click-to-select="true"
              data-show-export="true">
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
      $arrayCategories  = array ("< 18",  "18 a 20", "21 a 23", "24 a 26", "27 a 29", "30 a 35", "36 a 40", "41 a 45", "> 45");    // Categorias do gráfico

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

    <!-- porcentagem Média global dos estudantes -->
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
              $index2 = $index + 1;
              $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `media_global` <> 0 and `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > $index and `media_global` <= $index2 and `Regional` = '$unidade'";

              $aux .= consultaSimplesRetornaString2($sql);
            }
            echo "{name: '$unidade', data:[$aux]},";
          }
          ?>
        ]
      });
    });
    </script>
    <!-- ./Porcentagem por media global -->


    <!-- Porcentagem de Estudantes por Sexo e Regional -->
    <!-- Gráfico de BARRA -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">Porcentagem de Estudantes por Sexo e Regional</div>
          <div class="panel-body">
            <div id="porcentagem-de-estudantes-por-sexo-regional" style="width:100%; height:400px;"></div>
          </div>
        </div>  <!-- ./panel -->
      </div>    <!-- ./col-md-6 -->
        <div class="col-md-6">
          <div class="panel panel-info">
            <div class="panel-heading">Porcentagem de Estudantes por Sexo e Regional</div>
            <div class="panel-body">
              <table
              id="porcentagem-estudantes-sexo-e-regional"
              class="table"
              data-toggle="table"
              data-show-export="true"
              >
                <thead>
                  <th data-sortable="true">Regional</th>
                  <th data-sortable="true">Masculino</th>
                  <th data-sortable="true">Feminino</th>
                </thead>
                <tbody>
                  <?php
                  // foreach para cada unidade
                  $arraySexos = array ("Masculino", "Feminino");
                  foreach ($arrayUnidades as $unidade => $value) {
                    echo "<tr>";
                      echo "<td>$unidade</td>";
                      //consulta banco
                      foreach ($arraySexos as $sexo) {
                        echo "<td>";
                        $sql = "SELECT count(sexo) * 100.0 / (select count(*) from `$anoSelecionadoPOST` where Regional = '$unidade') as count FROM `$anoSelecionadoPOST` where Regional = '$unidade' and `sexo` = '$sexo'";
                        echo consultaSimplesRetornaUmValor($sql);
                        echo "%</td>";
                      }
                      echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                  <?php
                  // linha TOTAL
                      echo "<th>Média Geral</th>";
                  foreach ($arraySexos as $sexo) {
                      echo "<th>";
                      $sql = "SELECT count(*) * 100.0 / (
                                SELECT COUNT(Estudante)
                                  FROM `$anoSelecionadoPOST` )
                                AS count
                                FROM `$anoSelecionadoPOST`
                                WHERE sexo = '$sexo'";
                      echo consultaSimplesRetornaUmValor($sql);
                      echo "%</th>";
                  }
                  ?>
                </tfoot>
              </table>
            </div>
          </div>  <!-- ./panel -->
        </div>    <!-- ./col-md-6 -->
    </div>      <!-- ./row -->
    <script>
      <?php  // Gerar opcoes do gráfico
      $arrayCategories  = array();    // Categorias do gráfico
      // Inserindo valores no array de categorias
      foreach ($arrayUnidades as $unidade => $value) {
        $arrayCategories[] = $unidade; // semelhante a array_push
      }

      $tipo       = 'column';                // Tipo do gráfico
      $titulo     = 'Porcentagem de Estudantes por Sexo e Regional';  // Título Gráfico
      $subtitulo  = '';   // Subtítulo do Gráfico
      $legendaY   = 'Porcentagem';       // Legenda eixo Y

      $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
      ?>
      $(function () {
          var myChart = Highcharts.chart('porcentagem-de-estudantes-por-sexo-regional', {
              <?php echo $opcoes; ?>
              tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}%</b><br/>',
                shared: true
              },
              series: [
                {name: 'Feminino', data: [<?php
                  $aux = "";
                  foreach ($arrayUnidades as $unidade => $value) {
                    $sql = "SELECT count(sexo) * 100.0 / (select count(*) from `$anoSelecionadoPOST` where Regional = '$unidade') as count FROM `$anoSelecionadoPOST` where Regional = '$unidade' and sexo = 'feminino'";
                    $aux .= consultaSimplesRetornaString2($sql);
                  }
                  echo $aux;
                  ?> ]},
                {name: 'Masculino', data: [<?php
                  $aux = "";
                  foreach ($arrayUnidades as $unidade => $value) {
                    $sql = "SELECT count(sexo) * 100.0 / (select count(*) from `$anoSelecionadoPOST` where Regional = '$unidade') as count FROM `$anoSelecionadoPOST` where Regional = '$unidade' and sexo = 'masculino'";
                    $aux .= consultaSimplesRetornaString2($sql);
                  }
                  echo $aux;
                  ?>]}
              ]
          });
      });
    </script>
    <!-- ./Porcentagem de Estudantes por Sexo e Regional -->

    <!-- Estudantes anteriores a 2012 -->
    <!-- Grafico PIZZA -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">Porcentagem de estudantes com ingresso anterior a 2012</div>
          <div class="panel-body">
            <div id="porcentagem-ingresso-ate-2012"></div>
            <h6><small>Ações Afirmativas:
              <?php foreach ($arrayAcaoAfirmativa as $acao => $value) {
                echo "$acao, ";
              }
              ?>
            </small></h6>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">Porcentagem de estudantes com ingresso anterior a 2012</div>
          <div class="panel-body">
            <table id = "tabela-ingresso-ate-2012"
            class="table"
            data-toggle="table"
            data-show-export="true">
              <thead>
                <th data-sortable="true">Ingresso</th>
                <th>Porcentagem de Estudantes</th>
              </thead>
              <tbody>
                <tr>
                  <td>Ampla Concorrência (AC)</td>
                  <td>
                  <?php
                      $sql = "SELECT count(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` <= 2012";
                    consultaSimplesRetornaUmValor($sql);
                  ?>
                  %</td>
                </tr>
                <tr>
                  <td>UFGInclui</td>
                  <td>
                      <?php
                      $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012 and `acao_afirmativa` =";
                      echo consultaSimplesRetornaSomaAsString($arrayAcaoAfirmativa, $sql);
                  ?>
                  %</td>
                </tr>
              </tbody>
            </table>
            <h6><small>Ações Afirmativas:
              <?php foreach ($arrayAcaoAfirmativa as $acao => $value) {
                echo "$acao, ";
              }
              ?>
            </small></h6>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(function() {
        var myChart = Highcharts.chart('porcentagem-ingresso-ate-2012', {
          <?php echo geraGraficoPizza('pie', '', '') ?> // Gerando opcoes do grafico
          series: [{
            name: 'Regionais',
            colorByPoint: true,
            data: [
              {
                name: 'Ampla Concorrência',
                <?php $sql = "SELECT COUNT(*) as count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012 and `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo')" ?>
                y: <?php echo consultaSimplesRetornaUmValor2($sql) ?>
              }, {
                name: 'Ação Afirmativa',
                <?php $sql = "SELECT COUNT(*) as count FROM `$anoSelecionadoPOST`  WHERE `ano_ingresso` <= 2012 and `acao_afirmativa` = " ?>
                y: <?php echo consultaSimplesRetornaSomaAsString($arrayAcaoAfirmativa, $sql) ?>
              }
            ]
          }]
        })
      });
    </script>
    <!-- ./Estudantes anteriores a 2012 -->

    <!-- Estudantes posteriores a 2013 (lei de cotas e ufginclui) -->
    <!-- Grafico PIZZA -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">Porcentagem de Estudantes com Ingresso Após 2013 (Lei de Cotas e UFGInclui)</div>
          <div class="panel-body">
            <div id="porcentagem-ingresso-apos-2013"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">Porcentagem de Estudantes com Ingresso Após 2013 (Lei de Cotas e UFGInclui)</div>
          <div class="panel-body">
            <table
            class="table"
            data-toggle="table"
            data-show-export="true">
              <thead>
                <th>Ingresso</th>
                <th>Porcentagem de Estudantes</th>
              </thead>
              <tbody>
                <tr>
                  <td>Ampla Concorrencia (AC)</td>
                  <td>
                      <?php $sql = "SELECT count(*) / (SELECT COUNT(*)
                                                         FROM   `$anoSelecionadoPOST`
                                                         WHERE  `ano_ingresso` >= 2013) * 100.0 AS count
                                      FROM   `$anoSelecionadoPOST`
                                      WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                                             and `acao_afirmativa` <> '(DC Renda Superior)'
                                             and `acao_afirmativa` <> '(PPI Renda Inferior)'
                                             and `acao_afirmativa` <> '(PPI Renda Superior)'
                                             and `acao_afirmativa` <> 'UFGInclui - Indígena'
                                             and `acao_afirmativa` <> 'UFGInclui - Quilombola'
                                             and `acao_afirmativa` <> 'UFGInclui - Surdo'
                                             and `ano_ingresso` >= 2013 ";
                      echo consultaSimplesRetornaUmValor($sql); ?>
                  %</td>
                </tr>
                <tr>
                  <td>Lei de Cotas e UFGInclui</td>
                  <td><?php $sql = "SELECT Count(*) /
                                             (
                                                    SELECT Count(*)
                                                    FROM   `$anoSelecionadoPOST`
                                                    WHERE  `ano_ingresso` >= 2013) * 100.0 AS count
                                      FROM   `$anoSelecionadoPOST`
                                      WHERE  `ano_ingresso` >= 2013
                                      AND    `acao_afirmativa` =";
                      echo consultaSimplesRetornaSomaAsString($arrayAcoesAfirmativas, $sql);?>
                  %</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(function () {
        var myChart = Highcharts.chart('porcentagem-ingresso-apos-2013', {
          <?php echo geraGraficoPizza('pie', '', '') ?> // Gerando opcoes do grafico
          series: [{
            name: 'Regionais',
            colorByPoint: true,
            data: [
              {
                name: 'Ampla Concorrência',
                <?php $sql = "SELECT COUNT(*) as count
                              FROM `$anoSelecionadoPOST`
                              WHERE `ano_ingresso`>=2013
                                and `acao_afirmativa` <> '(DC Renda Inferior)'
                                and `acao_afirmativa` <> '(DC Renda Superior)'
                                and `acao_afirmativa` <> '(PPI Renda Inferior)'
                                and `acao_afirmativa` <> '(PPI Renda Superior)'
                                and `acao_afirmativa` <> 'UFGInclui - Indígena'
                                and `acao_afirmativa` <> 'UFGInclui - Quilombola'
                                and `acao_afirmativa` <> 'UFGInclui - Surdo'";
                ?>
                y: <?php echo consultaSimplesRetornaUmValor2($sql); ?>
              }, {
                name: 'Ação Afirmativa',
                <?php $sql = "SELECT Count(*) AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` >= 2013 AND `acao_afirmativa` ="; ?>
                y: <?php echo consultaSimplesRetornaSomaAsString($arrayAcoesAfirmativas, $sql); ?>
              }
            ]
          }]
        })
      })
    </script>
    <!-- ./Estudantes posteriores a 2013 (lei de cotas e ufginclui) -->

    <!-- Estudantes matriculados em 2016 por ação afirmativa e lei de cotas -->
    <!-- Gráfico PIZZA -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">Porcentagem de Estudantes Ingressantes via SISU em <?php echo $anoSelecionadoPOST ?> por Ampla Concorrência e Ação Afirmativa</div>
          <div class="panel-body">
            <div id='porcentagem-estudantes-sisu'></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">Porcentagem de Estudantes Ingressantes via SISU em <?php echo $anoSelecionadoPOST ?> por Ampla Concorrência e Ação Afirmativa</div>
          <div class="panel-body">
            <table
            class="table"
            data-toggle="table"
            data-show-export="true">
              <thead>
                <th>Ingresso</th>
                <th>Porcentagem de Estudantes</th>
              </thead>
              <tbody>

                <?php // Dados para a tabela
                    $sql = "SELECT count(*) / (SELECT COUNT(*)
                                                       FROM `$anoSelecionadoPOST`
                                                       WHERE ano_ingresso = '$anoSelecionadoPOST'
                                                             and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                    ) * 100.0 AS count
                                    FROM `$anoSelecionadoPOST`
                                    WHERE `acao_afirmativa` <> '(DC Renda Inferior)'
                                           and `acao_afirmativa` <> '(DC Renda Superior)'
                                           and `acao_afirmativa` <> '(PPI Renda Inferior)'
                                           and `acao_afirmativa` <> '(PPI Renda Superior)'
                                           and `acao_afirmativa` <> 'UFGInclui - Negro Escola Pública'
                                           and `acao_afirmativa` <> 'UFGInclui - Indígena'
                                           and `acao_afirmativa` <> 'UFGInclui - Escola Pública'
                                           and `acao_afirmativa` <> 'UFGInclui - Quilombola'
                                           and `acao_afirmativa` <> 'UFGInclui - Surdo'
                                           and ano_ingresso = '$anoSelecionadoPOST'
                                           and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'";

                    // Ao invés de fazer uma nova pesquisa, é mais eficiente simplesmente fazer a diferença (visto que esses são os únicos dois dados no gráfico. Sendo assim, a função retorna um array para um vetor auxiliar. A diferença entre 100 e esse vetor será a outra porcentagem necessária.
                    $amplaConcorrencia = consultaSimplesRetornaArray($sql);
                    $acaoAfirmativa = 100 - $amplaConcorrencia[0]; ?>
                <tr>
                  <td>Ampla Concorrência (AC)</td>
                  <td><?php echo round($amplaConcorrencia[0], 2) ?>%</td>
                </tr>
                <tr>
                  <td>Lei de Cotas e UFGInclui</td>
                  <td><?php echo round($acaoAfirmativa, 2) ?>%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(function () {
        var myChart = Highcharts.chart('porcentagem-estudantes-sisu', {
          <?php echo geraGraficoPizza('pie', '', '') ?> // Gerando opcoes do grafico
          series: [{
            name: 'Regionais',
            colorByPoint: true,
            data: [
              {
                name: 'Ampla Concorrência',
                <?php $sql = "SELECT count(*) AS count
                              FROM `$anoSelecionadoPOST`
                              WHERE `acao_afirmativa` <> '(DC Renda Inferior)'
                                and `acao_afirmativa` <> '(DC Renda Superior)'
                                and `acao_afirmativa` <> '(PPI Renda Inferior)'
                                and `acao_afirmativa` <> '(PPI Renda Superior)'
                                and `acao_afirmativa` <> 'UFGInclui - Negro Escola Pública'
                                and `acao_afirmativa` <> 'UFGInclui - Indígena'
                                and `acao_afirmativa` <> 'UFGInclui - Escola Pública'
                                and `acao_afirmativa` <> 'UFGInclui - Quilombola'
                                and `acao_afirmativa` <> 'UFGInclui - Surdo'
                                and ano_ingresso = '$anoSelecionadoPOST'
                                and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'";
                ?>
                y: <?php echo consultaSimplesRetornaUmValor2($sql); ?>
              }, {
                name: 'Ação Afirmativa',
                <?php $sql = "SELECT Count(*) AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` = '$anoSelecionadoPOST' and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU' AND `acao_afirmativa` ="; ?>
                y: <?php echo consultaSimplesRetornaSomaAsString($arrayAcoesAfirmativasCompleto, $sql); ?>
              }
            ]
          }]
        })
      })
    </script>
    <!-- ./Estudantes matriculados em 2016 por ação afirmativa -->

  </div>
</div>

  <?php require_once('includes/footer.php'); ?>
