<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'utils.php';
require_once 'includes/header.php';

$anoSelecionadoPOST = htmlspecialchars($_GET['anos']);


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
?>

<script>
    $.LoadingOverlay("show", {
        color: "rgba(250,250,250,0.9)",
        fade: "fast"
    });
</script>

<div id="container-geral" class="container" style="margin: 0 auto;">
    <h4>Clique no nome do gráfico para mostrá-lo!</h4>

    <!-- Gráfico porcentagem de estudantes por faixa etaria matriculados -->
    <div class='row'>
        <h3 class="text-left">Porcentagem de estudantes por faixa etária matriculados em abril de <?php echo $anoSelecionadoPOST; ?>
        </h3>
        <canvas id="myChart9" style="width: 1100px; height: 500px; "></canvas>
        <!-- utilizarei esse array para armazenar os intervalos de idades para duas coisas:
        1-> imprimir na tabela
        2-> modificar para deixar a consulta ao banco dinâmica. (tirarei os caracteres A e trocarei por AND para utilizar em um BETWEEN) -->
        <?php $arrayIntervaloIdades = array ("< 18",  "18 a 20", "21 a 23", "24 a 26", "27 a 29", "30 a 35", "36 a 40", "41 a 45", "> 45"); ?>
        <!-- auto generated code -->
        <table class="table-responsive table-bordered table">
            <tr>
                <th></th>
                <?php
                for ($i=0; $i < sizeof($arrayIntervaloIdades); $i++)
                    echo "<th>$arrayIntervaloIdades[$i]</th>";
                ?>
            </tr>
            <?php
            //replacing a com and para usar no banco
            for ($i=0; $i < sizeof($arrayIntervaloIdades); $i++)
                $arrayIntervaloIdades[$i] = preg_replace("/a/", "and", $arrayIntervaloIdades[$i]);


            foreach ($arrayUnidades as $unidade => $value) {
                echo "<tr>";
                echo "<td>$unidade</td>";
                foreach ($arrayIntervaloIdades as $intervalo) {
                    echo "<td>";
                    if(preg_match('/and/i', $intervalo)) {
                        $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN $intervalo";
                        consultaSimplesRetornaUmValor($sql);
                    } else {
                        $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) $intervalo";
                        consultaSimplesRetornaUmValor($sql);
                    }
                    echo "%</td>";
                }
                echo "</tr>";
            }

            ?>
        </table>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("myChart9");

        var data = {
            // Intervalos de idades que devem ser calculadas. O intervalo foi definido de acordo com o documento PDF
            labels: ["< 18",  "de 18 a 20", "de 21 a 23", "de 24 a 26", "de 27 a 29", "de 30 a 35", "de 36 a 40", "de 41 a 45", "> 45"],
            datasets: [
                {
                    label: "Idade",
                    backgroundColor: 'rgba(54, 162, 235, .7)',
                    data: [
                    // Faz um loop com 9 iterações, onde cada iteração representa um intervalo (especificados nas labels acima) e, para cada iteração faz uma consulta em um intervalo de idade diferente
                    <?php
                        for ($i=0; $i < 9; $i++) {
                            switch ($i) {
                                case 0:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) < 18";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 1:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 18 AND 20";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 2:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 21 AND 23";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 3:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 24 AND 26";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 4:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 27 AND 29";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 5:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 30 AND 35";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 6:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 36 AND 40";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 7:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 41 AND 45";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 8:
                                   $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST`) AS count FROM `$anoSelecionadoPOST` WHERE FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) > 45";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                default:
                                    break;

                            }
                        }
                    ?>]
                }
            ]
        };

        var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
    </script>

    <!-- Gráfico com porcentagem de alunos matriculados nas regionais por faixa etária-->
    <?php
    $aux = 0;
    foreach ($arrayUnidades as $unidade => $value): ?>
        <div class='row'>
            <h3>Porcentagem de estudantes por faixa etária matriculados em abril de <?php echo $anoSelecionadoPOST; ?> na regional <?php echo $unidade; ?>
            </h3>
            <canvas id="chartAnosRegional<?php echo $unidade; ?>" style="width: 1100px; height: 500px; "></canvas>
            <table class="table-responsive table-bordered table">
            <tr>
                <th>Faixa Etária</th>
                <th>Porcentagem de Estudantes</th>
            </tr>
                <?php
                // reiniciando o array
                $arrayIntervaloIdades = array ("< 18",  "18 a 20", "21 a 23", "24 a 26", "27 a 29", "30 a 35", "36 a 40", "41 a 45", "> 45");

                foreach ($arrayIntervaloIdades as $intervalo) {
                    echo "<tr>";
                    echo "<td>$intervalo</td>";
                    //trocando a com and para usar no banco
                    $intervalo = preg_replace("/a/", "and", $intervalo);

                    echo "<td>";
                    if(preg_match('/and/i', $intervalo)) {
                        $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN $intervalo";
                        consultaSimplesRetornaUmValor($sql);
                    } else {
                        $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) $intervalo";
                        consultaSimplesRetornaUmValor($sql);
                    }
                    echo "%</td>";
                    echo "</tr>";
                }
                ?>
            </table>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("chartAnosRegional<?php echo $unidade; ?>");

        var data = {
            // Intervalos de idades que devem ser calculadas. O intervalo foi definido de acordo com o documento PDF
            labels: ["< 18",  "de 18 a 20", "de 21 a 23", "de 24 a 26", "de 27 a 29", "de 30 a 35", "de 36 a 40", "de 41 a 45", "> 45"],
            datasets: [
                {
                    label: "Idade",
                    backgroundColor: 'rgba(54, 162, 235, .7)',
                    data: [
                    // Faz um loop com 9 iterações, onde cada iteração representa um intervalo (especificados nas labels acima) e, para cada iteração faz uma consulta em um intervalo de idade diferente
                    <?php
                        for ($i=0; $i < 9; $i++) {
                            switch ($i) {
                                case 0:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) < 18 ";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 1:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 18 AND 20";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 2:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 21 AND 23";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 3:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 24 AND 26";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 4:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 27 AND 29";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 5:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 30 AND 35";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 6:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 36 AND 40";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 7:
                                    $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) BETWEEN 41 AND 45";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 8:
                                   $sql = "SELECT COUNT(*) * 100.0 / (SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` where Regional = '$unidade') AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' AND FLOOR(ABS(DATEDIFF(CURRENT_DATE, STR_TO_DATE(nascimento, '%m/%d/%y'))/365)) > 45";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                default:
                                    break;
                            }
                        }
                    ?>]
                }
            ]
        };

        var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
    </script>
    <?php $aux++; endforeach; ?>

    <!-- Gráfico com porcentagem da media global dos alunos GERAL-->
    <div class='row'>
            <h3 class="text-left">Gráfico com porcentagem da media global dos alunos por intervalo <?php echo $anoSelecionadoPOST; ?>
            </h3>
            <canvas id="chartPorcentagemMediaGlobalGeral" style="width: 1100px; height: 500px; "></canvas>
            <!-- auto-generated code -->
            <table class="table table-responsive table-bordered">
                <tr>
                    <th>Faixas das Médias</th>
                    <th>Porcentagem de Estudantes</th>
                </tr>
                    <?php
                    for ($index = 0; $index < 10; $index++) {

                        $aux = $index + 1;
                        $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `media_global` <> 0) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > $index and `media_global` <= $aux";

                        echo "<tr>";
                        echo "<td>$aux</td>";
                        echo "<td>";
                        consultaSimplesRetornaUmValor($sql);
                        echo "%</td></tr>";
                    }
                    ?>
            </table>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("chartPorcentagemMediaGlobalGeral");

        var data = {
            // Intervalos de medias que devem ser calculadas. O intervalo foi definido de acordo com o documento PDF
            labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
            datasets: [
                {
                    label: "Porcentagem de alunos",
                    backgroundColor: 'rgba(54, 162, 235, .7)',
                    data: [
                    // Faz um loop com 9 iterações, onde cada iteração representa um intervalo (especificados nas labels acima) e, para cada iteração faz uma consulta em um intervalo de idade diferente
                    <?php
                        for ($index = 0; $index < 10; $index++) {
                        $aux = $index + 1;
                        $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `media_global` <> 0) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > $index and `media_global` <= $aux";
                        consultaSimplesRetornaString($sql);
                    }
                    ?>]
                }
            ]
        };

        var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
    </script>

    <!-- Gráfico com porcentagem da media global dos alunos POR REGIONAL-->
    <?php
        foreach ($arrayUnidades as $unidade => $value): ?>
            <div class='row'>
                <h3 class="text-left">Gráfico com porcentagem da media global dos alunos por intervalo <?php echo $anoSelecionadoPOST; ?> na regional <?php echo $unidade; ?>
                </h3>
                <canvas id="chartPorcentagemMediaGlobalUnidade<?php echo $unidade; ?>" style="width: 1100px; height: 500px; "></canvas>
                <table class="table table-responsive table-bordered">
                <tr>
                    <th>Faixas das Médias</th>
                    <th>Porcentagem de Estudantes</th>
                </tr>
                    <?php
                    for ($index = 0; $index < 10; $index++) {

                        $aux = $index + 1;
                        $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and `media_global` <> 0) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and `media_global` > $index and `media_global` <= $aux";

                        echo "<tr>";
                        echo "<td>$aux</td>";
                        echo "<td>";
                        consultaSimplesRetornaUmValor($sql);
                        echo "%</td></tr>";
                    }
                    ?>
            </table>
        </div>
        <script type="text/javascript">
        var ctx = document.getElementById("chartPorcentagemMediaGlobalUnidade<?php echo $unidade; ?>");

        var data = {
            // Intervalos de idades que devem ser calculadas. O intervalo foi definido de acordo com o documento PDF
            labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
            datasets: [
                {
                    label: "Porcentagem de alunos",
                    backgroundColor: 'rgba(54, 162, 235, .7)',
                    data: [
                    // Faz um loop com 9 iterações, onde cada iteração representa um intervalo (especificados nas labels acima) e, para cada iteração faz uma consulta em um intervalo de idade diferente
                    <?php
                        for ($index =0; $index <= 10; $index++) {
                            $aux = $index + 1;
                            $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and `media_global` <> 0) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and `media_global` > $index and `media_global` <= $aux";
                            consultaSimplesRetornaString($sql);
                        }
                     ?>
            ]
        }] };

        var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

        </script>
    <?php endforeach; ?>

    <!-- Gráfico DA PORCENTAGEM (GRAFICO PIZZA) de estudantes c/ ação afirmativa , que ingressaram até 2012 -->
    <div class="row">
            <h3 class="text-left">Porcentagem De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Por Ação Afirmativa Na Ufg Com Ingresso Até 2012 (Anterior a Lei De Cotas)</h3>
            <canvas id="myChart11" style="width: 900px; height: 500px; "></canvas>
            <table class="table table-responsive table-bordered text-center">
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
                    consultaSimplesRetornaSomaAsString($arrayAcaoAfirmativa, $sql);
                ?>
                %</td>


            </tr>
            </table>
            <script>
                var ctx = document.getElementById("myChart11");

                var data = {
                    labels: [
                        "UFGInclui",
                        "AC"
                    ],
                    datasets: [
                        {
                            label: 'Porcentagem de estudantes',
                            backgroundColor: [
                                "#36A2EB",
                                "#FFCE56"
                            ],
                            data: [
                                <?php
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012 and `acao_afirmativa` =";
                                echo consultaSimplesRetornaSomaAsString($arrayAcaoAfirmativa, $sql);
                                echo " ,";
                                $sql = "SELECT count(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` <= 2012) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` <= 2012";
                                echo consultaSimplesRetornaString($sql);

                                ?>
                            ]
                        }
                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        barValueSpacing: 20,
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        min: 0,
                                        beginAtZero:true
                                    }
                                }
                            ]
                        }
                    }
                });
            </script>
    </div>

    <!-- Gráfico DA PORCENTAGEM (GRAFICO PIZZA) de estudantes via lei de cotas e UFG Inclui que ingressaram a partir de 2013 -->
    <div class="row">
            <h3 class="text-left">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa na UFG com Ingresso a Partir de 2013 (Lei de Cotas e Programa UFGInclui)</h3>
            <canvas id="myChart13" style="width: 900px; height: 500px; "></canvas>
            <table class="table-responsive table table-bordered">
                <tr>
                    <td>UFGInclui e Lei de Cotas</td>
                    <td><?php $sql = "SELECT Count(*) /
                                               (
                                                      SELECT Count(*)
                                                      FROM   `$anoSelecionadoPOST`
                                                      WHERE  `ano_ingresso` >= 2013) * 100.0 AS count
                                        FROM   `$anoSelecionadoPOST`
                                        WHERE  `ano_ingresso` >= 2013
                                        AND    `acao_afirmativa` =";
                        echo consultaSimplesRetornaSomaAsString($arrayRendas, $sql);?>
                    %</td>
                </tr>
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
                                               and `ano_ingresso` >= 2013 ";
                        echo consultaSimplesRetornaUmValor($sql); ?>
                    %</td>
                </tr>
            </table>
            <script>
                var ctx = document.getElementById("myChart13");

                var data = {
                    labels: [
                        "UFGInclui e Lei de Cotas",
                        "AC"
                    ],
                    datasets: [
                        {
                            label: 'Porcentagem de estudantes',
                            backgroundColor: [
                                "#36A2EB",
                                "#FFCE56"
                            ],
                            data: [
                                <?php
                                //acao afirmativa
                                $sql = "SELECT Count(*) /
                                               (
                                                      SELECT Count(*)
                                                      FROM   `$anoSelecionadoPOST`
                                                      WHERE  `ano_ingresso` >= 2013) * 100.0 AS count
                                        FROM   `$anoSelecionadoPOST`
                                        WHERE  `ano_ingresso` >= 2013
                                        AND    `acao_afirmativa` =";
                                echo consultaSimplesRetornaSomaAsString($arrayRendas, $sql);
                                echo " ,";
                                //AC
                                $sql = "SELECT count(*) / (SELECT COUNT(*)
                                                           FROM   `$anoSelecionadoPOST`
                                                           WHERE  `ano_ingresso` >= 2013) * 100.0 AS count
                                        FROM   `$anoSelecionadoPOST`
                                        WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                                               and `acao_afirmativa` <> '(DC Renda Superior)'
                                               and `acao_afirmativa` <> '(PPI Renda Inferior)'
                                               and `acao_afirmativa` <> '(PPI Renda Superior)'
                                               and `ano_ingresso` >= 2013 ";
                                echo consultaSimplesRetornaString($sql);

                                ?>
                            ]
                        }
                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        barValueSpacing: 20,
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        min: 0,
                                        beginAtZero:true
                                    }
                                }
                            ]
                        }
                    }
                });
            </script>
    </div>

    <!-- PORCENTAGEM de alunos que ingressaram via ampla concorrência e ação afirmativa (QUALQUER!) -->
    <div class="row">
            <h3 class="text-left">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa na UFG (Lei de Cotas e Programa UFGInclui)</h3>
            <canvas id="myChart14" style="width: 900px; height: 500px; "></canvas>
            <table class="table-responsive table table-bordered">
                <tr>
                    <td>UFGInclui e Lei de Cotas</td>
                    <td><?php $sql = "SELECT Count(*) / (SELECT Count(*)
                                                           FROM   `$anoSelecionadoPOST`) * 100.0 AS count
                                        FROM   `$anoSelecionadoPOST`
                                        WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                                               AND `acao_afirmativa` <> '(DC Renda Superior)'
                                               AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                                               AND `acao_afirmativa` <> '(PPI Renda Superior)'
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Negro Escola Pública' )
                                               AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Escola Pública' )
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Quilombola' )
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Surdo' ) ";
                                $amplaConcorrencia = consultaSimplesRetornaArray($sql);
                                $acaoAfirmativa = 100 - $amplaConcorrencia[0];

                                echo round($acaoAfirmativa, 2); ?>
                    %</td>
                </tr>
                <tr>
                    <td>Ampla Concorrência (AC)</td>
                    <td> <?php echo round($amplaConcorrencia[0], 2); ?>% </td>
                </tr>
            </table>
            <script>
                var ctx = document.getElementById("myChart14");

                var data = {
                    labels: [
                        "Ação Afirmativa",
                        "AC"
                    ],
                    datasets: [
                        {
                            label: 'Porcentagem de estudantes',
                            backgroundColor: [
                                "#36A2EB",
                                "#FFCE56",
                            ],
                            data: [
                                <?php
                                $sql = "SELECT Count(*) / (SELECT Count(*)
                                                           FROM   `$anoSelecionadoPOST`) * 100.0 AS count
                                        FROM   `$anoSelecionadoPOST`
                                        WHERE  `acao_afirmativa` <> '(DC Renda Inferior)'
                                               AND `acao_afirmativa` <> '(DC Renda Superior)'
                                               AND `acao_afirmativa` <> '(PPI Renda Inferior)'
                                               AND `acao_afirmativa` <> '(PPI Renda Superior)'
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Negro Escola Pública' )
                                               AND `acao_afirmativa` <> 'UFGInclui - Indígena'
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Escola Pública' )
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Quilombola' )
                                               AND `acao_afirmativa` <> ( 'UFGInclui - Surdo' ) ";

                                // Ao invés de fazer uma nova pesquisa, é mais eficiente simplesmente fazer a diferença (visto que esses são os únicos dois dados no gráfico. Sendo assim, a função retorna um array para um vetor auxiliar. A diferença entre 100 e esse vetor será a outra porcentagem necessária.
                                $amplaConcorrencia = consultaSimplesRetornaArray($sql);
                                $acaoAfirmativa = 100 - $amplaConcorrencia[0];

                                echo round($acaoAfirmativa, 2) . ", ";
                                echo round($amplaConcorrencia[0], 2)
                                ?>
                            ]
                        }
                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        barValueSpacing: 20,
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        min: 0,
                                        beginAtZero:true
                                    }
                                }
                            ]
                        }
                    }
                });
            </script>
    </div>

    <!-- PORCENTAGEM de alunos que ingressaram em 2016 por SISU via ampla concorrência e ação afirmativa -->
    <div class="row">
            <h3 class="text-left">Porcentagem de Estudantes Ingressantes SISU em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência</h3>
            <canvas id="graficoIngressantesSISU" style="width: 900px; height: 500px; "></canvas>
            <table class="table table-bordered table-responsive">
                <?php
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
                    <tr><td>Ação Afirmativa</td><td><?php echo round($acaoAfirmativa, 2); ?></td></tr>
                    <tr><td>Ampla Concorrência (AC)</td><td><?php echo round($amplaConcorrencia[0], 2);  ?></td></tr>
            </table>
            <script>
                var ctx = document.getElementById("graficoIngressantesSISU");

                var data = {
                    labels: [
                        "Ação Afirmativa",
                        "AC"
                    ],
                    datasets: [
                        {
                            label: 'Porcentagem de estudantes',
                            backgroundColor: [
                                "#36A2EB",
                                "#FFCE56"
                            ],
                            data: [
                                <?php
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
                                $acaoAfirmativa = 100 - $amplaConcorrencia[0];

                                echo round($acaoAfirmativa, 2) . ", ";
                                echo round($amplaConcorrencia[0], 2);
                                ?>
                            ]
                        }
                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        barValueSpacing: 20,
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        min: 0,
                                        beginAtZero:true
                                    }
                                }
                            ]
                        }
                    }
                });
            </script>
    </div>

    <!-- Estudantes Ingressantes SISU em 2016 POR REGIONAL!! (Ampla concorrencia e acao afirmativa) -->
    <?php foreach ($arrayUnidades as $unidade => $value) : ?>
        <!-- Gráfico pizza para cada unidade -->
        <div class="row">
                <h3 class="text-left">Porcentagem de Estudantes Ingressantes SISU em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência na Regional <?php echo $unidade;?></h3>
                <canvas id="graficoPizzaIngressantesSISURegional<?php echo $unidade;?>" style="width: 900px; height: 500px; "></canvas>
                <table class="table table-responsive table-bordered">
                    <?php
                        $sql = "SELECT count(*) / (SELECT COUNT(*)
                                                   FROM `$anoSelecionadoPOST`
                                                   WHERE ano_ingresso = '$anoSelecionadoPOST'
                                                         and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                                         and `Regional` = '$unidade'
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
                                       and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                       and `Regional` = '$unidade'";

                        // Ao invés de fazer uma nova pesquisa, é mais eficiente simplesmente fazer a diferença (visto que esses são os únicos dois dados no gráfico. Sendo assim, a função retorna um array para um vetor auxiliar. A diferença entre 100 e esse vetor será a outra porcentagem necessária.
                        $amplaConcorrencia = consultaSimplesRetornaArray($sql);
                        $acaoAfirmativa = 100 - $amplaConcorrencia[0];
                    ?>
                    <tr><td>Ação Afirmativa</td><td><?php echo round($acaoAfirmativa, 2); ?>%</td></tr>
                    <tr><td>Ampla Concorrência (AC)</td><td><?php echo round($amplaConcorrencia[0], 2);  ?>%</td></tr>
                </table>
                <script>
                    var ctx = document.getElementById("graficoPizzaIngressantesSISURegional<?php echo $unidade;?>");

                    var data = {
                        labels: [
                            "Ação Afirmativa",
                            "AC"
                        ],
                        datasets: [
                            {
                                label: 'Porcentagem de estudantes',
                                backgroundColor: [
                                    "#36A2EB",
                                    "#FFCE56"
                                ],
                                data: [
                                    <?php
                                    $sql = "SELECT count(*) / (SELECT COUNT(*)
                                                               FROM `$anoSelecionadoPOST`
                                                               WHERE ano_ingresso = '$anoSelecionadoPOST'
                                                                     and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                                                     and `Regional` = '$unidade'
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
                                                   and forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                                   and `Regional` = '$unidade'";

                                    // Ao invés de fazer uma nova pesquisa, é mais eficiente simplesmente fazer a diferença (visto que esses são os únicos dois dados no gráfico. Sendo assim, a função retorna um array para um vetor auxiliar. A diferença entre 100 e esse vetor será a outra porcentagem necessária.
                                    $amplaConcorrencia = consultaSimplesRetornaArray($sql);
                                    $acaoAfirmativa = 100 - $amplaConcorrencia[0];

                                    echo round($acaoAfirmativa, 2) . ", ";
                                    echo round($amplaConcorrencia[0], 2);
                                    ?>
                                ]
                            }
                        ]
                    };

                    var myBarChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            barValueSpacing: 20,
                            scales: {
                                yAxes: [
                                    {
                                        ticks: {
                                            min: 0,
                                            beginAtZero:true
                                        }
                                    }
                                ]
                            }
                        }
                    });
                </script>
        </div>
    <?php endforeach; ?>

</div>
<?php
    require_once 'includes/footer.php';
?>
