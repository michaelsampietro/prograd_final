<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
require_once 'utils.php';
require_once 'includes/header.php';

$anoSelecionadoPOST = htmlspecialchars($_POST['anos']);
?>

<?php
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
?>

<div class="container">
    <!-- Gráfico com o numero de estudantes matriculados em abril de 2016 por regional -->
    <div class="row">
        <div>
            <h3 align="middle">Número de estudantes matriculados em abril de <?php echo $anoSelecionadoPOST ?> por regional</h3>
            <canvas id="myChart" style="width: 900px; height: 500px"></canvas>
            <script>
                var ctx = document.getElementById("myChart");
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
    </div>

    <!-- Grafico com o Número de estudantes matriculados em abril de 2016 por grau acadêmico -->
    <div class='row'>
        <div >
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por grau acadêmico</h3>
            <canvas id="myChart2" style="width: 1100px; height: 500px"></canvas>
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
    </div>

    <!-- Grafico com o Número de estudantes matriculados em abril de 2016 por grau acadêmico na regional Catalão-->
    <?php  
    $aux = 0;
    foreach ($arrayUnidades as $unidade => $value): ?>
    <div class='row'>
        <div>
            <h3 align="middle">Número de estudantes matriculados em abril de <?php echo $anoSelecionadoPOST; ?> por grau acadêmico na regional <?php echo $unidade; ?></h3>
            <canvas id="numeroEstudantesMatriculados<?php echo $aux;?>" style="width: 1100px; height: 500px"></canvas>
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
    </div>
    <?php $aux++; endforeach; ?>

    <!-- Gráfico de linhas múltiplas --> 
    <div class="row">
        <h2 align="middle">Numero de Crusos/Hbilitações por Regional - de 2005 a <?php
            echo $anoSelecionadoPOST;
            ?></h2>
        <div id="line_chart" style="width: 100%; height: 500px;"></div>
    </div>
    <!-- Script para o gráfico de linhas múltiplas --> 
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            // Desenha o gráfico de linhas múltiplas correspondente ao número de cursos por regional.
            var data = google.visualization.arrayToDataTable([
            ["Anos", 'Goiânia', 'Jataí ', 'Catalão', 'Goiás', 'Total'],
            ["2005",  58,   11,        9,        1,      79  ],
            ["2006",  63,   15,        14,       1,      93  ],
            ["2007",  66,   18,        16,       1,      101 ],
            ['2008',  66,   20,        19,       1,      106 ],
            ['2009',  81,   21,        24,       3,      129 ],
            ['2010',  85,   23,        25,       3,      136 ],
            ['2011',  86,   23,        25,       3,      137 ],
            ['2012',  86,   24,        25,       3,      138 ],
            ['2013',  89,   24,        25,       5,      143 ],
            ['2014',  90,   25,        26,       6,      147 ],
            ['2015',  90,   25,        26,       7,      148 ],
            
            <?php
            $sql = "SHOW TABLES";
            $arrayAnos = consultaSimplesRetornaArray ($sql);

            foreach ($arrayAnos as $key => $ano) {
                if ($ano <= $anoSelecionadoPOST) { 
                $sql = "SELECT COUNT(distinct curso) AS count FROM `$ano` WHERE regional=";
                echo "['$ano',";
                chartData($arrayUnidades, $sql);
                    echo "],\n";
                }
            } 
            ?> ]);

          var options = {
            legend: { position: 'bottom' }
          };
        
          var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        
          chart.draw(data, options);  
      }
    </script>

    <!-- Tabela com o número de vagas ofertadas por regional -->
    <div class="row table-responsive"">
        <h2 class="text-center">Número de Vagas Ofertadas por Regional</h2>
        <table id="tabelaVagasRegional" class="table" style="width: 900px;">
            <tr>
                <th><br></th>
                <th>2005</th>
                <th>2006</th>
                <th>2007</th>
                <th>2008</th>
                <th>2009</th>
                <th>2010</th>
                <th>2011</th>
                <th>2012</th>
                <th>2013</th>
                <th>2014</th>
                <th>2015</th>
            </tr>
            <tr>
                <td>Goiânia</td>
                <td>2318</td>
                <td>2508</td>
                <td>2548</td>
                <td>2523</td>
                <td>3786</td>
                <td>4046</td>
                <td>4065</td>
                <td>4045</td>
                <td>4135</td>
                <td>4325</td>
                <td>4265</td>
            </tr>
            <tr>
                <td>Jataí</td>
                <td>360</td>
                <td>550</td>
                <td>610</td>
                <td>705</td>
                <td>880</td>
                <td>980</td>
                <td>980</td>
                <td>1020</td>
                <td>1020</td>
                <td>1050</td>
                <td>1080</td>
            </tr>
            <tr>
                <td>Catalão</td>
                <td>300</td>
                <td>500</td>
                <td>590</td>
                <td>710</td>
                <td>950</td>
                <td>970</td>
                <td>980</td>
                <td>980</td>
                <td>990</td>
                <td>1110</td>
                <td>1110</td>
            </tr>
            <tr>
                <td>Goiás</td>
                <td>60</td>
                <td>60</td>
                <td>60</td>
                <td>160</td>
                <td>160</td>
                <td>160</td>
                <td>160</td>
                <td>160</td>
                <td>210</td>
                <td>380</td>
                <td>470</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>3038</td>
                <td>3618</td>
                <td>3808</td>
                <td>3998</td>
                <td>5776</td>
                <td>6156</td>
                <td>6185</td>
                <td>6205</td>
                <td>6355</td>
                <td>6865</td>
                <td>6925</td>
            </tr>
        </table>
    </div>
    <!-- Script para a tabela com o numero de vagas ofertadas por regional -->
    <script type="text/javascript">
    // Faz a consulta dos dados no banco e insere na tabela vagasRegional
    function insereTabelaVagasRegional() {

        var tamanhoTabela = document.getElementById("tabelaVagasRegional").rows.length;
        var vetorDados = [
            <?php
                /* Faz pesquisa e retorna um array com ano e qtd de vagas. */
                $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso = " . $anoSelecionadoPOST . " and municipio=";
                echo "'$anoSelecionadoPOST',";
                chartData($arrayUnidades, $sql);
                ?>];

        for (var i = 0; i < tamanhoTabela; i++) {
            // inserir o html na tabela.
            if (i === 0) {
                // se for a primeira posição, então insere um th (será o ano)
                document.getElementById("tabelaVagasRegional").rows[i].insertAdjacentHTML('beforeend', "<th>" + vetorDados[i] + "</th>");
            } else {
                // senão, insere um td normal.
                document.getElementById("tabelaVagasRegional").rows[i].insertAdjacentHTML('beforeend', "<td>" + vetorDados[i] + "</td>");
            }

        }
    }
