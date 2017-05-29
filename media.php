<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require_once 'utils.php';
  require_once 'includes/header.php';

  $urlAtual = $_SERVER['REQUEST_URI'];

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
            <li><a href="./">Início</a></li>
            <li class="divider-vertical"><hr></li>
            <li><a href="./handler.php?anos=<?php echo $anoSelecionadoPOST ?>">Contagem</a></li>
            <li><a href="./porcentagem.php?anos=<?php echo $anoSelecionadoPOST ?>">Porcentagem</a></li>
            <li class="active"><a href="./media.php?anos=<?php echo $anoSelecionadoPOST ?>">Médias</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="col-sm-9 col-lg-10">
    <div class="row">
      <div class="col-md-5 col-lg-5 col-sm-9 col-xs-12">
        <form class="form-inline" action="<?php echo $urlAtual ?>.php" method="get">
            <div class='form-group'>
                <label for='sel1'>Escolha um ano: </label>
                <select class='form-control' id='sel1' name='anos'>
                    <!-- Função para gerar um dropdown com anos -->
                    <?php dropdownAnos(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Selecionar</button>
        </form>
      </div>
    </div>
    <hr>


    <!-- Média das médias anterior a 2012 (UFGInclui) -->
    <!-- Gráfico de colunas -->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            Média Das Médias Globais Por Ação Afirmativa E Por Regional De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Com Ingresso Até 2012
          </div>
          <div class="panel-body">
            <div id="media-medias-globais-anterior-2012"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            Média Das Médias Globais Por Ação Afirmativa E Por Regional De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Com Ingresso Até 2012
          </div>
          <div class="panel-body">
            <table class="table"
            data-toggle="table"
            data-show-export="true">
            <thead>
              <tr>
                  <th></th>
                  <th></th>
                  <th colspan="5" class="text-center">UFGInclui até 2012</th>
              </tr>
              <tr>
                  <th data-sortable="true" class="text-center">Regional</th>
                  <th data-sortable="true" class="text-center">Ampla Concorrência</th>
                  <th data-sortable="true" class="text-center">10% para Escola Pública</th>
                  <th data-sortable="true" class="text-center">10% para Negro Escola Pública</th>
                  <th data-sortable="true" class="text-center">Vaga Extra para Indígena</th>
                  <th data-sortable="true" class="text-center">Vaga Extra para Negro Quilombola</th>
                  <th data-sortable="true" class="text-center">Reserva de 15 vagas Surdo *</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach ($arrayUnidades as $unidade => $value) : ?>
                    <tr>
                        <td class="text-center"><?php echo $unidade; ?></td>

                        <!-- Dados ampla concorrência -->
                        <td class="mediaAmplaConcorrencia">
                            <?php
                            $sql = "SELECT AVG(`media_global`) AS count
                                    FROM `$anoSelecionadoPOST`
                                    WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                                            AND `acao_afirmativa` <> '(DC Renda Superior)'
                                            AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                                            AND `acao_afirmativa` <> '(PPI Renda Superior)'
                                            AND `acao_afirmativa` <> ( 'UFGInclui - Negro Escola Pública' )
                                            AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                                            AND `acao_afirmativa` <> ( 'UFGInclui - Escola Pública' )
                                            AND `acao_afirmativa` <> ( 'UFGInclui - Quilombola' )
                                            AND `acao_afirmativa` <> ( 'UFGInclui - Surdo' )
                                            AND `ano_ingresso` <= 2012
                                            AND `Regional` = '$unidade'";

                            echo consultaSimplesRetornaUmValor($sql);
                            ?>
                        </td>

                        <!-- Loop por acao afirmativa (UFG Inclui apenas!) -->
                        <?php foreach ($arrayAcaoAfirmativa as $acao => $value) : ?>
                            <?php
                                $aux = array("esc-pub", "negro-esc-pub", "indigena", "quilombola", "surdo");
                                $index = 0;
                            ?>
                            <td class="media-<?php echo $aux[$index]; ?>">
                                <?php $sql = "SELECT AVG(`media_global`) AS count
                                        FROM `$anoSelecionadoPOST`
                                        WHERE `acao_afirmativa` = '$acao'
                                               AND `ano_ingresso` <= 2012
                                               AND `Regional` = '$unidade'";

                                echo consultaSimplesRetornaUmValor($sql);
                                ?>
                            </td>
                        <?php $index++; endforeach; ?>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <!-- Linha TOTAL -->
                </tr>
                    <!-- Criação da última linha (TOTAL), referente à média das columas acima.
                    A estrutura é basicamente a mesma da inserção das estruturas, mas decidi separar para deixar o código um pouco mais legível. As queries continuam basicamente a mesma, a diferença é que é passado um vetor contendo todas as regionais para uma função que retorna a soma da consulta realizada em todas as regionais, obtendo assim o valor total desejado. -->
                    <tr>
                        <th class="text-center">Total</th>
                        <th>
                        <?php
                        $sql = "SELECT AVG(`media_global`) AS count
                                FROM `$anoSelecionadoPOST`
                                WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                                        AND `acao_afirmativa` <> '(DC Renda Superior)'
                                        AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                                        AND `acao_afirmativa` <> '(PPI Renda Superior)'
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Negro Escola Pública' )
                                        AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Escola Pública' )
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Quilombola' )
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Surdo' )
                                        AND `ano_ingresso` <= 2012
                                        AND `Regional` = ";

                        echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                        ?>
                      </th>

                        <!-- Média geral do UFGInclui -->
                        <?php foreach ($arrayAcaoAfirmativa as $acao => $value) : ?>
                            <th>
                                <?php
                                $sql = "SELECT AVG(`media_global`) AS count
                                        FROM `$anoSelecionadoPOST`
                                        WHERE `acao_afirmativa` = '$acao'
                                               AND `ano_ingresso` <= 2012
                                               AND Regional = ";
                                echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                                ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>


              </tfoot>
            </table>
            <h6> <small>* Para o curso de Letras: Libras da Regional Goiânia</small></h6>
          </div>
        </div>
      </div>
    </div>
    <script>
      <?php  // Gerar opcoes do gráfico
      $arrayCategories  = array ("AC");    // Categorias do gráfico
      foreach ($arrayAcaoAfirmativa as $acao => $value) {
        $arrayCategories[] = $acao;
      }


      $tipo       = 'column';               // Tipo do gráfico
      $titulo     = '';                     // Título Gráfico
      $subtitulo  = '';                     // Subtítulo do Gráfico
      $legendaY   = 'Média Global'; // Legenda eixo Y

      $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
      ?>

      $(function () {
      var myChart = Highcharts.chart('media-medias-globais-anterior-2012', {
        <?php echo $opcoes; ?>
        series: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $aux = "";

            // Ampla concorrencia (AC)
            $sql = "SELECT AVG(`media_global`) AS count
                    FROM `$anoSelecionadoPOST`
                    WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                            AND `acao_afirmativa` <> '(DC Renda Superior)'
                            AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                            AND `acao_afirmativa` <> '(PPI Renda Superior)'
                            AND `acao_afirmativa` <> ( 'UFGInclui - Negro Escola Pública' )
                            AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                            AND `acao_afirmativa` <> ( 'UFGInclui - Escola Pública' )
                            AND `acao_afirmativa` <> ( 'UFGInclui - Quilombola' )
                            AND `acao_afirmativa` <> ( 'UFGInclui - Surdo' )
                            AND `ano_ingresso` <= 2012
                            AND `Regional` = '$unidade'";

            $aux .= consultaSimplesRetornaUmValor2($sql).",";

            // Ações afirmativas
            foreach ($arrayAcaoAfirmativa as $acao => $value) {
              $sql = "SELECT AVG(`media_global`) AS count
                      FROM `$anoSelecionadoPOST`
                      WHERE `acao_afirmativa` = '$acao'
                             AND `ano_ingresso` <= 2012
                             AND Regional = '$unidade'";
              $aux .= consultaSimplesRetornaUmValor2($sql).",";
              }
            echo "{name: '$unidade', data:[$aux]},";
          }
          ?>
        ]
      });
      });
    </script>

    <hr>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            Média Das Médias Globais Dos Estudantes Ingresso Pelo Programa Ufginclui E Pela Lei De Cotas Matriculados Em <?pho echo $anoSelecionadoPOST; ?> Com Ingresso Entre 2013 e 2015
          </div>
          <div class="panel-body">
            <div id="media-medias-globais-entre-2013-e-2015"></div>
            <h6> <small>AC = Ampla Concorrência, L1 = Baixa Renda, L2 = Baixa Renda PPI, L3 = Independete da Renda, L4 = Independente da Renda PPI</small></h6>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            Média Das Médias Globais Dos Estudantes Ingresso Pelo Programa Ufginclui E Pela Lei De Cotas Matriculados Em <?pho echo $anoSelecionadoPOST; ?> Com Ingresso Entre 2013 e 2015
          </div>
          <div class="panel-body">
            <table class="table"
            data-toggle="table"
            data-show-export="true">
              <thead>
                <tr>
                    <th data-sortable="true" rowspan="2" class="text-center" style="vertical-align: middle;">Regional</th>
                    <th colspan="5" class="text-center" style="vertical-align: middle;">Lei de Cotas</th>
                    <th colspan="3" class="text-center" style="vertical-align: middle;">Programa UFGInclui 2013 a 2015</th>
                </tr>
                <tr>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">AC</th>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">L1</th>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">L2</th>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">L3</th>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">L4</th>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">Indígenas</th>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">Quilombolas</th>
                    <th data-sortable="true" class="text-center" style="vertical-align: middle;">Surdos</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($arrayUnidades as $unidade => $value) : ?>
                <tr>
                    <td ><?php echo $unidade; ?></td>
                    <?php
                    echo "<td>";
                    // Consulta de Ampla Concorrencia
                    $sql = "SELECT AVG(`media_global`) AS count
                                FROM `$anoSelecionadoPOST`
                                WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                                        AND `acao_afirmativa` <> '(DC Renda Superior)'
                                        AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                                        AND `acao_afirmativa` <> '(PPI Renda Superior)'
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Negro Escola Pública' )
                                        AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Escola Pública' )
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Quilombola' )
                                        AND `acao_afirmativa` <> ( 'UFGInclui - Surdo' )
                                        AND `ano_ingresso` >= 2013
                                        AND `ano_ingresso` <= 2015
                                        AND `Regional` = '$unidade'";
                    echo consultaSimplesRetornaUmValor($sql);
                    echo "</td>";

                    // Loop para inserir os valores da Lei de Cotas
                    foreach ($arrayRendas as $renda => $value) {
                        echo "<td>";
                        $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013 AND `ano_ingresso` <= 2015";
                        echo consultaSimplesRetornaUmValor($sql);
                        echo "</td>";
                    }

                    // Loop para inserir os valores do programa UFGInclui.
                    // Nesse caso específico, escola pública e negros escola pública ficam de fora.
                    foreach ($arrayAcaoAfirmativa as $acao => $value) {
                        if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                            echo "<td>";
                            $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013 AND `ano_ingresso` <= 2015";
                            echo consultaSimplesRetornaUmValor($sql);
                            echo "</td>";
                        }
                    }
                    ?>
                </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <th class="text-center" style="vertical-align: middle;">Total</th>

                <!-- MEDIA AMPLA CONCORRENCIA -->
                <?php
                echo "<th>";
                $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013 AND `ano_ingresso` <= 2015 and Regional = ";
                echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                echo "</th>";

                // MEDIA das leis de cotas
                foreach ($arrayRendas as $renda => $value) {
                    echo "<th>";
                        $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013 and  `ano_ingresso` <= 2015 AND Regional = ";
                        echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                        echo "</th>";
                }

                // MEDIA do UFGInclui
                // Novamente, escola pública e negro escola pública ficam de fora, como especificado pelo documento modelo.
                foreach ($arrayAcaoAfirmativa as $acao => $value) {
                    if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                        echo "<th>";
                        $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013 and `ano_ingresso` <= 2015 and Regional = ";
                        echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                        echo "</th>";
                    }
                }
                ?>
              </tfoot>
            </table>
            <h6> <small>AC = Ampla Concorrência, L1 = Baixa Renda, L2 = Baixa Renda PPI, L3 = Independete da Renda, L4 = Independente da Renda PPI</small></h6>
          </div>
        </div>
      </div>
    </div>
    <script>
      <?php  // Gerar opcoes do gráfico
      $arrayCategories  = array ("AC", "L1", "L2", "L3", "L4", "Indígena", "Quilombola", "Surdos");    // Categorias do gráfico

      $tipo       = 'column';               // Tipo do gráfico
      $titulo     = '';                     // Título Gráfico
      $subtitulo  = '';                     // Subtítulo do Gráfico
      $legendaY   = 'Média Global'; // Legenda eixo Y

      $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
      ?>

      $(function () {
      var myChart = Highcharts.chart('media-medias-globais-entre-2013-e-2015', {
        <?php echo $opcoes; ?>
        series: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $aux = "";
            // AMPLA CONCORRENCIA
            $sql = "SELECT AVG(`media_global`) AS count
                    FROM `$anoSelecionadoPOST`
                    WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                            AND `acao_afirmativa` <> '(DC Renda Superior)'
                            AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                            AND `acao_afirmativa` <> '(PPI Renda Superior)'
                            AND `acao_afirmativa` <> ( 'UFGInclui - Negro Escola Pública' )
                            AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                            AND `acao_afirmativa` <> ( 'UFGInclui - Escola Pública' )
                            AND `acao_afirmativa` <> ( 'UFGInclui - Quilombola' )
                            AND `acao_afirmativa` <> ( 'UFGInclui - Surdo' )
                            AND `ano_ingresso` >= 2013
                            AND `ano_ingresso` <= 2015
                            AND `Regional` = '$unidade'";

            $aux .= consultaSimplesRetornaUmValor2($sql).",";

            // Loop para inserir os valores da Lei de Cotas
            foreach ($arrayRendas as $renda => $value) {
                $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013 AND `ano_ingresso` <= 2015";
                $aux.=  consultaSimplesRetornaUmValor2($sql).",";
            }

            // Loop para inserir os valores do programa UFGInclui.
            // Nesse caso específico, escola pública e negros escola pública ficam de fora.
            foreach ($arrayAcaoAfirmativa as $acao => $value) {
                if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                    $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013 AND `ano_ingresso` <= 2015";
                    $aux.=  consultaSimplesRetornaUmValor2($sql).",";
                }
            }

            echo "{name: '$unidade', data:[$aux]},";
          }
          ?>
        ]
      });
      });
    </script>

    <hr>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            Média Das Médias Globais Por ação Afirmativa E Por Regional De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?>
          </div>
          <div class="panel-body">
            <div id="media-medias-globais"></div>
            <h6><small>AC = Ampla Cocorrência, L1 = Baixa Renda, L2 = Baixa Renda PPI, L3 = Independente da Renda, L4 = Independente da Renda PPI, UFGInclui = Indígenas, Quilombolas e Surdos</small></h6>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            Média Das Médias Globais Por ação Afirmativa E Por Regional De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?>
          </div>
          <div class="panel-body">
            <table class="table"
            data-toggle="table"
            data-show-export="true">
              <thead>
                <th data-sortable="true" class="text-center">Regional</th>
                <th data-sortable="true" class="text-center">AC</th>
                <th data-sortable="true" class="text-center">L1</th>
                <th data-sortable="true" class="text-center">L2</th>
                <th data-sortable="true" class="text-center">L3</th>
                <th data-sortable="true" class="text-center">L4</th>
                <th data-sortable="true" class="text-center">UFGInclui</th>
              </thead>
              <tbody>
                <?php foreach ($arrayUnidades as $unidade => $value): ?>
                <tr>
                    <td class="text-center"><?php echo $unidade;?></td>
                    <td>
                     <!-- AMPLA CONCORRENCIA -->
                        <?php
                        $sql = "SELECT AVG(`media_global`) AS count
                                FROM `$anoSelecionadoPOST`
                                WHERE `acao_afirmativa` NOT LIKE '%UFGInclui%'
                                       and `acao_afirmativa` NOT LIKE '%Renda%'
                                       and `ano_ingresso` <> '$anoSelecionadoPOST'
                                       and `Regional` = '$unidade'";

                        echo consultaSimplesRetornaUmValor($sql);
                        ?>
                    </td>
                        <!-- L1 L2 L3 L4 -->
                        <?php foreach ($arrayRendas as $renda => $value) {
                        echo "\n<td>";
                        $sql = "SELECT AVG(`media_global`) AS count
                            FROM `$anoSelecionadoPOST`
                            WHERE `acao_afirmativa` = '$renda'
                                   and `ano_ingresso` <> '$anoSelecionadoPOST'
                                   and `Regional` = '$unidade'";

                        echo consultaSimplesRetornaUmValor($sql);
                        echo "</td>";
                        }?>
                    <!-- INDIGENA, QUILOMBO, SURDO -->
                    <?php
                    $sql = "SELECT AVG(`media_global`) AS count
                        FROM `$anoSelecionadoPOST`
                        WHERE `acao_afirmativa` LIKE '%UFGInclui%'
                               and `ano_ingresso` <> '$anoSelecionadoPOST'
                               and `Regional` = '$unidade'";
                    echo "\n<td>";
                    echo consultaSimplesRetornaUmValor($sql);
                    echo "</td>";
                    ?>
                </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <th class="text-center">Total</th>

                <!-- AMPLA CONCORRENCIA -->
                <td>
                    <?php
                    $sql = "SELECT AVG(`media_global`) AS count
                            FROM `$anoSelecionadoPOST`
                            WHERE `acao_afirmativa` NOT LIKE '%UFGInclui%'
                                   and `acao_afirmativa` NOT LIKE '%Renda%'
                                   and `ano_ingresso` <> '$anoSelecionadoPOST'
                                   and `Regional` = ";

                    echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                    ?>
                </td>
                <!-- L1 L2 L3 L4 -->
                <?php foreach ($arrayRendas as $renda => $value) {
                    $sql = "SELECT AVG(`media_global`) AS count
                            FROM `$anoSelecionadoPOST`
                            WHERE `acao_afirmativa` = '$renda'
                                   and `ano_ingresso` <> '$anoSelecionadoPOST'
                                   and `Regional` = ";

                echo "\n<td>";
                echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                echo "</td>";
                }?>

                <!-- INDIGENA, QUILOMBO, SURDO -->
                <?php
                $sql = "SELECT AVG(`media_global`) AS count
                        FROM `$anoSelecionadoPOST`
                        WHERE `acao_afirmativa` LIKE '%UFGInclui%'
                               and `ano_ingresso` <> '$anoSelecionadoPOST'
                               and `Regional` = ";

                echo "<td>";
                echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                echo "</td>";
                ?>
              </tfoot>
            </table>
            <h6><small>AC = Ampla Cocorrência, L1 = Baixa Renda, L2 = Baixa Renda PPI, L3 = Independente da Renda, L4 = Independente da Renda PPI, UFGInclui = Indígenas, Quilombolas e Surdos</small></h6>
          </div>
        </div>
      </div>
    </div>
    <script>
      <?php  // Gerar opcoes do gráfico
      $arrayCategories  = array ("AC", "L1", "L2", "L3", "L4", "UFGInclui");

      $tipo       = 'column';               // Tipo do gráfico
      $titulo     = '';                     // Título Gráfico
      $subtitulo  = '';                     // Subtítulo do Gráfico
      $legendaY   = 'Média Global'; // Legenda eixo Y

      $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
      ?>

      $(function () {
      var myChart = Highcharts.chart('media-medias-globais', {
        <?php echo $opcoes; ?>
        series: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $aux = "";

            // Ampla concorrencia (AC)
            $sql = "SELECT AVG(`media_global`) AS count
                    FROM `$anoSelecionadoPOST`
                    WHERE `acao_afirmativa` NOT LIKE '%UFGInclui%'
                           and `acao_afirmativa` NOT LIKE '%Renda%'
                           and `ano_ingresso` <> '$anoSelecionadoPOST'
                           and `Regional` = '$unidade'";

            $aux .= consultaSimplesRetornaUmValor2($sql).",";

            // Ações afirmativas
            foreach ($arrayRendas as $renda => $value) {
            $sql = "SELECT AVG(`media_global`) AS count
                FROM `$anoSelecionadoPOST`
                WHERE `acao_afirmativa` = '$renda'
                       and `ano_ingresso` <> '$anoSelecionadoPOST'
                       and `Regional` = '$unidade'";

            $aux .= consultaSimplesRetornaUmValor2($sql).",";
            }

            $sql = "SELECT AVG(`media_global`) AS count
                FROM `$anoSelecionadoPOST`
                WHERE `acao_afirmativa` LIKE '%UFGInclui%'
                       and `ano_ingresso` <> '$anoSelecionadoPOST'
                       and `Regional` = '$unidade'";

            $aux .= consultaSimplesRetornaUmValor2($sql).",";


            echo "{name: '$unidade', data:[$aux]},";
          }
          ?>
        ]
      });
      });
    </script>

  </div>
</div>
<?php require_once('includes/footer.php'); ?>
