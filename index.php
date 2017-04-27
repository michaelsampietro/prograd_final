<?php ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('includes/header.php');
    require_once('utils.php');  ?>
<div class='container'>
    <div class="row">
        <div class="col-xs-12 col-md-5">
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <h3 class="h3-normal">Bem Vindo!</h3>
                    <p>Esta página permite o acesso aos dados estatísticos referentes aos alunos matriculados nos cursos de graduação da UFG. Os dados são baseados nos alunos matriculados por ano.</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-offset-1 col-md-5">
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <form action="tipos_graficos.php" method="get">
                        <div class='form-group'>
                            <label for='sel1'>
                                <h3 class="h3-normal">Escolha um ano abaixo:</h3>
                            </label>
                            <select class='form-control' id='sel1' name='ano'>
                                <!-- Função para gerar um dropdown com anos -->
                                <?php dropdownAnos(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ver relatórios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<h1>Aprendendo a mexer</h1>

<div id="myChart1HighCharts" style="width:700px; height:400px;"></div>
    
<div id="numero-de-estudantes-por-grau-academico" style="width:700px; height:400px;"></div>
    <script>
        $(function () { 
            var myChart = Highcharts.chart('numero-de-estudantes-por-grau-academico', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Fruit Consumption'
                },
                xAxis: {
                    title: 'Regionais',
                    categories: [<?php foreach ($arrayGrauAcademico as $grau => $value) {
                            echo "'$grau',";
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

    <script>
        $(function () { 
            var myChart = Highcharts.chart('myChart1HighCharts', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Numero de Estudantes'
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
                series: [
                    {data: [
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

<?php require_once('includes/footer.php'); ?>
