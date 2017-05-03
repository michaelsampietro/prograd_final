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
$arrayAcaoAfirmativa = array(
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

// Pegando array de anos
$sql = "SELECT distinct ano_ingresso FROM `$anoSelecionadoPOST` where ano_ingresso >= 2011 order by ano_ingresso asc";
$arrayAnos = consultaSimplesRetornaArray($sql);

?>

<h1>Aprendendo a mexer</h1>

<!-- Número de Estudantes matriculados -->
<!-- Gráfico de BARRAS -->
<div class="row">
  <div class="col-md-6 col-xs-12">
    <div id="numero-de-estudantes-matriculados" style="width:100%; height:400px;"></div>
  </div>
  <div class="col-md-6 col-xs-12">
    <h2>Teste!</h2>
  </div>
</div>
<script>
  $(function () {
  var myChart = Highcharts.chart('numero-de-estudantes-matriculados', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Numero de Estudantes Matriculados em <?php echo $anoSelecionadoPOST ?>'
    },
    xAxis: {
        title: 'Regionais',
        categories: [<?php foreach ($arrayUnidades as $unidade => $value) {
                echo "'$unidade',";
            } ?>]
    },
    yAxis: {
        title: {
            text: 'Número de Estudantes'
        }
    },
    exporting: {
        buttons: {
            contextButton: {
                enabled: true
            }
        }
    },
    tooltip: {
      shared: true
    },
    plotOptions: {
      column: {
          dataLabels: {
              enabled: true,
              crop: false,
              overflow: 'none'
          }
      }
    },
    series: [{
      name: "Regionais",
      data: [
        <?php foreach ($arrayUnidades as $unidade => $value) {
          $sql = "SELECT COUNT(*) AS count FROM `2016` WHERE `municipio` = '$unidade'";
          $aux = consultaSimplesRetornaUmValor2($sql);
          echo "$aux,";
        } ?>
      ]}
    ]
  });
});
</script>

<!-- ./Número de Estudantes matriculados -->

<!-- Número de estudantes por grau academico -->
<!-- Gráfico de BARRAS -->
<div class="row">
  <div class="col-md-6 col-xs-12">
    <div id="numero-de-estudantes-por-grau-academico" style="width:100%; height:400px;"></div>
  </div>
  <div class="col-md-6 col-xs-12">
    <h2>Teste!</h2>
  </div>
</div>
<script>
        $(function () {
            var myChart = Highcharts.chart('numero-de-estudantes-por-grau-academico', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Numero de Estudantes Matriculados em <?php echo $anoSelecionadoPOST?>'
                },
                subtitle: {
                    text: 'Por Grau Acadêmico e Regional'
                },
                xAxis: {
                    title: 'Grau Acadêmico',
                    categories: [<?php foreach ($arrayGrauAcademico as $grau => $value) {
                            echo "'$grau',";
                        } ?>]
                },
                yAxis: {
                    title: {
                        text: 'Número de Estudantes'
                    }
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true,
                            crop: false,
                            overflow: 'none'
                        }
                    }
                },
                tooltip: {
                  shared: true
                },
                series: [
                        <?php
                        foreach ($arrayUnidades as $unidade => $value) {
                            $aux = "";
                            foreach ($arrayGrauAcademico as $grau => $value) {
                                $sql = "SELECT COUNT(*) AS count FROM `2016` WHERE `grau_academico` = '$grau' and `municipio` = '$unidade'";
                                $aux .= consultaSimplesRetornaUmValor2($sql).",";
                            }
                            echo "{name: '$unidade', data:[$aux]},";
                        } ?>
                ]
            });
        });
</script>
<!--./Número de estudantes por grau academico -->

<!-- Número de Cursos por Regional -->
<!-- Gráfico de LINHAS -->
<div class="row">
  <div class="col-md-6 col-xs-12">
    <div id="numero-de-cursos-por-regional" style="width:100%; height:400px;"></div>
  </div>
  <div class="col-md-6 col-xs-12">
    <h1>Teste!</h1>
  </div>
