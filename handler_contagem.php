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

    <h2 class="text-center">Gráficos de Contagem</h2>
    <h4 class="text-left noprint">Clique no nome do gráfico para mostrá-lo!</h4>
    <!-- Gráfico com o numero de estudantes matriculados em abril de 2016 por regional -->
    <div class="row">
            <h3 id="tituloMyChart1">Número de estudantes matriculados em abril de <?php echo $anoSelecionadoPOST ?> por regional</h3>
            <canvas id="myChart1" style="width: 100%; height: 500px;"></canvas>
            <table class="table table-responsive table-bordered col-md-7 col-xs-12"><tr><th>Regional</th><th>Número de Estudantes</th></tr>
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
            </table>
            <script>
                var ctx = document.getElementById("myChart1");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Goiânia", "Jataí", "Catalão", "Goiás", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE municipio=";
                    chartData($arrayUnidades, $sql);
                    ?>],
                    <?php
                    opcoesGrafico();
                    ?>;
            </script>
    </div>

    <!-- Grafico com o Número de estudantes matriculados em abril de 2016 por grau acadêmico -->
    <div class='row'>
            <h3 id="tituloMyChart2">Número de estudantes matriculados em abril de <?php echo $anoSelecionadoPOST ?> por grau acadêmico</h3>
            <canvas id="myChart2" style="width: 100%; height: 500px; "></canvas>
            <table class="table table-responsive table-bordered col-md-7 col-xs-12"><tr><th>Grau Acadêmico</th><th>Número de Estudantes</th></tr>
                <?php foreach ($arrayGrauAcademico as $grauAcademico => $value) : ?>
                <tr>
                    <td><?php echo ucwords(strtolower($grauAcademico)); ?></td>
                    <td><?php
                    $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `grau_academico` = '$grauAcademico'";
                    consultaSimplesRetornaUmValor($sql);
                    ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Total</td>
                    <td><?php
                    $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `grau_academico` =";
                    consultaSimplesRetornaSomaAsString($arrayGrauAcademico, $sql);
                    ?></td>
                </tr>
            </table>
            <script>
                var ctx = document.getElementById("myChart2");
                var myChart2 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE grau_academico=";
                    chartData($arrayGrauAcademico, $sql);
                    ?>],
                    <?php
                    opcoesGrafico();
                    ?>;
            </script>
    </div>

    <!-- Grafico com o Número de estudantes matriculados em abril de 2016 por grau acadêmico na regional Catalão-->
    <?php
    $aux = 0;
    foreach ($arrayUnidades as $unidade => $value): ?>
    <div class='row'>
            <h3 id="tituloNumeroEstudantesMatriculados<?php echo $aux;?>">Número de estudantes matriculados em abril de <?php echo $anoSelecionadoPOST; ?> por grau acadêmico na regional <?php echo $unidade; ?></h3>
            <canvas id="numeroEstudantesMatriculados<?php echo $aux;?>" style="width: 1100px; height: 500px; "></canvas>
            <table class="table table-responsive table-bordered"><tr><th>Grau Acadêmico</th><th>Número de Estudantes (Regional <?php echo $unidade; ?>)</th></tr>
                <?php foreach ($arrayGrauAcademico as $grauAcademico => $value) : ?>
                <tr>
                    <td><?php echo ucwords(strtolower($grauAcademico)); ?></td>
                    <td><?php
                    $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and `grau_academico` = '$grauAcademico'";
                    consultaSimplesRetornaUmValor($sql);
                    ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Total</td>
                    <td><?php
                    $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' and `grau_academico` = ";
                    consultaSimplesRetornaSomaAsString($arrayGrauAcademico, $sql);
                    ?></td>
                </tr>
            </table>
            <script>
                var ctx = document.getElementById("numeroEstudantesMatriculados<?php echo $aux;?>");
                var myChart3 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE Regional='$unidade' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql);
                    ?>],
                    <?php
                    opcoesGrafico();
                    ?>;
            </script>
    </div>
    <?php $aux++; endforeach; ?>

    <!-- Numero de cursos/habilitacoes por Regional -->
    <div class="row">
        <h3>Numero de Cursos/Habilitações por Regional - de 2005 a <?php echo $anoSelecionadoPOST; ?></h3>
        <canvas id="myChartHabilitacoes" style="width: 100%; height: 500px;"></canvas>
        <!-- auto generated -->
        <table id="tabelaNumeroDeCursos" class="table table-responsive table-bordered"><tr id="rowAnos"><th></th><th>2005</th><th>2006</th><th>2007</th><th>2008</th><th>2009</th><th>2010</th><th>2011</th><th>2012</th><th>2013</th><th>2014</th><th>2015</th></tr><tr id="rowGoiânia"><td>Goiânia</td><td>58</td><td>63</td><td>66</td><td>66</td><td>81</td><td>85</td><td>86</td><td>86</td><td>89</td><td>90</td><td>90</td></tr><tr id="rowJataí"><td>Jataí</td><td>11</td><td>15</td><td>18</td><td>20</td><td>21</td><td>23</td><td>23</td><td>24</td><td>24</td><td>25</td><td>25</td></tr><tr id="rowCatalão"><td>Catalão</td><td>9</td><td>14</td><td>16</td><td>19</td><td>24</td><td>25</td><td>25</td><td>25</td><td>25</td><td>26</td><td>26</td></tr><tr id="rowGoiás"><td>Goiás</td><td>1</td><td>1</td><td>1</td><td>1</td><td>3</td><td>3</td><td>3</td><td>3</td><td>5</td><td>6</td><td>7</td></tr><tr id="rowTotal"><td>Total</td><td>79</td><td>93</td><td>101</td><td>106</td><td>129</td><td>136</td><td>137</td><td>138</td><td>143</td><td>147</td><td>148</td></tr></table>
        <!-- Script da tabela -->
        <script type="text/javascript">
            // Faz a consulta dos dados no banco e insere na tabela de numero de cursos/habilitacoes
            function insereTabelaNumeroDeCursos() {
                // loop por todos os anos que estão no banco de dados até que seja menor ou igual ao ano selecionado pelo usuario
                <?php for ($anoBase = 2016; $anoBase <= $anoSelecionadoPOST; $anoBase++): ?>
                    // inserindo o th do ano
                    $('#rowAnos').find('th').last().after('<th><?php echo $anoBase;?></th>');
                    // para deixar mais dinamico, utilizar um loop para todas as unidades
                    <?php foreach ($arrayUnidades as $unidade => $value) : ?>
                        <?php
                            // setando a variavel que vai fazer a query
                            $sql = "SELECT COUNT(distinct curso) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` = '$unidade'";
                        ?>

                        $('#row<?php echo $unidade;?>').find('td').last().after('<td><?php echo consultaSimplesRetornaUmValor($sql);?></td>');
                    <?php endforeach; ?>

                    // inserindo o td da linha Total
                    <?php $sql = "SELECT COUNT(distinct curso) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` ="; ?>

                    $('#rowTotal').find('td').last().after('<td><?php echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);?></td>');
                <?php endfor; ?>
            }
        </script>
    </div>
    <script>
        var ctx = document.getElementById("myChartHabilitacoes");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    <?php for ($i=2005; $i <= $anoSelecionadoPOST; $i++) {
                        echo "'$i',";
                    }?>
                ],
                datasets: [
                    <?php foreach ($arrayUnidades as $unidade => $value): ?>
                        {
                            label: <?php echo "'$unidade'"; ?>,
                            type: 'line',
                            fill: false,
                            borderColor: <?php echo "'$arrayBackgroundColor[$unidade]'"; ?>,
                            backgroundColor: <?php echo "'$arrayBackgroundColor[$unidade]'"; ?>,
                            data: [
                            <?php
                                $dadosEstaticos = '';
                                if ($unidade == 'Goiânia') {
                                    $dadosEstaticos = "58, 63, 66, 66, 81, 85, 86, 86, 89, 90, 90,";
                                } elseif ($unidade == 'Jataí') {
                                    $dadosEstaticos = "11, 15, 18, 20, 21, 23, 23, 24, 24, 25, 25,";
                                } elseif ($unidade == 'Catalão') {
                                    $dadosEstaticos = "9, 14, 16, 19, 24, 25, 25, 25, 25, 26, 26,";
                                } elseif ($unidade == 'Goiás') {
                                    $dadosEstaticos = "1, 1, 1, 1, 3, 3, 3, 3, 5, 6, 7,";
                                }
                                echo $dadosEstaticos;
                                $anoBase = 2016;
                                while($anoBase <= $anoSelecionadoPOST) {
                                    $sql = "SELECT COUNT(distinct curso) AS count FROM `$anoBase` WHERE `ano_ingresso`= '$anoBase' and `Regional` = '$unidade'";
                                    echo consultaSimplesRetornaString($sql);
                                    $anoBase++;
                                }
                            ?>
                            ]
                        },
                    <?php endforeach; ?>
                ]
            }
        });
    </script>

    <!-- Numero de vagas por regional -->
    <div class="row">
        <h3>Número de vagas por Regional de 2005 a <?php echo $anoSelecionadoPOST; ?></h3>
        <canvas id="graficoNumeroDeVagas" style="width: 100%; height: 500px; "></canvas>
        <table id="tabelaNumeroDeVagas" class="table table-responsive table-bordered"><tr class="rowAnos"><th><br></th><th>2005</th><th>2006</th><th>2007</th><th>2008</th><th>2009</th><th>2010</th><th>2011</th><th>2012</th><th>2013</th><th>2014</th><th>2015</th></tr><tr class="rowGoiânia"><td>Goiânia</td><td>2318</td><td>2508</td><td>2548</td><td>2523</td><td>3786</td><td>4046</td><td>4065</td><td>4045</td><td>4135</td><td>4325</td><td>4265</td></tr><tr class="rowJataí"><td>Jataí</td><td>360</td><td>550</td><td>610</td><td>705</td><td>880</td><td>980</td><td>980</td><td>1020</td><td>1020</td><td>1050</td><td>1080</td></tr><tr class="rowCatalão"><td>Catalão</td><td>300</td><td>500</td><td>590</td><td>710</td><td>950</td><td>970</td><td>980</td><td>980</td><td>990</td><td>1110</td><td>1110</td></tr> <tr class="rowGoiás"> <td>Goiás</td> <td>60</td> <td>60</td> <td>60</td> <td>160</td> <td>160</td> <td>160</td> <td>160</td><td>160</td><td>210</td><td>380</td><td>470</td></tr><tr class="rowTotal"><td>Total</td><td>3038</td><td>3618</td><td>3808</td><td>3998</td><td>5776</td><td>6156</td><td>6185</td><td>6205</td><td>6355</td><td>6865</td><td>6925</td></tr></table>
        <!-- Script para a tabela com o numero de vagas ofertadas por regional -->
        <script>
            // Faz a consulta dos dados no banco e insere na tabela vagasRegional
            function insereTabelaVagasRegional() {
                <?php for ($anoBase = 2016; $anoBase <= $anoSelecionadoPOST; $anoBase++): ?>
                    // inserindo o th do ano
                    $('#tabelaNumeroDeVagas .rowAnos').find('th').last().after('<th><?php echo $anoBase;?></th>');
                    // para deixar mais dinamico, utilizar um loop para todas as unidades
                    <?php foreach ($arrayUnidades as $unidade => $value) : ?>
                        // definindo consulta
                        <?php $sql = "SELECT COUNT(*) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` = '$unidade'"; ?>

                        $('#tabelaNumeroDeVagas .row<?php echo $unidade;?>').find('td').last().after('<td><?php echo consultaSimplesRetornaUmValor($sql);?></td>');
                    <?php endforeach; ?>

                    // query da linha total
                    <?php $sql = "SELECT COUNT(*) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` ="; ?>

                    // inserindo o valor da query total na td
                    $('#tabelaNumeroDeVagas .rowTotal').find('td').last().after('<td><?php echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);?></td>');
                <?php endfor; ?>
            }
        </script>
    </div>
    <script>
        var ctx = document.getElementById("graficoNumeroDeVagas");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    <?php for ($i=2005; $i <= $anoSelecionadoPOST; $i++) {
                        echo "'$i',";
                    }?>
                ],
                datasets: [
                    <?php foreach ($arrayUnidades as $unidade => $value): ?>
                        {
                            label: <?php echo "'$unidade'"; ?>,
                            type: 'line',
                            fill: false,
                            borderColor: <?php echo "'$arrayBackgroundColor[$unidade]'"; ?>,
                            backgroundColor: <?php echo "'$arrayBackgroundColor[$unidade]'"; ?>,
                            data: [
                            <?php
                                // dadosEstaticos armazena os dados que não podem ser recebidos através do banco de dados
                                $dadosEstaticos = '';
                                if ($unidade == 'Goiânia') {
                                    $dadosEstaticos = "2318, 2508, 2548, 2523, 3786, 4046, 4065, 4045, 4135, 4325, 4265, ";
                                } elseif ($unidade == 'Jataí') {
                                    $dadosEstaticos = "360, 550, 610, 705, 880, 980, 980, 1020, 1020, 1050, 1080, ";
                                } elseif ($unidade == 'Catalão') {
                                    $dadosEstaticos = "300, 500, 590, 710, 950, 970, 980, 980, 990, 1110, 1110, ";
                                } elseif ($unidade == 'Goiás') {
                                    $dadosEstaticos = "60, 60, 60, 60, 160, 160, 160, 160, 210, 380, 470, ";
                                }
                                echo $dadosEstaticos;
                                $anoBase = 2016;
                                while($anoBase <= $anoSelecionadoPOST) {
                                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional`= '$unidade'";
                                    echo consultaSimplesRetornaString($sql);
                                    $anoBase++;
                                }
                            ?>
                            ]
                        },
                    <?php endforeach; ?>
                    {
                        label: "Total",
                        type: "line",
                        fill: false,
                        borderColor: "#a9a9a9",
                        backgroundColor: "gray",
                        data: [
                            <?php
                                $dadosEstaticos = "3038,3618,3808,3998,5776,6156,6185,6205,6355,6865,6925,";
                                echo $dadosEstaticos;
                                $anoBase = 2016;
                                while ($anoBase <= $anoSelecionadoPOST) {
                                    $sql = "SELECT COUNT(*) AS count FROM `$anoBase` WHERE `ano_ingresso` = '$anoBase' and `Regional` = ";
                                    echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
                                    $anoBase++;
                                }
                            ?>
                        ]
                    }
                ]
            }
        });
    </script>

    <!-- Gráfico com o ano de ingresso dos estudantes matriculados -->
    <div class='row'>
            <h3 class="text-left">Quantidade de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ano de Ingresso </h3>
            <canvas id="myChart7" style="width: 1100px; height: 500px; "></canvas>
            <!-- auto-generated code -->
            <table class="table table-responsive table-bordered">
                <tr>
                    <th></th>
                    <th>2004 a 2010</th>
                    <!-- inserindo os anos na tabela -->
                    <?php
                        // Para esse gráfico, o ano base é 2011.
                        $anoBase = 2011;
                        while ($anoBase <= $anoSelecionadoPOST) {
                            echo "<th>$anoBase</td>";
                            $anoBase++;
                        }
                    ?>
                </tr>
                <!-- inserindo os dados -->
                <?php foreach ($arrayUnidades as $unidade => $value) {
                echo "<tr>";
                    echo "<td>$unidade</td>";
                    // ano de 2004 a 2010
                    $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` >= 2004 and `ano_ingresso` <= 2010 and `Regional` = '$unidade'";
                    echo "<td>";
                        echo consultaSimplesRetornaUmValor($sql);
                    echo "</td>";

                    $anoBase = 2011;
                    while($anoBase <= $anoSelecionadoPOST) {
                        $sql = "SELECT COUNT(*) AS count FROM `$anoSelecionadoPOST` WHERE `ano_ingresso` = '$anoBase' and `Regional` = '$unidade'";
                        echo "<td>";
                            echo consultaSimplesRetornaUmValor($sql);
                        echo "</td>";
                        $anoBase++;
                    }
                echo "</tr>";
                }
                ?>
            </table>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("myChart7");

        <?php
            $sql = "SELECT distinct ano_ingresso FROM `$anoSelecionadoPOST` where ano_ingresso >= 2011 order by ano_ingresso asc";
            $arrayAnos = consultaSimplesRetornaArray($sql);
        ?>

        var data = {
            labels: ["2004 a 2010", <?php
                    foreach ($arrayAnos as $key => $ano) {
                        echo "'" . $ano . "',";
                    }
                ?>],
            datasets: [
                <?php foreach ($arrayUnidades as $unidade => $value): ?>
                    {
                        label: <?php echo "'$unidade'"; ?>,
                        backgroundColor: <?php echo "'$arrayBackgroundColor[$unidade]'"; ?>,
                        data: [<?php
                            $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = '$unidade'";
                            echo $res = consultaSimplesRetornaString($sql);
                            foreach ($arrayAnos as $key => $ano) {
                                $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso = " . $ano . " and Regional = '$unidade' ";

                            echo $res = consultaSimplesRetornaString($sql);
                        }
                        ?>]
                    },
                <?php endforeach;?>]
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

    <!-- Gráfico número de estudantes por sexo e regional -->
    <div class='row'>
        <h3 class="text-left">Gráfico número de estudantes por sexo e regional
        </h3>
        <canvas id="myChart8" style="width: 1100px; height: 500px; "></canvas>
        <!-- auto-generated code -->
        <table class="table table-bordered table-responsive">
            <tr>
                <th></th>
                <th>Masculino</th>
                <th>Feminino</th>
            </tr>
            <?php
            // foreach para cada unidade
            foreach ($arrayUnidades as $unidade => $value) {
                echo "<tr>";
                    echo "<td>$unidade</td>";
                //consulta banco
                $arraySexos = array ("Masculino", "Feminino");
                foreach ($arraySexos as $sexo) {
                    echo "<td>";
                    $sql = "SELECT count(sexo) * 100.0 / (select count(*) from `$anoSelecionadoPOST` where Regional = '$unidade') as count FROM `$anoSelecionadoPOST` where Regional = '$unidade' and `sexo` = '$sexo'";
                    echo consultaSimplesRetornaUmValor($sql);
                    echo "%</td>";
                }
                echo "</tr>";
            }

            // linha TOTAL
            echo "<tr>";
                echo "<td>Total</td>";
            foreach ($arraySexos as $sexo) {
                echo "<td>";
                $sql = "SELECT count(*) * 100.0 / ( SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` ) AS count FROM `$anoSelecionadoPOST` WHERE sexo = '$sexo'";
                echo consultaSimplesRetornaUmValor($sql);
                echo "%</td>";
            }
            echo "</tr>";
            ?>
        </table>
    </div>
    <script>
        var ctx = document.getElementById("myChart8");

        var data = {
            labels: [<?php
                    // Imprime as labels do gráfico, com base no array de unidades
                    foreach ($arrayUnidades as $unidade => $value) {
                        echo "'" . $unidade . "',";
                    }
                    echo "'Total'";
                ?>],
            datasets: [
                {
                    label: "Feminino",
                    backgroundColor: 'rgba(184, 18, 0, 0.7)',
                    data: [<?php
                    // Faz a consulta para cada unidade do sexo feminino e imprime a variável
                    foreach ($arrayUnidades as $unidade => $value) {
                        $sql = "SELECT count(sexo) * 100.0 / (select count(*) from `$anoSelecionadoPOST` where Regional = '$unidade') as count FROM `$anoSelecionadoPOST` where Regional = '$unidade' and sexo = 'feminino'";

                        echo $res = consultaSimplesRetornaString($sql);
                    }
                    // Faz a consulta que retorna a porcentagem de estudantes femininos em todas as regionais (TOTAL)
                    $sql = "SELECT count(*) * 100.0 / ( SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` ) AS count FROM `$anoSelecionadoPOST` WHERE sexo = 'feminino'";
                    echo $res = consultaSimplesRetornaString($sql);
                ?>]
                },
                {
                    label: "Masculino",
                    backgroundColor: "rgba(54, 162, 235, .7)",
                    data: [<?php
                    foreach ($arrayUnidades as $unidade => $value) {
                        $sql = "SELECT count(sexo) * 100.0 / (select count(*) from `$anoSelecionadoPOST` where Regional = '$unidade') as count FROM `$anoSelecionadoPOST` where Regional = '$unidade' and sexo = 'masculino'";

                        echo $res = consultaSimplesRetornaString($sql);
                    }
                    $sql = "SELECT count(*) * 100.0 / ( SELECT COUNT(Estudante) FROM `$anoSelecionadoPOST` ) AS count FROM `$anoSelecionadoPOST` WHERE sexo = 'masculino'";
                    echo $res = consultaSimplesRetornaString($sql);
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

    <!-- ************************************************ -->
            <!-- INÍCIO DADOS ACAO AFIRMATIVA!!! -->
    <!-- ************************************************ -->

    <!-- Gráfico do número de estudantes c/ ação afirmativa , que ingressaram até 2012 -->
    <div class="row">
        <h3 class="text-left">Número De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Por Ação Afirmativa Na Ufg Com Ingresso Até 2012 (Anterior a Lei De Cotas)</h3>
        <canvas id="myChart10"><p>teste</p></canvas>
        <!-- auto generatedcode -->
        <table class="table table-responsive table-bordered">
        <tr>
            <td>Ampla Concorrência (AC)</td>
            <td>
            <?php
                $sql = "SELECT count(`Estudante`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` <= 2012";
                    consultaSimplesRetornaUmValor($sql);
            ?>
            </td>
        </tr>
        <?php foreach ($arrayAcaoAfirmativa as $acao => $value) {
            echo "<tr>";
            echo "<td>$acao</td>";
            $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` <= 2012";
                echo "<td>";
                consultaSimplesRetornaUmValor($sql);
                echo "</td>";
            echo "</tr>";
        } ?>
        </table>
    </div>
    <script>
            var ctx = document.getElementById("myChart10");

            var data = {
                labels: ["AC", "Escola Pública", "Negro Escola Pública", "Indígena", "Negro Quilombola", "Surdos"],
                datasets: [{
                    label: 'Número de estudantes',
                    backgroundColor: 'rgba(54, 162, 235, .7)',
                    data: [<?php
                        $sql = "SELECT count(`Estudante`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` <= 2012";
                        echo consultaSimplesRetornaString($sql);
                        foreach ($arrayAcaoAfirmativa as $acao => $value) {
                            $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` <= 2012";
                            echo consultaSimplesRetornaString($sql);
                        }
                    ?>]
                }]
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

    <!-- Gráfico do numero de estudantes via lei de cotas e UFG Inclui a partir de 2013 -->
    <div class="row">
            <h3 class="text-left">Porcentagem De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Por Ação Afirmativa Na Ufg Com Ingresso A Partir de 2013 (Lei de Cotas e Programa UFGInclui)</h3>
            <canvas id="myChart12" style="width: 900px; height: 500px; "></canvas>
            <table class="table table-responsive table-bordered">
                <tr>
                    <td>Ampla Concorrência (AC)</td>
                    <td>
                        <?php
                            // Total por ampla concorrencia
                            $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013";
                            echo consultaSimplesRetornaUmValor($sql);
                        ?>
                    </td>
                </tr>
                <!-- total por renda superior/inferior (cotas) -->
                <?php
                    foreach ($arrayRendas as $renda => $value) {
                        $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013";
                        echo "<tr><td>$renda</td><td>";
                        echo consultaSimplesRetornaUmValor($sql);
                        echo "</td></tr>";
                    }

                    // total ufg inclui.
                    // ps: escola publica e negro escola publica não é considerado, de acordo com o documento (/doc/modelo.pdf, pag 33)
                    foreach ($arrayAcaoAfirmativa as $acao => $value) {
                        if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                            $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013";
                            echo "<tr><td>$acao</td><td>";
                            echo consultaSimplesRetornaUmValor($sql);
                            echo "</td></tr>";
                        }
                    }
                ?>

            </table>
            <script>
                var ctx = document.getElementById("myChart12");

                var data = {
                    labels: [
                        "AC",
                        "L1",
                        "L2",
                        "L3",
                        "L4",
                        "Indígena",
                        "Quilombola",
                        "Surdo"
                    ],
                    datasets: [
                        {
                            label: 'Número de estudantes',
                            backgroundColor: "#36A2EB",
                            data: [
                                <?php
                                // Total por ampla concorrencia
                                $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013";
                                echo consultaSimplesRetornaString($sql);

                                // total por renda superior/inferior (cotas)
                                foreach ($arrayRendas as $renda => $value) {
                                    $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013";
                                    echo consultaSimplesRetornaString($sql);
                                }

                                // total ufg inclui.
                                // ps: escola publica e negro escola publica não é considerado, de acordo com o documento (/doc/modelo.pdf, pag 33)
                                foreach ($arrayAcaoAfirmativa as $acao => $value) {
                                    if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                                        $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013";
                                        echo consultaSimplesRetornaString($sql);
                                    }
                                }
                                ?>
                            ]
                        }
                    ]
                };

                var myBarChart = new Chart(ctx, {
                    type: 'bar',
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

    <!-- Estudantes Ingressantes SISU em 2016 por Ação Afirmativa e Ampla Concorrência -->
    <div class="row">
            <h3 class="text-left">Número De Estudantes Ingressantes SISU Em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência</h3>
            <canvas id="myChart15" style="width: 900px; height: 500px; "></canvas>
            <table class="table table-bordered table-responsive">
            <tr>
                    <td>Ampla Concorrência (AC)</td>
                    <td>
                        <?php $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(DC Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` = 2016 and `forma_ingresso` = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'";
                            echo consultaSimplesRetornaUmValor($sql); ?>
                    </td>
                </tr>
                <?php
                    foreach ($arrayRendas as $renda => $value) {
                        $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU' and `ano_ingresso` = $anoSelecionadoPOST and `acao_afirmativa` = '$renda'";
                        echo "<tr><td>$renda</td><td>";
                        echo consultaSimplesRetornaUmValor($sql);
                        echo "</td></tr>";
                    }
                ?>
            </table>
            <script>
                var ctx = document.getElementById("myChart15");

                var data = {
                    labels: [
                        "AC",
                        "L1",
                        "L2",
                        "L3",
                        "L4"
                    ],
                    datasets: [
                        {
                            label: 'Número de estudantes',
                            backgroundColor: 'rgba(54, 162, 235, .7)',
                            data: [
                                <?php
                                $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(DC Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` = 2016 and `forma_ingresso` = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'";
                                echo consultaSimplesRetornaString($sql);

                                foreach ($arrayRendas as $renda => $value) {
                                    $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU' and `ano_ingresso` = $anoSelecionadoPOST and `acao_afirmativa` = '$renda'";
                                    echo consultaSimplesRetornaString($sql);
                                }
                                ?>
                            ]
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
    </div>

    <!-- Estudantes Ingressantes SISU em 2016 POR REGIONAL!! (Ampla concorrencia e acao afirmativa) -->
    <?php foreach ($arrayUnidades as $unidade => $value) : ?>
        <!-- Gráfico barra para cada unidade -->
        <div class="row">
                <h3 class="text-left">Número De Estudantes Ingressantes SISU Em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência na Regional <?php echo $unidade; ?></h3>
                <canvas id="graficoBarraIngressantesSISURegional<?php echo $unidade;?>" style="width: 900px; height: 500px; "></canvas>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td>Ampla Concorrência (AC)</td>
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
                                           AND `ano_ingresso` = 2016
                                           AND `forma_ingresso` = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                           AND `Regional` = '$unidade'";
                            echo consultaSimplesRetornaUmValor($sql);
                            ?>
                        </td>
                    </tr>
                    <?php
                    foreach ($arrayRendas as $renda => $value) {
                            $sql = "SELECT Count(*) AS count
                                    FROM   `$anoSelecionadoPOST`
                                    WHERE  forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                           AND `ano_ingresso` = $anoSelecionadoPOST
                                           AND `acao_afirmativa` = '$renda'
                                           AND `Regional` = '$unidade'";
                            echo "<tr><td>$renda</td><td>";
                            echo consultaSimplesRetornaUmValor($sql);
                            echo "</td></tr>";
                        }
                    ?>
                </table>
                <script>
                    var ctx = document.getElementById("graficoBarraIngressantesSISURegional<?php echo $unidade;?>");

                    var data = {
                        labels: [
                            "AC",
                            "L1",
                            "L2",
                            "L3",
                            "L4"
                        ],
                        datasets: [
                            {
                                label: 'Número de estudantes',
                                backgroundColor: 'rgba(54, 162, 235, .7)',
                                data: [
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
                                                   AND `ano_ingresso` = 2016
                                                   AND `forma_ingresso` = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                                   AND `Regional` = '$unidade'";
                                    echo consultaSimplesRetornaString($sql);

                                    foreach ($arrayRendas as $renda => $value) {
                                        $sql = "SELECT Count(*) AS count
                                                FROM   `$anoSelecionadoPOST`
                                                WHERE  forma_ingresso = 'SISTEMA DE SELEÇÃO UNIFICADA - SiSU'
                                                       AND `ano_ingresso` = $anoSelecionadoPOST
                                                       AND `acao_afirmativa` = '$renda'
                                                       AND `Regional` = '$unidade'";
                                        echo consultaSimplesRetornaString($sql);
                                    }
                                    ?>
                                ]
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
        </div>
    <?php endforeach; ?>
</div>

<?php
  require_once 'includes/footer.php';
?>
