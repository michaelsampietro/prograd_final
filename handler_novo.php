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
            <li><a href="./handler_novo.php?anos=<?php echo $anoSelecionadoPOST ?>">Contagem</a></li>
            <li><a href="./porcentagem.php?anos=<?php echo $anoSelecionadoPOST ?>">Porcentagem</a></li>
            <li><a href="./media.php?anos=<?php echo $anoSelecionadoPOST ?>">Médias</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="col-sm-9 col-lg-10">

  <!-- Número de Estudantes matriculados -->
  <!-- Gráfico de BARRA -->
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
          <table id="tabela-numero-de-estudantes-matriculados" class="table table"
            data-toggle="table"
            data-click-to-select="true">
            <thead>
              <th data-sortable="true" data-field="regional">Regional</th>
              <th data-sortable="true" data-field="numestudantes">Número de Estudantes</th>
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
            </tbody>
            <tfoot>
              <th>Total</th>
              <th><?php
              $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `municipio` =";
              consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
              ?></th>
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
        name: "Regional",
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
  <!-- Gráfico de BARRA -->
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
          <table id="tabela-numero-de-estudantes-por-grau-academico" class="table"
            data-toggle="table"

            data-locale="en-US"
            >
            <thead>
              <th data-sortable="true" data-field="regional">Regional</th>
              <?php foreach ($arrayGrauAcademico as $grau => $value): ?>
                <th data-sortable="true" data-field="<?php echo ucwords(strtolower($grau)) ?>"><?php echo ucwords(strtolower($grau)); ?></th>
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
            </tbody>
            <tfoot>
              <th>Total</th>
              <?php foreach ($arrayGrauAcademico as $grau => $value): ?>
                <th>
                  <?php $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `grau_academico` = '$grau'";
                  echo consultaSimplesRetornaUmValor($sql);?>
                </th>
              <?php endforeach; ?>
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
    <div class="col-md-6"> <!-- TABELA -->
      <div class="panel panel-info">
        <div class="panel-heading">Número de Cursos por Regional</div>
        <div class="panel-body">
          <table id="tabela-numero-cursos"
          class="table"
          data-toggle="table"> <!-- chamada para bootstrap-table funcionar -->
            <thead>
              <th data-sortable="true">Regional</th>
              <th data-sortable="true">2005</th>
              <th data-sortable="true">2006</th>
              <th data-sortable="true">2007</th>
              <th data-sortable="true">2008</th>
              <th data-sortable="true">2009</th>
              <th data-sortable="true">2010</th>
              <th data-sortable="true">2011</th>
              <th data-sortable="true">2012</th>
              <th data-sortable="true">2013</th>
              <th data-sortable="true">2014</th>
              <th data-sortable="true">2015</th>
            </thead>
            <tbody>
              <tr id="row-Goiânia"><td>Goiânia</td><td>58</td><td>63</td><td>66</td><td>66</td><td>81</td><td>85</td><td>86</td><td>86</td><td>89</td><td>90</td><td>90</td></tr>
              <tr id="row-Jataí"><td>Jataí</td><td>11</td><td>15</td><td>18</td><td>20</td><td>21</td><td>23</td><td>23</td><td>24</td><td>24</td><td>25</td><td>25</td></tr>
              <tr id="row-Catalão"><td>Catalão</td><td>9</td><td>14</td><td>16</td><td>19</td><td>24</td><td>25</td><td>25</td><td>25</td><td>25</td><td>26</td><td>26</td></tr>
              <tr id="row-Goiás"><td>Goiás</td><td>1</td><td>1</td><td>1</td><td>1</td><td>3</td><td>3</td><td>3</td><td>3</td><td>5</td><td>6</td><td>7</td></tr>
            </tbody>
            <tfoot>
              <tr id="row-Total"><th>Total</th><th>79</th><th>93</th><th>101</th><th>106</th><th>129</th><th>136</th><th>137</th><th>138</td><th>143</th><th>147</th><th>148</th></tr>
            </tfoot>
          </table>
          <!-- Script da tabela -->
          <script type="text/javascript">
            // loop por todos os anos que estão no banco de dados até que seja menor ou igual ao ano selecionado pelo usuario
            <?php for ($anoBase = 2016; $anoBase <= $anoSelecionadoPOST; $anoBase++): ?>
              // inserindo o th do ano
              $('#tabela-numero-cursos').find('thead th').last().after('<th data-sortable="true"><?php echo $anoBase;?></th>');
              // loop para todas as unidades
              <?php foreach ($arrayUnidades as $unidade => $value) : ?>
                <?php
                  // setando a variavel que vai fazer a query
                  $sql = "SELECT COUNT(distinct curso) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` = '$unidade'";
                ?>

                $('#row-<?php echo $unidade;?>').find('td').last().after('<td><?php echo consultaSimplesRetornaUmValor($sql);?></td>');

              <?php endforeach; ?>

                // inserindo o td da linha Total
                <?php $sql = "SELECT COUNT(distinct curso) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` ="; ?>

                $('#row-Total').find('th').last().after('<th><?php echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);?></th>');
              <?php endfor; ?>
          </script>
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
          <table id="tabela-numero-vagas"
          class="table"
          data-toggle="table">
            <thead>
              <th data-sortable="true">Regional</th>
              <th data-sortable="true">2005</th>
              <th data-sortable="true">2006</th>
              <th data-sortable="true">2007</th>
              <th data-sortable="true">2008</th>
              <th data-sortable="true">2009</th>
              <th data-sortable="true">2010</th>
              <th data-sortable="true">2011</th>
              <th data-sortable="true">2012</th>
              <th data-sortable="true">2013</th>
              <th data-sortable="true">2014</th>
              <th data-sortable="true">2015</th>
            </thead>
            <tbody>
              <tr class="row-Goiânia"><td>Goiânia</td><td>2318</td><td>2508</td><td>2548</td><td>2523</td><td>3786</td><td>4046</td><td>4065</td><td>4045</td><td>4135</td><td>4325</td><td>4265</td></tr>
              <tr class="row-Jataí"><td>Jataí</td><td>360</td><td>550</td><td>610</td><td>705</td><td>880</td><td>980</td><td>980</td><td>1020</td><td>1020</td><td>1050</td><td>1080</td></tr>
              <tr class="row-Catalão"><td>Catalão</td><td>300</td><td>500</td><td>590</td><td>710</td><td>950</td><td>970</td><td>980</td><td>980</td><td>990</td><td>1110</td><td>1110</td></tr>
              <tr class="row-Goiás"> <td>Goiás</td> <td>60</td> <td>60</td> <td>60</td> <td>160</td> <td>160</td> <td>160</td> <td>160</td><td>160</td><td>210</td><td>380</td><td>470</td></tr>
            </tbody>
            <tfoot>
              <tr class="row-Total"><th>Total</th><th>3038</th><th>3618</th><th>3808</th><th>3998</th><th>5776</th><th>6156</th><th>6185</th><th>6205</th><th>6355</th><th>6865</th><th>6925</th></tr>
            </tfoot>
          </table>
          <!-- Script para a tabela com o numero de vagas ofertadas por regional -->
          <script>
            <?php for ($anoBase = 2016; $anoBase <= $anoSelecionadoPOST; $anoBase++): ?>
              // inserindo o th do ano
              $('#tabela-numero-vagas').find('thead th').last().after('<th data-sortable="true"><?php echo $anoBase;?></th>');
              // para deixar mais dinamico, utilizar um loop para todas as unidades
              <?php foreach ($arrayUnidades as $unidade => $value) : ?>
                // definindo consulta
                <?php $sql = "SELECT COUNT(*) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` = '$unidade'"; ?>

                $('#tabela-numero-vagas .row-<?php echo $unidade;?>').find('td').last().after('<td><?php echo consultaSimplesRetornaUmValor($sql);?></td>');
              <?php endforeach; ?>

                  // query da linha total
              <?php $sql = "SELECT COUNT(*) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` ="; ?>

              // inserindo o valor da query total na td
              $('#tabela-numero-vagas .row-Total').find('th').last().after('<th><?php echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);?></td>');
          <?php endfor; ?>
          </script>
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
          <table id="tabela-numero-de-estudantes-por-ano-ingresso"
          class="table"
          data-toggle="table"
          data-locale="en-US">
            <thead>
              <th data-sortable="true">Regional</th>
              <th data-sortable="true">2004 a 2010</th>
              <!-- inserindo os anos na tabela -->
              <?php
                  // Para esse gráfico, o ano base é 2011.
                  $anoBase = 2011;
                  while ($anoBase <= $anoSelecionadoPOST) {
                      echo "<th data-sortable='true'>$anoBase</td>";
                      $anoBase++;
                  }
              ?>
            </thead>
            <tbody>
              <!-- inserindo os dados -->
              <?php foreach ($arrayUnidades as $unidade => $value) {
              echo "<tr>";
                  echo "<td>$unidade</td>";
                  // ano de 2004 a 2010
                  $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST`
                            WHERE `ano_ingresso` >= 2004
                            and `ano_ingresso` <= 2010
                            and `Regional` = '$unidade'";
                  echo "<td>";
                      echo consultaSimplesRetornaUmValor($sql);
                  echo "</td>";

                  $anoBase = 2011;
                  while($anoBase <= $anoSelecionadoPOST) {
                      $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST`
                                WHERE `ano_ingresso` = '$anoBase'
                                and `Regional` = '$unidade'";
                      echo "<td>";
                          echo consultaSimplesRetornaUmValor($sql);
                      echo "</td>";
                      $anoBase++;
                  }
              echo "</tr>";
            } ?>
            </tbody>
            <tfoot>
              <th>Total</th>
              <!-- 2004 a 2010 -->
              <th><?php $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` >= 2004 and `ano_ingresso` <= 2010"; echo consultaSimplesRetornaUmValor($sql); ?></th>
              <?php for ($ano=2011; $ano <= $anoSelecionadoPOST; $ano++):?>
                <th>
                  <?php $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` = $ano";
                  echo consultaSimplesRetornaUmValor($sql); ?>
                </th>
              <?php endfor; ?>
            </tfoot>
          </table>
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
              // ano de 2004 a 2010 (anos posteriores são calculados separadamente)
              $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = '$unidade'";
              $aux .= consultaSimplesRetornaUmValor2($sql).",";

              // inicio a partir de 2011
              for ($ano = 2011; $ano <= $anoSelecionadoPOST; $ano++) {
                $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso = $ano and Regional = '$unidade'";
                $aux .=                consultaSimplesRetornaUmValor2($sql).",";

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

  <!-- Estudantes com ingresso até 2012, anterior a lei de cotas -->
  <!-- Gráfico de BARRA -->
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
          <table id="tabela-anterior-lei-de-cotas"
          data-toggle="table"
          data-locale="en-US"
          class="table">
            <thead>
              <th>Ação Afirmativa</th>
              <th data-sortable="true">Número de Estudantes</th>
            </thead>
            <tbody>
              <tr>
                <td>Ampla Concorrência</td>
                <td>
                <?php
                  // query Ampla concorrencia
                  $sql = "SELECT count(`Estudante`) AS count FROM `$anoSelecionadoPOST`
                            WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública')
                            and `acao_afirmativa` <> 'UFGInclui - Indígena'
                            and `acao_afirmativa` <> ('UFGInclui - Escola Pública')
                            and `acao_afirmativa` <> ('UFGInclui - Quilombola')
                            and `acao_afirmativa` <> ('UFGInclui - Surdo')
                            and `ano_ingresso` <= 2012";
                  consultaSimplesRetornaUmValor($sql);
                ?>
                </td>
                <!-- ações -->
                <?php foreach ($arrayAcaoAfirmativa as $acao => $value) {
                    echo "<tr>";
                    echo "<td>$acao</td>";
                    $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST`
                    WHERE `acao_afirmativa` = '$acao'
                    and `ano_ingresso` <= 2012";
                        echo "<td>";
                        consultaSimplesRetornaUmValor($sql);
                        echo "</td>";
                    echo "</tr>";
                } ?>
              </tr>
              <tr>
            </tbody>
            <tfoot>
              <th>Total</th>
                <th><?php $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012"; echo consultaSimplesRetornaUmValor($sql); ?></th>
            </tfoot>
          </table>
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
          <?php $arrayCategories = array("Ampla Concorrência" => "AC", "DC Renda Inferior" => "L1", "PPI Renda Inferior" => "L2", "DC Renda Superior" => "L3", "PPI Renda Superior" => "L4"); ?>
          <h6><small>Dados computados após a segunda etapa da chamada pública.<br>
          <?php foreach ($arrayCategories as $descricao => $categorie): ?>
            <?php echo "$categorie = $descricao," ?>
          <?php endforeach; ?></small></h6>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          Estudantes Matriculados em <?php echo $anoSelecionadoPOST ?> Por Ação Afirmativa Por Regional Com Ingresso a Partir De 2013 (Lei De Cotas E Programa UFGInclui)
        </div>
        <div class="panel-body">
          <table id="tabela-lei-de-cotas-e-ufg-inclui"
          class="table"
          data-toggle="table"
          >
            <thead>
              <th>Ação Afirmativa</th>
              <th data-sortable="true">Número de Estudantes</th>
            </thead>
            <script>
            $(document).ready(function() {
              $('#tabela-lei-de-cotas-e-ufg-inclui').DataTable( {
                  dom: 'Bfrtip',
                  buttons: [
                      'print'
                  ]
              } );
            } );
          </script>
            <tbody>
              <tr>
                <td>Ampla Concorrência</td>
                <td>
                  <?php $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST`
                                  WHERE `acao_afirmativa` <> '(PPI Renda Superior)'
                                  and `acao_afirmativa` <> '(PPI Renda Inferior)'
                                  and `acao_afirmativa` <> '(DC Renda Superior)'
                                  and `acao_afirmativa` <> '(DC Renda Inferior)'
                                  and `acao_afirmativa` <> 'UFGInclui - Indígena'
                                  and `acao_afirmativa` <> 'UFGInclui - Quilombola'
                                  and `acao_afirmativa` <> 'UFGInclui - Surdo'
                                  and `ano_ingresso` >= 2013";
                  echo consultaSimplesRetornaUmValor($sql); ?>
                </td>
              </tr>
              <?php foreach ($arrayAcoesAfirmativas as $acao => $value): ?>
                <tr>
                  <td><?php echo $acao ?></td>
                  <td>
                      <?php $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST`
                                      WHERE `acao_afirmativa` = '$acao'
                                      and `ano_ingresso` >= 2013";
                      echo consultaSimplesRetornaUmValor($sql); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
                <th>Total</th>
                <?php $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST`
                                WHERE `acao_afirmativa` <> 'UFGInclui - Escola Pública'
                                and `acao_afirmativa` <> 'UFGInclui - Negro Escola Pública'
                                and `ano_ingresso` >= 2013"; ?>
                <th><?php echo (consultaSimplesRetornaUmValor2($sql)+1); ?></th>
            </tfoot>
          </table>
          <?php $arrayCategories = array("Ampla Concorrência" => "AC", "DC Renda Inferior" => "L1", "PPI Renda Inferior" => "L2", "DC Renda Superior" => "L3", "PPI Renda Superior" => "L4"); ?>
          <h6><small>Dados computados após a segunda etapa da chamada pública.<br>
          <?php foreach ($arrayCategories as $descricao => $categorie): ?>
            <?php echo "$categorie = $descricao," ?>
          <?php endforeach; ?></small></h6>
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
        $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST`
                        WHERE `acao_afirmativa` <> '(PPI Renda Superior)'
                        and `acao_afirmativa` <> '(PPI Renda Inferior)'
                        and `acao_afirmativa` <> '(DC Renda Superior)'
                        and `acao_afirmativa` <> '(DC Renda Inferior)'
                        and `acao_afirmativa` <> 'UFGInclui - Indígena'
                        and `acao_afirmativa` <> 'UFGInclui - Quilombola'
                        and `acao_afirmativa` <> 'UFGInclui - Surdo'
                        and `ano_ingresso` >= 2013";
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
          <?php $arrayCategories = array("Ampla Concorrência" => "AC", "DC Renda Inferior" => "L1", "PPI Renda Inferior" => "L2", "DC Renda Superior" => "L3", "PPI Renda Superior" => "L4"); ?>
          <h6><small>Dados computados após a segunda etapa da chamada pública.<br>
          <?php foreach ($arrayCategories as $descricao => $categorie): ?>
            <?php echo "$categorie = $descricao," ?>
          <?php endforeach; ?></small></h6>
        </div>
      </div>  <!-- ./panel -->
    </div>    <!-- ./col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          Ingressantes SISU em <?php echo $anoSelecionadoPOST ?> por Ação Afirmativa e Ampla Concorrêcia por Regional
        </div>
        <div class="panel-body">
          <table id="tabela-ingressantes-sisu-todos"
          class="table table-responsive"
          data-toggle="table">
            <thead>
              <th data-sortable="true">Regional</th>

              <?php foreach ($arrayCategories as $descricao => $categorie): ?>
                <th data-sortable="true"><?php echo $categorie ?></th>
              <?php endforeach; ?>
            </thead>
            <tbody>
              <?php foreach ($arrayUnidades as $unidade => $value): ?>
                <tr>
                  <td><?php echo $unidade ?></td>
                  <td>
                    <?php
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
                    echo consultaSimplesRetornaUmValor($sql);
                    ?>
                  </td>
                  <?php foreach ($arrayRendas as $renda => $value): ?>
                    <td><?php $sql = "SELECT Count(*) AS count FROM   `$anoSelecionadoPOST` WHERE  forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU' AND `ano_ingresso` = $anoSelecionadoPOST AND `acao_afirmativa` = '$renda' AND `Regional` = '$unidade'"; echo consultaSimplesRetornaUmValor($sql); ?></td>
                  <?php endforeach; ?>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <th>Total</th>
              <th><?php $sql = "SELECT Count(*) AS count
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
                             AND `forma_ingresso` = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'";
              echo consultaSimplesRetornaUmValor($sql); ?></th>
              <?php foreach ($arrayRendas as $renda => $value): ?>
                <th><?php $sql = "SELECT Count(*) AS count FROM   `$anoSelecionadoPOST` WHERE  forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU' AND `ano_ingresso` = $anoSelecionadoPOST AND `acao_afirmativa` = '$renda'"; echo consultaSimplesRetornaUmValor($sql); ?></th>
              <?php endforeach; ?>
            </tfoot>
          </table>
          <h6><small>Dados computados após a segunda etapa da chamada pública.<br>
          <?php foreach ($arrayCategories as $descricao => $categorie): ?>
            <?php echo "$categorie = $descricao," ?>
          <?php endforeach; ?></small></h6>
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
  </div>
</div>
<?php require_once('includes/footer.php'); ?>
