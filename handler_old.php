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
?>

<script>
    $.LoadingOverlay("show", {
        color: "rgba(250,250,250,0.9)",
        fade: "fast"
    });
</script>

<div id="container-geral" class="container" style="margin: 0 auto;">
    <h4>Clique no nome do gráfico para mostrá-lo!</h4>
    <!-- Gráfico com o numero de estudantes matriculados em abril de 2016 por regional -->

    <div class="row contagem">
            <h3 id="tituloMyChart1">Número de estudantes matriculados em abril de <?php echo $anoSelecionadoPOST ?> por regional</h3>
            <canvas class="col-md-4" id="myChart1" style="width: 500px; height: 300px; display: none;"></canvas>
            <table class="table table-responsive table-bordered col-md-2"><tr><th>Regional</th><th>Número de Estudantes</th></tr>
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
                // ctx.canvas.width = 300;
                // ctx.canvas.height = 300;
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
    <div class='row contagem'>
            <h3 id="tituloMyChart2">Número de estudantes matriculados em abril de 2016 por grau acadêmico</h3>
            <canvas id="myChart2" style="width: 1100px; height: 500px; display: none;"></canvas>
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
    <div class='row contagem'>
            <h3 id="tituloNumeroEstudantesMatriculados<?php echo $aux;?>">Número de estudantes matriculados em abril de <?php echo $anoSelecionadoPOST; ?> por grau acadêmico na regional <?php echo $unidade; ?></h3>
            <canvas id="numeroEstudantesMatriculados<?php echo $aux;?>" style="width: 1100px; height: 500px; display: none;"></canvas>
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
    <div class="row contagem">
        <h3>Numero de Cursos/Habilitações por Regional - de 2005 a <?php echo $anoSelecionadoPOST; ?></h3>
        <canvas id="myChartHabilitacoes" style="width: 100%; height: 500px; display: none;"></canvas>
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
    <div class="row contagem">
        <h3>Número de vagas por Regional de 2005 a <?php echo $anoSelecionadoPOST; ?></h3>
        <canvas id="graficoNumeroDeVagas" style="width: 1100px; height: 500px; display: none;"></canvas>
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
    <!-- ESSA ESTRUTURA ABAIXO NÃO PODE SER APAGADA!!! MESMO A DIV ESTANDO HIDDEN, ALGUM BUG (NÃO ENCONTRADO) NÃO ESTÁ
        DEIXANDO COM QUE A PÁGINA FUNCIONE SEM ESSA DIV. -->
    <div class="row" style="display: none;">
        <h3 class="text-left">Número de Vagas Ofertadas de 2005 a <?php echo $anoSelecionadoPOST; ?> por Regional</h3>
        <!-- <canvas id="graficoNumVagasRegional" style="width: 1100px; height: 500px; display: none;"></canvas> -->
    </div>
    <!-- script do gráfico -->
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
    <div class='row contagem'>
            <h3 class="text-left">Quantidade de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ano de Ingresso </h3>
            <canvas id="myChart7" style="width: 1100px; height: 500px; display: none;"></canvas>
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
    <div class='row contagem'>
            <h3 class="text-left">Gráfico número de estudantes por sexo e regional
            </h3>
            <canvas id="myChart8" style="width: 1100px; height: 500px; display: none;"></canvas>
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
    <script type="text/javascript">
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

    <!-- Gráfico porcentagem de estudantes por faixa etaria matriculados -->
    <div class='row porcentagem'>
            <h3 class="text-left">Porcentagem de estudantes por faixa etária matriculados em abril de <?php echo $anoSelecionadoPOST; ?>
            </h3>
            <canvas id="myChart9" style="width: 1100px; height: 500px; display: none;"></canvas>
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
        <div class='row porcentagem'>
            <h3 class="text-left">Porcentagem de estudantes por faixa etária matriculados em abril de <?php echo $anoSelecionadoPOST; ?> na regional <?php echo $unidade; ?>
            </h3>
            <canvas id="chartAnosRegional<?php echo $unidade; ?>" style="width: 1100px; height: 500px; display: none;"></canvas>
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

    <!-- Tabela com a faixa das médias globais usadas nos gráficos -->
    <div class="tabela porcentagem">
        <h3 class="text-left">Faixas das médias globais usadas nas próximas tabelas</h3>
        <table class="table table-responsive text-center" style="display: none;">
            <thead>
                <tr>
                    <th class="text-center">
                        Valor
                    </th>
                    <th class="text-center">
                        Faixa
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop para não precisar digitar toda a tabela
                for ($i=0; $i < 10; $i++) {
                    $aux = $i;
                    $aux2 = $i;
                    $str = "<tr>
                                <td>
                                    ".++$aux2."
                                </td>
                                <td>
                                     $aux < MG <= " . ++$aux . "
                                </td>
                            </tr>";
                    echo $str;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Gráfico com porcentagem da media global dos alunos GERAL-->
    <div class='row porcentagem'>
            <h3 class="text-left">Porcentagem da media global dos alunos por intervalo <?php echo $anoSelecionadoPOST; ?>
            </h3>
            <canvas id="chartPorcentagemMediaGlobalGeral" style="width: 1100px; height: 500px; display: none;"></canvas>
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
            <div class='row porcentagem'>
                <h3 class="text-left">Porcentagem da media global dos alunos por intervalo <?php echo $anoSelecionadoPOST; ?> na regional <?php echo $unidade; ?>
                </h3>
                <canvas id="chartPorcentagemMediaGlobalUnidade<?php echo $unidade; ?>" style="width: 1100px; height: 500px; display: none;"></canvas>
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


    <!-- ************************************************ -->
            <!-- INÍCIO DADOS ACAO AFIRMATIVA!!! -->
    <!-- ************************************************ -->

    <!-- FALTA UMA TABELA AQUI!!, TABELA DA PAG. 29 -->
    <div class="hide contagem">
        <h3 class="text-left">Número de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa Por Regional com Ingresso até 2012 (Anterior à Lei de Cotas)</h3>
        <table class="table table-bordered table-responsive text-center" style="display: none;">
            <tr>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Regional</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">AC</th>
                <th colspan="5" class="text-center" style="vertical-align: middle;">Programa UFGInclui</th>
            </tr>
            <tr>
                <td>Reserva de 10% das vagas- Escola Pública</td>
                <td>Reserva de 10% das vagas - Negro Escola Pública</td>
                <td>Vaga Extra para Indígena</td>
                <td>Vaga Extra para Negro Quilombola</td>
                <td>15 vagas Surdos</td>
            </tr>
            <?php foreach ($arrayUnidades as $unidade => $value) {
            echo "<tr>";
                echo "<th class='text-center'>$unidade</td>";
                // consulta ampla concorrencia
                $sqlAC = "SELECT count(`Estudante`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` <= 2012 and  `Regional` = '$unidade'";
                echo "<td>";
                consultaSimplesRetornaUmValor($sqlAC);
                echo "</td>";
                foreach ($arrayAcaoAfirmativa as $acao => $value) {
                    $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` <= 2012 and  `Regional` = '$unidade'";
                    echo "<td>";
                    consultaSimplesRetornaUmValor($sql);
                    echo "</td>";
                }
            echo "</tr>";
            }

            // Linha total
            echo "<tr>";
            echo "<td>Total</td>";
            $sql = "SELECT count(`Estudante`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> ('UFGInclui - Negro Escola Pública') and `acao_afirmativa` <> 'UFGInclui - Indígena' and `acao_afirmativa` <> ('UFGInclui - Escola Pública') and `acao_afirmativa` <> ('UFGInclui - Quilombola') and `acao_afirmativa` <> ('UFGInclui - Surdo') and `ano_ingresso` <= 2012 and  `Regional` =";

            echo "<td>";
                consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
            echo "</td>";

            foreach ($arrayAcaoAfirmativa as $acao => $value) {
                $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` <= 2012 and  `Regional` =";
                echo "<td>";
                    consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
                echo "</td>";
            }
            echo "</tr>";

            ?>
        </table>
    </div>


    <!-- Gráfico do número de estudantes c/ ação afirmativa , que ingressaram até 2012 -->
    <div class=" row contagem">
            <h3 class="text-left">Número De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Por Ação Afirmativa Na Ufg Com Ingresso Até 2012 (Anterior a Lei De Cotas)</h3>
            <canvas id="myChart10" style="display: none;"></canvas>
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
    </div>

    <!-- Gráfico DA PORCENTAGEM (GRAFICO PIZZA) de estudantes c/ ação afirmativa , que ingressaram até 2012 -->
    <div class="row porcentagem">
            <h3 class="text-left">Porcentagem De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Por Ação Afirmativa Na Ufg Com Ingresso Até 2012 (Anterior a Lei De Cotas)</h3>
            <canvas id="myChart11" style="width: 900px; height: 500px; display: none;"></canvas>
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

    <!-- Tabela acao afirmativa -->
    <div class="row contagem">
            <h3>Numero De Estudantes Matriculados <?php echo $anoSelecionadoPOST;?> Por Ação Afirmativa Por Regional Com Ingresso a Partir De 2013 (Lei De Cotas E Programa UFGInclui)</h3>
            <table class="table table-responsive text-center table-bordered" style="display: none;">
                <tr>
                    <th rowspan="2" class="text-center" style="vertical-align: middle;">Regional</th>
                    <th colspan="5" class="text-center" style="vertical-align: middle;">Lei de Cotas</th>
                    <th colspan="3" class="text-center" style="vertical-align: middle;">Programa UFGInclui 2013 a 2015</th>
                </tr>
                <tr>
                    <th class="text-center" style="vertical-align: middle;">AC</th>
                    <th class="text-center" style="vertical-align: middle;">L1<br>(Baixa renda)</th>
                    <th class="text-center" style="vertical-align: middle;">L2<br>(Baixa Renda PPI)</th>
                    <th class="text-center" style="vertical-align: middle;">L3<br>(Independente da Renda</th>
                    <th class="text-center" style="vertical-align: middle;">L4<br>(Independente da Renda PPI)</th>
                    <th class="text-center" style="vertical-align: middle;">Vagas Extras Para Indígenas</th>
                    <th class="text-center" style="vertical-align: middle;">Vagas Extras Para Quilombolas</th>
                    <th class="text-center" style="vertical-align: middle;">Reserva de 15 Vagas Para Surdos</th>
                </tr>
                <?php
                foreach ($arrayUnidades as $unidade => $value) : ?>
                <tr>
                    <th class="text-center" style="vertical-align: middle;"><?php echo $unidade; ?></th>
                    <?php
                    echo "<td>";
                    // Consulta de Ampla Concorrencia
                    $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013";
                    echo consultaSimplesRetornaUmValor($sql);
                    echo "</td>";

                    // Loop para inserir os valores da Lei de Cotas
                    foreach ($arrayRendas as $renda => $value) {
                        echo "<td>";
                        $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013";
                        echo consultaSimplesRetornaUmValor($sql);
                        echo "</td>";
                    }

                    // Loop para inserir os valores do programa UFGInclui.
                    // Nesse caso específico, escola pública e negros escola pública ficam de fora.
                    foreach ($arrayAcaoAfirmativa as $acao => $value) {
                        if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                            echo "<td>";
                            $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013";
                            echo consultaSimplesRetornaUmValor($sql);
                            echo "</td>";
                        }
                    }
                    ?>
                </tr>
                <?php endforeach; ?>

                <!-- Criação da última linha, referente ao total (Soma dos valores das columas acima).
                A estrutura é basicamente a mesma da inserção das estruturas, mas decidi separar para deixar o código um pouco mais legível. As queries continuam basicamente a mesma, a diferença é que é passado um vetor contendo todas as regionais para uma função que retorna a soma da consulta realizada em todas as regionais, obtendo assim o valor total desejado. -->
                <tr>
                    <th class="text-center" style="vertical-align: middle;">Total</th>
                    <?php
                    echo "<td>";
                    $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013 and Regional = ";
                    echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
                    echo "</td>";

                    // soma das leis de cotas
                    foreach ($arrayRendas as $renda => $value) {
                        echo "<td>";
                            $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013 and Regional = ";
                            echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
                            echo "</td>";
                    }

                    // Soma do UFGInclui
                    // Novamente, escola pública e negro escola pública ficam de fora, como especificado pelo documento modelo. (/doc/modelo.pdf, pag. 32)
                    foreach ($arrayAcaoAfirmativa as $acao => $value) {
                        if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                            echo "<td>";
                            $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013 and Regional = ";
                            echo consultaSimplesRetornaSomaAsString($arrayUnidades, $sql);
                            echo "</td>";
                        }
                    }
                    ?>
                </tr>
            </table>
    </div>

    <!-- Gráfico do numero de estudantes via lei de cotas e UFG Inclui a partir de 2013 -->
    <div class="row porcentagem">
            <h3 class="text-left">Porcentagem De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Por Ação Afirmativa Na Ufg Com Ingresso A Partir de 2013 (Lei de Cotas e Programa UFGInclui)</h3>
            <canvas id="myChart12" style="width: 900px; height: 500px; display: none;"></canvas>
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

    <!-- Gráfico DA PORCENTAGEM (GRAFICO PIZZA) de estudantes via lei de cotas e UFG Inclui que ingressaram a partir de 2013 -->
    <div class="row porcentagem">
            <h3 class="text-left">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa na UFG com Ingresso a Partir de 2013 (Lei de Cotas e Programa UFGInclui)</h3>
            <canvas id="myChart13" style="width: 900px; height: 500px; display: none;"></canvas>
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
    <div class="row porcentagem">
            <h3 class="text-left">Porcentagem de Estudantes Matriculados em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa na UFG (Lei de Cotas e Programa UFGInclui)</h3>
            <canvas id="myChart14" style="width: 900px; height: 500px; display: none;"></canvas>
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

    <!-- Estudantes Ingressantes SISU em 2016 por Ação Afirmativa e Ampla Concorrência -->
    <div class="row contagem">
            <h3 class="text-left">Número De Estudantes Ingressantes SISU Em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência</h3>
            <canvas id="myChart15" style="width: 900px; height: 500px; display: none;"></canvas>
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

    <!-- PORCENTAGEM de alunos que ingressaram em 2016 por SISU via ampla concorrência e ação afirmativa -->
    <div class="row porcentagem">
            <h3 class="text-left">Porcentagem de Estudantes Ingressantes SISU em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência</h3>
            <canvas id="graficoIngressantesSISU" style="width: 900px; height: 500px; display: none;"></canvas>
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
        <!-- Gráfico barra para cada unidade -->
        <div class="row contagem">
                <h3 class="text-left">Número De Estudantes Ingressantes SISU Em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência na Regional <?php echo $unidade; ?></h3>
                <canvas id="graficoBarraIngressantesSISURegional<?php echo $unidade;?>" style="width: 900px; height: 500px; display: none;"></canvas>
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

        <!-- Gráfico pizza para cada unidade -->
        <div class="row porcentagem">
                <h3 class="text-left">Porcentagem de Estudantes Ingressantes SISU em <?php echo $anoSelecionadoPOST; ?> por Ação Afirmativa e Ampla Concorrência na Regional <?php echo $unidade;?></h3>
                <canvas id="graficoPizzaIngressantesSISURegional<?php echo $unidade;?>" style="width: 900px; height: 500px; display: none;"></canvas>
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

    <!-- TABELA - Média Das Médias Globais Por Ação Afirmativa E Por Regional De Estudantes Matriculados Em Abril De 2016 Com Ingresso Até 2012 -->
    <div class="row media">
        <h3 class="text-left">Média Das Médias Globais Por Ação Afirmativa E Por Regional De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?> Com Ingresso Até 2012</h3>
        <table class="table table-bordered table-responsive text-center" style="display: none;">
            <tr>
                <th></th>
                <th></th>
                <th colspan="5" class="text-center">UFGInclui até 2012</th>
            </tr>
            <tr>
                <th class="text-center"></th>
                <th class="text-center">Ampla Concorrência</th>
                <th class="text-center">10% para Escola Pública</th>
                <th class="text-center">10% para Negro Escola Pública</th>
                <th class="text-center">Vaga Extra para Indígena</th>
                <th class="text-center">Vaga Extra para Negro Quilombola</th>
                <th class="text-center">Reserva de 15 vagas Surdo *</th>
            </tr>
            <?php foreach ($arrayUnidades as $unidade => $value) : ?>
                <tr>
                    <th class="text-center"><?php echo $unidade; ?></th>

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

            <!-- Linha TOTAL -->
            </tr>
                <!-- Criação da última linha (TOTAL), referente à média das columas acima.
                A estrutura é basicamente a mesma da inserção das estruturas, mas decidi separar para deixar o código um pouco mais legível. As queries continuam basicamente a mesma, a diferença é que é passado um vetor contendo todas as regionais para uma função que retorna a soma da consulta realizada em todas as regionais, obtendo assim o valor total desejado. -->
                <tr>
                    <th class="text-center" style="vertical-align: middle;">Total</th>
                    <td>
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
                    </td>

                    <!-- Média geral do UFGInclui -->
                    <?php foreach ($arrayAcaoAfirmativa as $acao => $value) : ?>
                        <td>
                            <?php
                            $sql = "SELECT AVG(`media_global`) AS count
                                    FROM `$anoSelecionadoPOST`
                                    WHERE `acao_afirmativa` = '$acao'
                                           AND `ano_ingresso` <= 2012
                                           AND Regional = ";
                            echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
        </table>
        <h7> * Para o curso de Letras: Libras da Regional Goiânia</h7>
    </div>

    <!-- BARRA AGRUPADA - Média Das Médias Globais Dos Estudantes Ingresso Pelo Programa Ufginclui Matriculados Em Abril/2016 Com Ingresso Anterior até 2012  -->
    <div class='row media'>
            <h3 class="text-left">Média Das Médias Globais Dos Estudantes Ingresso Pelo Programa Ufginclui Matriculados Em <?php echo $anoSelecionadoPOST; ?> Com Ingresso Até 2012</h3>
            <canvas id="myChartMediaGlobalBarraMultipla" style="width: 1100px; height: 500px; display: none;"></canvas>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("myChartMediaGlobalBarraMultipla");

        var data = {
            labels: ["AC", <?php
                    // Imprime as labels do gráfico, com base no array de unidades
                    foreach ($arrayAcaoAfirmativa as $acao => $value) {
                        echo "'" . $acao . "',";
                    }
                ?>],
            datasets: [
                    // loop para cada label das acoes afirmativas
                    <?php foreach ($arrayUnidades as $unidade => $value): ?>
                    {
                        label: <?php echo "\"$unidade\""?>,
                        backgroundColor: <?php echo "\"$arrayBackgroundColor[$unidade]\""; ?>,
                        data: [ <?php
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

                            echo consultaSimplesRetornaString($sql);
                            // dentro de cada acao, é preciso calcular para todas as unidades, portanto um loop para as unidades:
                            foreach ($arrayAcaoAfirmativa as $acao => $value) {
                                $sql = "SELECT AVG(`media_global`) AS count
                                    FROM `$anoSelecionadoPOST`
                                    WHERE `acao_afirmativa` = '$acao'
                                           AND `ano_ingresso` <= 2012
                                           AND `Regional` = '$unidade'";

                                echo consultaSimplesRetornaString($sql);
                            }
                        ?>]
                    },
                    <?php endforeach; ?>

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

    <!-- TABELA - Média Das Médias Globais Dos Estudantes Ingresso Pelo Programa Ufginclui E Pela Lei De Cotas Matriculados Com Ingresso enrte 2013 e 2015 -->
    <div class="row media">
            <h3 class="text-left">Média Das Médias Globais Dos Estudantes Ingresso Pelo Programa Ufginclui E Pela Lei De Cotas Matriculados Em <?pho echo $anoSelecionadoPOST; ?> Com Ingresso Entre 2013 e 2015</h3>
            <table class="table table-responsive text-center table-bordered" style="display: none;">
                <tr>
                    <th rowspan="2" class="text-center" style="vertical-align: middle;">Regional</th>
                    <th colspan="5" class="text-center" style="vertical-align: middle;">Lei de Cotas</th>
                    <th colspan="3" class="text-center" style="vertical-align: middle;">Programa UFGInclui 2013 a 2015</th>
                </tr>
                <tr>
                    <th class="text-center" style="vertical-align: middle;">AC</th>
                    <th class="text-center" style="vertical-align: middle;">L1<br>(Baixa renda)</th>
                    <th class="text-center" style="vertical-align: middle;">L2<br>(Baixa Renda PPI)</th>
                    <th class="text-center" style="vertical-align: middle;">L3<br>(Independente da Renda</th>
                    <th class="text-center" style="vertical-align: middle;">L4<br>(Independente da Renda PPI)</th>
                    <th class="text-center" style="vertical-align: middle;">Vagas Extras Para Indígenas</th>
                    <th class="text-center" style="vertical-align: middle;">Vagas Extras Para Quilombolas</th>
                    <th class="text-center" style="vertical-align: middle;">Reserva de 15 Vagas Para Surdos</th>
                </tr>
                <?php
                foreach ($arrayUnidades as $unidade => $value) : ?>
                <tr>
                    <th class="text-center" style="vertical-align: middle;"><?php echo $unidade; ?></th>
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


                <!-- LINHA TOTAL -->
                <!-- Criação da última linha, referente ao total (MÉDIA dos valores das columas acima). -->
                <tr>
                    <th class="text-center" style="vertical-align: middle;">Total</th>

                    <!-- MEDIA AMPLA CONCORRENCIA -->
                    <?php
                    echo "<td>";
                    $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013 AND `ano_ingresso` <= 2015 and Regional = ";
                    echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                    echo "</td>";

                    // MEDIA das leis de cotas
                    foreach ($arrayRendas as $renda => $value) {
                        echo "<td>";
                            $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$renda' and `ano_ingresso` >= 2013 and  `ano_ingresso` <= 2015 AND Regional = ";
                            echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                            echo "</td>";
                    }

                    // MEDIA do UFGInclui
                    // Novamente, escola pública e negro escola pública ficam de fora, como especificado pelo documento modelo.
                    foreach ($arrayAcaoAfirmativa as $acao => $value) {
                        if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                            echo "<td>";
                            $sql = "SELECT AVG(`media_global`) AS count FROM `$anoSelecionadoPOST` WHERE `acao_afirmativa` = '$acao' and `ano_ingresso` >= 2013 and `ano_ingresso` <= 2015 and Regional = ";
                            echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                            echo "</td>";
                        }
                    }
                    ?>
                </tr>
            </table>
    </div>

    <!-- BARRA AGRUPADA - Média Das Médias Globais Dos Estudantes Matriculados Em Abril /2016 Com Ingresso Pelo Programa Ufginclui E Pela Lei De Cotas Com Ingresso De 2013 a 2015  -->
    <div class='row media'>
            <h3 class="text-left">Média Das Médias Globais Dos Estudantes Ingresso Pelo Programa Ufginclui Matriculados Em <?php echo $anoSelecionadoPOST; ?> Com Ingresso Entre 2013 e 2015</h3>
            <canvas id="myChartMediaGlobalBarraMultipla2" style="width: 1100px; height: 500px; display: none;"></canvas>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("myChartMediaGlobalBarraMultipla2");

        var data = {
            labels: ["AC", "L1", "L2", "L3", "L4", <?php
                foreach ($arrayAcaoAfirmativa as $acao => $value) {
                    if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública')
                        echo "'$acao', ";
                }
                ?>],
            datasets: [
                    // loop para cada label das acoes afirmativas
                    <?php foreach ($arrayUnidades as $unidade => $value): ?>
                    {
                        label: <?php echo "\"$unidade\""?>,
                        backgroundColor: <?php echo "\"$arrayBackgroundColor[$unidade]\""; ?>,
                        data: [ <?php
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

                            echo consultaSimplesRetornaString($sql);

                            // L1 L2 L3 L4
                            foreach ($arrayRendas as $renda => $value) {
                                $sql = "SELECT AVG(`media_global`) AS count
                                        FROM `$anoSelecionadoPOST`
                                        WHERE `Regional` = '$unidade'
                                              and `ano_ingresso` >= 2013
                                              and `ano_ingresso` <= 2015
                                              and `acao_afirmativa` = '$renda'";

                                echo consultaSimplesRetornaString($sql);
                            }

                            // UFG INDIGENA, QUILOMBO, SURDOS
                            foreach ($arrayAcaoAfirmativa as $acao => $value) {
                                if ($acao !== 'UFGInclui - Escola Pública' and $acao !== 'UFGInclui - Negro Escola Pública') {
                                    $sql = "SELECT AVG(`media_global`) AS count
                                    FROM `$anoSelecionadoPOST`
                                    WHERE `acao_afirmativa` = '$acao'
                                           AND `ano_ingresso` >= 2013
                                           AND `ano_ingresso` <= 2015
                                           AND `Regional` = '$unidade'";

                                    echo consultaSimplesRetornaString($sql);
                                }
                            }
                        ?>
                        ]
                    },
                <?php endforeach; ?>
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

    <!-- TABELA - Média Das Médias Globais Por ação Afirmativa E Por Regional De Estudantes Matriculados Em Abril De 2016* -->
    <div class="row media">
        <h3>Média Das Médias Globais Por ação Afirmativa E Por Regional De Estudantes Matriculados Em <?php echo $anoSelecionadoPOST; ?>*</h3>
        <table class="table-responsive table text-center table-bordered" style="display: none;">
        <tr>
            <th class="text-center"></th>
            <th class="text-center">AC</th>
            <th class="text-center">L1</th>
            <th class="text-center">L2</th>
            <th class="text-center">L3</th>
            <th class="text-center">L4</th>
            <th class="text-center">UFGInclui</th>
        </tr>
        <?php foreach ($arrayUnidades as $unidade => $value): ?>
        <tr>
            <th class="text-center"><?php echo $unidade;?></th>
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

        <!-- ROW TOTAL -->
        <tr class="TOTAL">
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
        </tr>
        </table>
        <h7> * Para o cálculo da tabela acima, foram retirados os ingressantes de <?php echo $anoSelecionadoPOST; ?></h7>
    </div>

    <!-- BARRA AGRUPADA - Média Das Médias Globais Por ação Afirmativa E Por Regional De Estudantes Matriculados Em Abril De 2016* -->
    <div class='row media'>
        <h3 class="text-left">Média Das Médias Globais Por ação Afirmativa E Por Regional De Estudantes Matriculados Em Abril De 2016</h3>
        <canvas id="myChartMediaGlobalBarraMultipla3" style="width: 1100px; height: 500px; display: none;"></canvas>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("myChartMediaGlobalBarraMultipla3");

        var data = {
            labels: ["AC", "L1", "L2", "L3", "L4", "UFGInclui"],
            datasets: [
                    // loop para cada label das acoes afirmativas
                    <?php foreach ($arrayUnidades as $unidade => $value): ?>
                    {
                        label: <?php echo "\"$unidade\""?>,
                        backgroundColor: <?php echo "\"$arrayBackgroundColor[$unidade]\""; ?>,
                        data: [ <?php
                            // AMPLA CONCORRENCIA
                            $sql = "SELECT AVG(`media_global`) AS count
                                    FROM `$anoSelecionadoPOST`
                                    WHERE  `acao_afirmativa` NOT LIKE '%Renda%'
                                            AND `acao_afirmativa` NOT LIKE '%UFGInclui%'
                                            AND `ano_ingresso` <> '$anoSelecionadoPOST'
                                            AND `Regional` = '$unidade'";

                            echo consultaSimplesRetornaString($sql);

                            // L1 L2 L3 L4
                            foreach ($arrayRendas as $renda => $value) {
                                $sql = "SELECT AVG(`media_global`) AS count
                                        FROM `$anoSelecionadoPOST`
                                        WHERE `Regional` = '$unidade'
                                              and `ano_ingresso` <> '$anoSelecionadoPOST'
                                              and `acao_afirmativa` = '$renda'";

                                echo consultaSimplesRetornaString($sql);
                            }

                            // UFG inclui
                            $sql = "SELECT AVG(`media_global`) AS count
                                    FROM `$anoSelecionadoPOST`
                                    WHERE `acao_afirmativa` LIKE '%UFGInclui%'
                                           and `ano_ingresso` <> '$anoSelecionadoPOST'
                                           and `Regional` = '$unidade'";

                            $teste = consultaSimplesRetornaUmValor($sql);
                            echo $teste;
                        ?>
                        ]
                    },
                    <?php endforeach; ?>
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

<?php if (isset($_GET['tipo'])) : ?>
<script>
    $(document).ready(function () {
        $(".row").hide();
        // div bugada, deve ser mostrada só em contagem
        $(".hide").hide();
        $(<?php echo "\" .$tipo\""?>).show();
        if (<?php echo "\"$tipo\""?> == "contagem") {
            $(".hide").show();
        }
    });
</script>
<?php endif; ?>
<?php
    require_once 'includes/footer.php';
    ?>