</div>
<script>
  $(function () {
    var myChart = Highcharts.chart('numero-de-cursos-por-regional', {
      chart: {
        type: 'line'
      },
      title: {
        text: 'Numero de Cursos por Regional'
      },
      subtitle: {
        text: 'De 2005 a <?php echo $anoSelecionadoPOST ?>'
      },
      xAxis: {
        categories: [<?php for ($i=2005; $i <= $anoSelecionadoPOST; $i++)
            echo "'$i',";
          ?>]
      },
      yAxis: {
        title: {
          text: 'Número de Cursos'
        }
      },
      plotOptions: {
        line: {
          dataLabels: {
            enabled: true
          }
        }
      },
      tooltip: {
        shared: true
      },
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

<!-- Número de Vagas por Regional -->
<!-- Gráfico de LINHAS -->
<div class="panel panel-default">
  <div class="panel-heading"><h4>Número de Vagas por Regional</h4></div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6 col-xs-12">
        <div id="numero-de-vagas-por-regional" style="width:100%; height:400px;"></div>
      </div>
      <div class="col-md-6 col-xs-12">
        <h1>Teste</h1>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {
    var myChart = Highcharts.chart('numero-de-vagas-por-regional', {
      chart: {
        type: 'line'
      },
      title: {
        text: 'Numero de Vagas por Regional'
      },
      subtitle: {
        text: 'De 2005 a <?php echo $anoSelecionadoPOST ?>'
      },
      xAxis: {
        categories: [<?php for ($i=2005; $i <= $anoSelecionadoPOST; $i++)
            echo "'$i',";
          ?>]
      },
      yAxis: {
        title: {
          text: 'Número de Cursos'
        }
      },
      plotOptions: {
        line: {
          dataLabels: {
            enabled: true
          }
        }
      },
      exporting: {
        enabled: true
      },
      tooltip: {
        shared: true
      },
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


<!-- Número de Estudantes por Ano de Ingresso -->
<!-- Gráfico de BARRAS -->
<div class="panel panel-default">
  <div class="panel-heading"><h4>Número de Estudantes por Ano de Ingresso</h4></div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6 col-xs-12">
        <div id="numero-de-estudantes-por-ano-ingresso" style="width:100%; height:400px;"></div>
      </div>
      <div class="col-md-6 col-xs-12">
        <h1>Teste</h1>
      </div>
    </div>
  </div>
</div>
<script>
        $(function () {
            var myChart = Highcharts.chart('numero-de-estudantes-por-ano-ingresso', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Numero de Estudantes Matriculados em <?php echo $anoSelecionadoPOST?>'
                },
                subtitle: {
                    text: 'Por Ano de Ingresso'
                },
                xAxis: {
                    title: 'Grau Acadêmico',
                    categories: ["2004 a 2010", <?php
                            foreach ($arrayAnos as $key => $ano) {
                                echo "'" . $ano . "',";
                            }
                        ?>]
                },
                yAxis: {
                    title: {
                        text: 'Número de Estudantes'
                    }
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true,
                            crop: false,
                            overflow: 'none'
                        }
                    }
                },
                tooltip: {
                  shared: true
                },
                series: [
                        <?php
                        foreach ($arrayUnidades as $unidade => $value) {
                            $aux = "";
                            foreach ($arrayGrauAcademico as $grau => $value) {
                              $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = '$unidade'";
                                $aux .= consultaSimplesRetornaUmValor2($sql).",";
                            }
                            echo "{name: '$unidade', data:[$aux]},";
                        } ?>
                ]
            });
        });
</script>
<!-- ./Número de Estudantes por Ano de Ingresso -->

<!-- Número de Estudantes por Sexo e Regional -->
<!-- Gráfico de LINHAS -->
<div class="panel panel-default">
  <div class="panel-heading text-center"><h4>Porcentagem de Estudantes por Sexo e Regional</h4></div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6 col-xs-12">
        <div id="porcentagem-de-estudantes-por-sexo-regional" style="width:100%; height:400px;"></div>
      </div>
      <div class="col-md-6 col-xs-12">
        <h1>Teste</h1>
      </div>
    </div>
  </div>
</div>
<script>
        $(function () {
            var myChart = Highcharts.chart('porcentagem-de-estudantes-por-sexo-regional', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Numero de Estudantes Matriculados em <?php echo $anoSelecionadoPOST?>'
                },
                subtitle: {
                    text: 'Por Ano de Ingresso'
                },
                xAxis: {
                    title: 'Regionais',
                    categories: [
                      <?php
                      $aux = "";
                      foreach ($arrayUnidades as $unidade => $value) {
                            $aux .= "'$unidade',";
                      } echo $aux; ?>]
                },
                yAxis: {
                    title: {
                        text: 'Número de Estudantes'
                    }
                },
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
<!-- ./Número de Vagas por Regional -->


<?php require_once('includes/footer.php'); ?>