</script>

    <!-- Número de vagas por Regional gráfico de linhas múltiplas -->
     <div class="row">
        <h2 align="middle">Número de Vagas Ofertadas de 2005 a <?php
            echo $anoSelecionadoPOST;
            ?> por Regional</h2>
        <div id="numVagasRegional" style="width: 1100px; height: 500px"></div>
    </div>
    <!-- Script para o gráfico de linhas múltiplas --> 
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            // Desenha o gráfico de linhas múltiplas correspondente ao número de cursos por regional.
            var data = google.visualization.arrayToDataTable([
            ["Anos", 'Goiânia', 'Jataí ', 'Catalão', 'Goiás', 'Total'],
            ["2005",  2318,   360,        300,       60,      3038  ],
            ["2006",  2508,   550,        500,       60,      3618  ],
            ["2007",  2548,   610,        590,       60,      3808 ],
            ['2008',  2523,   705,        710,       60,      3998 ],
            ['2009',  3786,   880,        950,       160,     5776 ],
            ['2010',  4046,   980,        970,       160,     6156 ],
            ['2011',  4065,   980,        980,       160,     6185 ],
            ['2012',  4045,   1020,       980,       160,     6205 ],
            ['2013',  4135,   1020,       990,       210,     6355 ],
            ['2014',  4325,   1050,       1110,      380,     6865 ],
            ['2015',  4264,   1080,       1110,      470,     6925 ],
            
            <?php
            $sql = "SHOW TABLES";
            $arrayAnos = consultaSimplesRetornaArray ($sql);

            foreach ($arrayAnos as $key => $ano) {
                if ($ano <= $anoSelecionadoPOST) {
                $sql = "SELECT COUNT(Estudante) AS count FROM `$ano` WHERE ano_ingresso = $ano and regional=";
                echo "['$ano',";
                chartData($arrayUnidades, $sql);
                    echo "],\n";
                }
            }
            ?> ]);

          var options = {
            legend: { position: 'bottom' }
          };
        
          var chart = new google.visualization.LineChart(document.getElementById('numVagasRegional'));
        
          chart.draw(data, options);
      }
    </script>


    <!-- Gráfico com o ano de ingresso dos estudantes matriculados -->
    <div class='row'>
        <div>
            <h3 align="middle">NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016
                POR GRAU ACADÊMICO NA REGIONAL JATAÍ
            </h3>
            <canvas id="myChart7" style="width: 1100px; height: 500px"></canvas>
        </div>
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
                {
                    label: "Goiânia",
                    backgroundColor: 'rgba(54, 162, 235, .7)',
                    data: [<?php 
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = 'Goiania'";
                    echo $res = consultaSimplesRetornaString($sql);
                    foreach ($arrayAnos as $key => $ano) {
                        $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso = " . $ano . " and Regional = 'Goiania' ";
                        
                        echo $res = consultaSimplesRetornaString($sql);
                        
                    }
                ?>]
                },
                {
                    label: "Jataí",
                    backgroundColor: "rgba(184, 18, 0, 0.7)",
                    data: [<?php 
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = 'Jataí'";
                    echo $res = consultaSimplesRetornaString($sql);
                    foreach ($arrayAnos as $key => $ano) {
                        $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso = " . $ano . " and Regional = 'Jataí' ";
                        
                        echo $res = consultaSimplesRetornaString($sql);
                        
                    }
                ?>]
                },
                {
                    label: "Catalão",
                    backgroundColor: "rgba(0, 66, 10, 0.7)",
                    data: [<?php 
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = 'Catalão'";
                    echo $res = consultaSimplesRetornaString($sql);
                    foreach ($arrayAnos as $key => $ano) {
                        $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso = " . $ano . " and Regional = 'Catalão' ";
                        
                        echo $res = consultaSimplesRetornaString($sql);
                        
                    }
                ?>]
                },
                {
                    label: "Goiás",
                    backgroundColor: "rgba(209, 206, 0, 0.7)",
                    data: [<?php 
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso > 2004 and ano_ingresso < 2011 and Regional = 'Goiás'";
                    echo $res = consultaSimplesRetornaString($sql);
                    foreach ($arrayAnos as $key => $ano) {
                        $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE ano_ingresso = " . $ano . " and Regional = 'Goiás' ";
                        
                        echo $res = consultaSimplesRetornaString($sql);
                        
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

    <!-- Gráfico número de estudantes por sexo e regional -->
    <div class='row'>
        <div>
            <h3 class="text-center">Gráfico número de estudantes por sexo e regional
            </h3>
            <canvas id="myChart8" style="width: 1100px; height: 500px"></canvas>
        </div>
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
                $sql = "SELECT count(*) * 100.0 / ( SELECT COUNT(Estudante) FROM `2016-1` ) AS count FROM `2016-1` WHERE sexo = 'feminino'";
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
                $sql = "SELECT count(*) * 100.0 / ( SELECT COUNT(Estudante) FROM `2016-1` ) AS count FROM `2016-1` WHERE sexo = 'masculino'";
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
    <div class='row'>
        <div>
            <h3 class="text-center">Porcentagem de estudantes por faixa etária matriculados em abril de <?php echo $anoSelecionadoPOST; ?>
            </h3>
            <canvas id="myChart9" style="width: 1100px; height: 500px"></canvas>
        </div>
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
        <div>
            <h3 class="text-center">Porcentagem de estudantes por faixa etária matriculados em abril de <?php echo $anoSelecionadoPOST; ?> na regional <?php echo $unidade; ?>
            </h3>
            <canvas id="chartAnosRegional<?php echo $unidade; ?>" style="width: 1100px; height: 500px"></canvas>
        </div>
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
        <div>
            <h3 class="text-center">Gráfico com porcentagem da media global dos alunos por intervalo <?php echo $anoSelecionadoPOST; ?>
            </h3>
            <canvas id="chartPorcentagemMediaGlobalGeral" style="width: 1100px; height: 500px"></canvas>
        </div>
    </div>
    <script type="text/javascript">
    var ctx = document.getElementById("chartPorcentagemMediaGlobalGeral");

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
                    for ($i=0; $i <= 10; $i++) {
                        switch ($i) {
                            case 1:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 0 and `media_global` <= 1";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 2:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 1 and `media_global` <= 2";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 3:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 2 and `media_global` <= 3";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 4:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 3 and `media_global` <= 4";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 5:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 4 and `media_global` <= 5";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 6:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 5 and `media_global` <= 6";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 7:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 6 and `media_global` <= 7";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 8:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 7 and `media_global` <= 8";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 9:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 8 and `media_global` <= 9";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            case 10:
                                $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST`) * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `media_global` > 9 and `media_global` <= 10";
                                echo $res = consultaSimplesRetornaString($sql);
                                break;
                            default:
                                break;
                        }
                    }
                ?>]
    }]};

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

    <!-- Tabela com a faix das médias globais usadas nos gráficos -->
    <h3 class="text-center">Faixas das médias globais usadas nas próximas tabelas</h3>
    <table class="table table-responsive text-center col-xs-6">
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

 <!-- Gráfico com porcentagem da media global dos alunos POR REGIONAL-->
    <?php
        foreach ($arrayUnidades as $unidade => $value): ?>
            <div class='row'>
            <div>
                <h3 class="text-center">Gráfico com porcentagem da media global dos alunos por intervalo <?php echo $anoSelecionadoPOST; ?> na regional <?php echo $unidade; ?>
                </h3>
                <canvas id="chartPorcentagemMediaGlobalUnidade<?php echo $unidade; ?>" style="width: 1100px; height: 500px"></canvas>
            </div>
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
                        for ($i=0; $i <= 10; $i++) {
                            switch ($i) {
                                case 1:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 0 and `media_global` <= 1";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 2:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 1 and `media_global` <= 2";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 3:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 2 and `media_global` <= 3";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 4:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 3 and `media_global` <= 4";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 5:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 4 and `media_global` <= 5";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 6:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 5 and `media_global` <= 6";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 7:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 6 and `media_global` <= 7";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 8:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 7 and `media_global` <= 8";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 9:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 8 and `media_global` <= 9";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                case 10:
                                    $sql = "SELECT COUNT(*) / (SELECT COUNT(*) FROM `$anoSelecionadoPOST` where `Regional` = '$unidade') * 100.0 AS count FROM `$anoSelecionadoPOST` WHERE `Regional` = '$unidade' AND `media_global` > 9 and `media_global` <= 10";
                                    echo $res = consultaSimplesRetornaString($sql);
                                    break;
                                default:
                                    break;
                            }
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

    <!-- Gráfico do número de estudantes c/ ação afirmativa , que ingressaram até 2012 -->
    <div class="row">
        <div>
            <h3 align="middle">Número De Estudantes Matriculados Em Abril De 2016 Por Ação Afirmativa Na Ufg Com Ingresso Até 2012 (Anterior a Lei De Cotas)</h3>
            <canvas id="myChart10" style="width: 900px; height: 500px"></canvas>
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
    </div>


    <!-- Gráfico DA PORCENTAGEM de estudantes c/ ação afirmativa , que ingressaram até 2012 -->
    <div class="row">
        <div>
            <h3 align="middle">Porcentagem De Estudantes Matriculados Em Abril De 2016 Por Ação Afirmativa Na Ufg Com Ingresso Até 2012 (Anterior a Lei De Cotas)</h3>
            <canvas id="myChart11" style="width: 900px; height: 500px"></canvas>
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
    </div>

    <!-- Tabela acao afirmativa -->
    <div class="row">
        <table class="table table-responsive text-center">
            <tr>
                <th rowspan="2">Regional</th>
                <th colspan="5">Lei de Cotas</th>
                <th colspan="3">Programa UFGInclui 2013 a 2015</th>
            </tr>
            <tr>
                <td>AC</td>
                <td>L1<br>(Baixa renda)</td>
                <td>L2<br>(Baixa Renda PPI)</td>
                <td>L3<br>(Independente da Renda</td>
                <td>L4<br>(Independente da renda PPI)</td>
                <td>Vagas Extra para Indígena</td>
                <td>Vaga Extra para Quilombola</td>
                <td>Reserva de 15 vagas para Surdo</td>
            </tr>
            <?php
            foreach ($arrayUnidades as $unidade => $value) : ?>
            <tr>
                <td><?php echo $unidade; ?></td>
                <?php
                echo "<td>";
                // Consulta de Ampla Concorrencia
                $sql = "SELECT count(*) AS count FROM `$anoSelecionadoPOST` WHERE Regional = '$unidade' and `acao_afirmativa` <> '(PPI Renda Superior)' and `acao_afirmativa` <> '(PPI Renda Inferior)' and `acao_afirmativa` <> '(DC Renda Superior)' and `acao_afirmativa` <> '(DC Renda Inferior)' and `ano_ingresso` >= 2013";
                echo consultaSimplesRetornaUmValor($sql);
                echo "</td>";

                // Consulta L1 (DC Renda Inferior)
                echo "<td>";
                $sql = "SELECT count(*) AS count FROM `2016-1` WHERE Regional = '$unidade' and `acao_afirmativa` = '(DC Renda Inferior)' and `ano_ingresso` >= 2013";
                echo consultaSimplesRetornaUmValor($sql);
                echo "</td>";
                ?>
                

            </tr>
            <?php endforeach; ?>
        </table>
    </div>

<!-- On Page Load script -->
<script type="text/javascript">
    
function onPageLoad() {
    drawChart();
    insereTabelaVagasRegional();
}   
</script>
</div>
<?php
    require_once 'includes/footer.php';
    ?>