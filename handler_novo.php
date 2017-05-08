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

  <!-- Número de Estudantes matriculados -->
  <!-- Gráfico de BARRAS -->
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel panel-heading">Número de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?></div>
        <div class="panel-body">
          <div id="numero-de-estudantes-matriculados" style="width:100%; height:400px;"></div>
        </div>
      </div>    <!--./panel -->
    </div>      <!--./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel panel-heading">Número de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?></div>
        <div class="panel-body">
          <table id="tabela-numero-de-estudantes-matriculados" class="table table-responsive table-striped"
            data-toggle="table"
            data-show-export="true"
            data-click-to-select="true">
            <thead>
              <th data-field="regional">Regional</th>
              <th data-field="numestudantes">Número de Estudantes</th>
            </thead>
            <tbody>
              <?php foreach ($arrayUnidades as $unidade => $value) : ?>
              <tr>
                  <td><?php echo ucwords($unidade); ?></td>
                  <td><?php
                  $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `municipio` = '$unidade'";
                  consultaSimplesRetornaUmValor($sql);
                  ?>
                  </td>
              </tr>
              <?php endforeach; ?>
              <tr>
                  <td>Total</td>
                  <td><?php
                  $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `municipio` =";
                  consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
                  ?></td>
              </tr>
            </tbody>
            </table>
        </div>
      </div>    <!--./panel -->
    </div>      <!--./col-md-6 -->
  </div>        <!--./row -->
  <script>
    var $table = $('#tabela-numero-de-estudantes-matriculados');

    <?php  // Gerar opcoes do gráfico
    $arrayCategories  = array();    // Categorias do gráfico
    // Inserindo valores no array de categorias
    foreach ($arrayUnidades as $unidade => $value) {
      $arrayCategories[] = $unidade;
    }

    $tipo       = 'column';                         // Tipo do gráfico
    $titulo     = 'Número de Estudantes Matriculados em'.$anoSelecionadoPOST;  // Título Gráfico
    $subtitulo  = '';                               // Subtítulo do Gráfico
    $legendaY   = 'Número de Estudantes';           // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>

    $(function () {
    var myChart = Highcharts.chart('numero-de-estudantes-matriculados', {
      <?php echo $opcoes; ?>
      series: [{
        name: "Regionais",
        data: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `municipio` = '$unidade'";
            $aux = consultaSimplesRetornaUmValor2($sql);
            echo "$aux,";
          } ?>
        ]}
      ]
    });
  });
  </script>
  <!-- ./Número de Estudantes matriculados -->

  <hr>

  <!-- Número de estudantes por grau academico -->
  <!-- Gráfico de BARRAS -->
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Número de Estudantes por Grau Acadêmico e Regional</div>
        <div class="panel-body">
          <div id="numero-de-estudantes-por-grau-academico" style="width:100%; height:400px;"></div>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Número de Estudantes por Grau Acadêmico e Regional</div>
        <div class="panel-body">
          <table id="tabela-numero-de-estudantes-por-grau-academico" class="table table-striped"
            data-toggle="table"
            data-search="true"
            data-show-export="true"
            data-locale="en-US"
            >
            <thead>
              <th data-field="regional">Regional</th>
              <?php foreach ($arrayGrauAcademico as $grau => $value): ?>
                <th data-field="<?php echo ucwords(strtolower($grau)) ?>"><?php echo ucwords(strtolower($grau)); ?></th>
              <?php endforeach; ?>
            </thead>
            <tbody>
              <?php foreach ($arrayUnidades as $unidade => $value): ?>
                <tr>
                  <td>
                    <?php echo $unidade ?>
                  </td>
                  <?php foreach ($arrayGrauAcademico as $grau => $value): ?>

                  <td><?php $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `grau_academico` = '$grau' and `Regional` = '$unidade'";
                  echo consultaSimplesRetornaUmValor($sql);?>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
              <!-- ROW TOTAL -->
              <tr>
                <td>Total</td>
                <?php foreach ($arrayGrauAcademico as $grau => $value): ?>
                  <td>
                    <?php $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `grau_academico` = '$grau'";
                    echo consultaSimplesRetornaUmValor($sql);?>
                  </td>
                <?php endforeach; ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
  </div>      <!-- ./row -->
  <script>
    <?php  // Gerar opcoes do gráfico
    $arrayCategories  = array();    // Categorias do gráfico
    // Inserindo valores no array de categorias
    foreach ($arrayGrauAcademico as $grau => $value) {
      $arrayCategories[] = $grau;
    }

    $tipo       = 'column';                                                    // Tipo do gráfico
    $titulo     = 'Número de Estudantes Matriculados em'.$anoSelecionadoPOST;  // Título Gráfico
    $subtitulo  = 'Por Grau Acadêmico e Regional';                             // Subtítulo do Gráfico
    $legendaY   = 'Número de Estudantes';                                      // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>
          $(function () {
              var myChart = Highcharts.chart('numero-de-estudantes-por-grau-academico', {
                  <?php echo $opcoes; ?>  // auto-generated / Imprimindo opções
                  series: [
                    <?php
                    foreach ($arrayUnidades as $unidade => $value) {
                        $aux = "";
                        foreach ($arrayGrauAcademico as $grau => $value) {
                            $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `grau_academico` = '$grau' and `municipio` = '$unidade'";
                            $aux .= consultaSimplesRetornaUmValor2($sql).",";
                        }
                        echo "{name: '$unidade', data:[$aux]},";
                    } ?>
                  ]
              });
          });
  </script>
  <!--./Número de estudantes por grau academico -->

  <hr>

  <!-- Número de Cursos por Regional -->
  <!-- Gráfico de LINHAS -->
  <div class="row">
    <div class="col-md-6">
    <div class="panel panel-info">
        <div class="panel-heading">Número de Cursos por Regional</div>
        <div class="panel-body">
            <div id="numero-de-cursos-por-regional"></div>
        </div>
      </div>  <!-- ./panel-->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Testando</div>
        <div class="panel-body">
          <h1>Tabela</h1>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
  </div>      <!-- ./row -->
  <script>
    <?php  // Gerar opcoes do gráfico
    $arrayCategories  = array();    // Categorias do gráfico
    // Inserindo valores no array de categorias
    for ($aux = 2005; $aux <= $anoSelecionadoPOST; $aux++) {
      $arrayCategories[] = $aux;  // Semelhante a array_push
    }

    $tipo       = 'line';                // Tipo do gráfico
    $titulo     = 'Número de Cursos por Regional';  // Título Gráfico
    $subtitulo  = 'De 2005 a'.$anoSelecionadoPOST;  // Subtítulo do Gráfico
    $legendaY   = 'Número de Cursos';           // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>
    $(function () {
      var myChart = Highcharts.chart('numero-de-cursos-por-regional', {
        <?php echo $opcoes; ?>
        series: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $aux = '';
            if ($unidade == 'Goiânia') {
              $aux = "58, 63, 66, 66, 81, 85, 86, 86, 89, 90, 90,";
            } elseif ($unidade == 'Jataí') {
                $aux = "11, 15, 18, 20, 21, 23, 23, 24, 24, 25, 25,";
            } elseif ($unidade == 'Catalão') {
                $aux = "9, 14, 16, 19, 24, 25, 25, 25, 25, 26, 26,";
            } elseif ($unidade == 'Goiás') {
                $aux = "1, 1, 1, 1, 3, 3, 3, 3, 5, 6, 7,";
            }
            $anoBase = 2016;
              while($anoBase <= $anoSelecionadoPOST) {
                $sql = "SELECT COUNT(distinct curso) AS count FROM `$anoBase` WHERE `ano_ingresso`= '$anoBase' and `Regional` = '$unidade'";
                $aux .= consultaSimplesRetornaString2($sql);
                $anoBase++;
              }
              echo "{name: '$unidade', data:[$aux]},";
            } ?>
        ]
      })
    });
  </script>
  <!-- ./Número de Cursos por Regional -->

  <hr>

  <!-- Número de Vagas por Regional -->
  <!-- Gráfico de LINHAS -->
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Número de Vagas por Regional</div>
        <div class="panel-body">
          <div id="numero-de-vagas-por-regional" style="width:100%; height:400px;"></div>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Número de Vagas por Regional</div>
        <div class="panel-body">
          <h1>Tabela</h1>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
  </div>      <!-- ./row -->
  <script>
    <?php  // Gerar opcoes do gráfico
    $arrayCategories  = array();    // Categorias do gráfico
    // Inserindo valores no array de categorias
    for ($aux = 2005; $aux <= $anoSelecionadoPOST; $aux++) {
      $arrayCategories[] = $aux;  // Semelhante a array_push
    }
    $tipo       = 'line';                          // Tipo do gráfico
    $titulo     = 'Vagas por Regional';  // Título Gráfico
    $subtitulo  = 'De 2005 a'.$anoSelecionadoPOST; // Subtítulo do Gráfico
    $legendaY   = 'Número de Vagas';               // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>
    $(function () {
      var myChart = Highcharts.chart('numero-de-vagas-por-regional', {
        // auto-generated code
        <?php echo $opcoes; ?>
        // Inserindo os valores do gráfico
        series: [
          <?php foreach ($arrayUnidades as $unidade => $value) {
            $aux = '';
            if ($unidade == 'Goiânia') {
                $aux = "2318, 2508, 2548, 2523, 3786, 4046, 4065, 4045, 4135, 4325, 4265, ";
            } elseif ($unidade == 'Jataí') {
                $aux = "360, 550, 610, 705, 880, 980, 980, 1020, 1020, 1050, 1080, ";
            } elseif ($unidade == 'Catalão') {
                $aux = "300, 500, 590, 710, 950, 970, 980, 980, 990, 1110, 1110, ";
            } elseif ($unidade == 'Goiás') {
                $aux = "60, 60, 60, 60, 160, 160, 160, 160, 210, 380, 470, ";
            }
            $anoBase = 2016;
              while($anoBase <= $anoSelecionadoPOST) {
                $sql = "SELECT COUNT(Estudante) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional`= '$unidade'";
                $aux .= consultaSimplesRetornaString2($sql);
                $anoBase++;
              }
              echo "{name: '$unidade', data:[$aux]},";
            } ?>
        ]
      })
    });
  </script>
  <!-- ./Número de Vagas por Regional -->

  <hr>

  <!-- Número de Estudantes por Ano de Ingresso -->
  <!-- Gráfico de BARRAS -->
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Número de Estudantes por Ano de Ingresso</div>
        <div class="panel-body">
          <div id="numero-de-estudantes-por-ano-ingresso" style="width:100%; height:400px;"></div>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Número de Estudantes por Ano de Ingresso</div>
        <div class="panel-body">
          <h1>Tabela</h1>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
  </div>      <!-- ./row -->
  <script>
    <?php  // Gerar opcoes do gráfico
    $arrayCategories  = array("2004 a 2010");    // Categorias do gráfico
    // Inserindo valores no array de categorias
    foreach ($arrayAnos as $ano) {
      $arrayCategories[] = $ano; // semelhante a array_push
    }

    $tipo       = 'column';                // Tipo do gráfico
    $titulo     = 'Número de Estudantes';  // Título Gráfico
    $subtitulo  = 'Por Ano de Ingresso';   // Subtítulo do Gráfico
    $legendaY   = 'Número de Estudantes';       // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>
    $(function () {
        var myChart = Highcharts.chart('numero-de-estudantes-por-ano-ingresso', {
          // auto-generated code
          <?php echo $opcoes; ?>
          series: [
            <?php
            foreach ($arrayUnidades as $unidade => $value) {
              $aux = "";
              foreach ($arrayGrauAcademico as $grau => $value) {
                $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = '$unidade'";
                $aux .= consultaSimplesRetornaUmValor2($sql).",";
              }
              echo "{name: '$unidade', data:[$aux]},";
            }
            ?>
          ]
        });
    });
  </script>
  <!-- ./Número de Estudantes por Ano de Ingresso -->

  <hr>

  <!-- Número de Estudantes por Sexo e Regional -->
  <!-- Gráfico de COLUNAS -->
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
            <h1>Tabela</h1>
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
  <!-- ./Número de Estudantes por Sexo e Regional -->

  <hr>

  <!-- Estudantes com ingresso até 2012, anterior a lei de cotas -->
  <!-- Gráfico de COLUNAS -->
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa na UFG com Ingresso até 2012 (Anterior a Lei de Cotas)
        </div>
        <div class="panel-body">
          <div id="anterior-lei-de-cotas"></div>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa na UFG com Ingresso até 2012 (Anterior a Lei de Cotas)</div>
        <div class="panel-body">
          <h1>Tabela</h1>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
  </div>      <!-- ./row -->
  <script>
    <?php  // Gerar opcoes do gráfico
    $arrayCategories  = array("AC", "Escola Pública", "Negro Escola Pública", "Indígena", "Negro Quilombola", "Surdos");    // Categorias do gráfico

    $tipo       = 'column';                // Tipo do gráfico
    $titulo     = '';  // Título Gráfico
    $subtitulo  = '';   // Subtítulo do Gráfico
    $legendaY   = 'Número de Estudantes';       // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>
    $(function () {
        var myChart = Highcharts.chart('anterior-lei-de-cotas', {
          // auto-generated code
          <?php echo $opcoes; ?>

          series: [
            <?php
            // CONSULTA PARA AMPLA CONCORENCIA
            $aux = "";
            $sql = "SELECT count(`Estudante`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` <= 2012";
            $aux .= consultaSimplesRetornaString2($sql);

            // utilizando array categorias
            foreach ($arrayLeiDeCotas as $cota => $value) {
              $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$cota' and `ano_ingresso` <= 2012";
              $aux .= consultaSimplesRetornaString2($sql);
            }

            echo "{name: 'Ação Afirmativa', data:[$aux]}";

            ?>
          ]
        });
    });
  </script>
  <!-- ./Estudantes com ingresso até 2012, anterior a lei de cotas -->

  <!-- Estudantes após 2013, lei de cotas e UFGInclui -->
  <!-- Gráfico BARRA -->
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          Estudantes Matriculados em <?php echo $anoSelecionadoPOST ?> Por Ação Afirmativa Por Regional Com Ingresso a Partir De 2013 (Lei De Cotas E Programa UFGInclui)
        </div>
        <div class="panel-body">
          <div id="lei-de-cotas-e-ufg-inclui"></div>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          Estudantes Matriculados em <?php echo $anoSelecionadoPOST ?> Por Ação Afirmativa Por Regional Com Ingresso a Partir De 2013 (Lei De Cotas E Programa UFGInclui)
        </div>
        <div class="panel-body">
          <div>Tabela</div>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
  </div>      <!-- ./row -->
  <script>
    <?php  // Gerar opcoes do gráfico
    $arrayCategories = array("AC", "L1", "L2", "L3", "L4", "Indígenas", "Quilombola", "Surdo");

    $tipo       = 'column';                // Tipo do gráfico
    $titulo     = '';  // Título Gráfico
    $subtitulo  = '';   // Subtítulo do Gráfico
    $legendaY   = 'Número de Estudantes';       // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>

    var myChart = Highcharts.chart('lei-de-cotas-e-ufg-inclui', {
      <?php echo $opcoes; ?>
      series: [
        <?php
        $aux = "";
        // Ampla Concorrencia (AC)
        $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013";
        $aux .= consultaSimplesRetornaString2($sql);

        // Todos as outras acoes
        foreach ($arrayAcoesAfirmativas as $acao => $value) {
          $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013";
          $aux .= consultaSimplesRetornaString2($sql);
        }
        echo "{name: 'Ação Afirmativa', data:[$aux]}";
        ?>
      ]
    })
  </script>
  <!-- ./Estudantes após 2013, lei de cotas e UFGInclui -->

  <!-- Estudantes SISU 2016 -->
  <!-- Gráfico BARRA -->
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          Ingressantes SISU em <?php echo $anoSelecionadoPOST ?> por Ação Afirmativa e Ampla Concorrêcia por Regional
        </div>
        <div class="panel-body">
          <div id="ingressantes-sisu-todos"></div>
          <h6><small>Dados computados após a segunda etapa da chamada pública.</small></h6>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          Ingressantes SISU em <?php echo $anoSelecionadoPOST ?> por Ação Afirmativa e Ampla Concorrêcia por Regional
        </div>
        <div class="panel-body">
          <div>Tabela</div>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
  </div>      <!-- ./row -->
  <script>
    <?php  // Gerar opcoes do gráfico
    $arrayCategories = array("AC", "L1", "L2", "L3", "L4");

    $tipo       = 'column';                // Tipo do gráfico
    $titulo     = '';  // Título Gráfico
    $subtitulo  = '';   // Subtítulo do Gráfico
    $legendaY   = 'Número de Estudantes';       // Legenda eixo Y

    $opcoes = geraGrafico($arrayCategories, $tipo, $titulo, $subtitulo, $legendaY);
    ?>

    var myChart = Highcharts.chart('ingressantes-sisu-todos', {
      <?php echo $opcoes; ?>
      series: [
        <?php
        // Para cada unidade
        foreach ($arrayUnidades as $unidade => $value) {
          $aux = "";
          // Ampla concorrencia
          $sql = "SELECT Count(*) AS count
                  FROM   `$anoSelecionadoPOST`
                  WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                         AND `acao_afirmativa` <> '(DC Renda Superior)'
                         AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                         AND `acao_afirmativa` <> '(PPI Renda Superior)'
                         AND `acao_afirmativa` <> 'UFGInclui - Negro Escola Pública'
                         AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                         AND `acao_afirmativa` <> 'UFGInclui - Escola Pública'
                         AND `acao_afirmativa` <> 'UFGInclui - Quilombola'
                         AND `acao_afirmativa` <> 'UFGInclui - Surdo'
                         AND `ano_ingresso` = $anoSelecionadoPOST
                         AND `forma_ingresso` = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                         AND `Regional` = '$unidade'";
          $aux .= consultaSimplesRetornaString2($sql);

          // Todos as outras acoes
          foreach ($arrayRendas as $renda => $value) {
            $sql = "SELECT Count(*) AS count
                    FROM   `$anoSelecionadoPOST`
                    WHERE  forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                           AND `ano_ingresso` = $anoSelecionadoPOST
                           AND `acao_afirmativa` = '$renda'
                           AND `Regional` = '$unidade'";
            $aux .= consultaSimplesRetornaString2($sql);
          }
          echo "{name: '$unidade', data:[$aux]},";
        }

        ?>
      ]
    })
  </script>







<?php require_once('includes/footer.php'); ?>
