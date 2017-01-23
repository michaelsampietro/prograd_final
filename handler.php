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
    <div class='row'>
        <div>
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por grau acadêmico na regional Catalão</h3>
            <canvas id="myChart3" style="width: 1100px; height: 500px"></canvas>
            <script>
                var ctx = document.getElementById("myChart3");
                var myChart3 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE Regional='Catalao' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql);
                    ?>],
                    <?php
                    opcoesGrafico();
                    ?>;
            </script>
        </div>
    </div>

    <!-- NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016 POR GRAU ACADÊMICO NA REGIONAL GOIÂNIA -->
    <div class='row'>
        <div>
            <h3 align="middle">NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016
                POR GRAU ACADÊMICO NA REGIONAL GOIÂNIA
            </h3>
            <canvas id="myChart4" style="width: 1100px; height: 500px"></canvas>
            <script>
                var ctx = document.getElementById("myChart4");
                var myChart4 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE Regional='Goiania' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql);
                    ?>],
                    <?php
                    opcoesGrafico();
                    ?>;
            </script>
        </div>
    </div>

    <!-- NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016 POR GRAU ACADÊMICO NA REGIONAL GOIAS -->
    <div class='row'>
        <div>
            <h3 align="middle">NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016
                POR GRAU ACADÊMICO NA REGIONAL GOIAS
            </h3>
            <canvas id="myChart5" style="width: 1100px; height: 500px"></canvas>
            <script>
                var ctx = document.getElementById("myChart5");
                var myChart5 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE Regional='Goias' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql);
                    ?>],
                    <?php
                    opcoesGrafico();
                    ?>;
            </script>
        </div>
    </div>

    <!-- NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016 POR GRAU ACADÊMICO NA REGIONAL JATAÍ -->
    <div class='row'>
        <div>
            <h3 align="middle">NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016
                POR GRAU ACADÊMICO NA REGIONAL JATAÍ
            </h3>
            <canvas id="myChart6" style="width: 1100px; height: 500px"></canvas>
            <script>
                var ctx = document.getElementById("myChart6");
                var myChart6 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $sql = "SELECT COUNT(Estudante) AS count FROM `$anoSelecionadoPOST` WHERE Regional='Jatai' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql);
                    ?>],
                    <?php
                    opcoesGrafico();
                    ?>;
            </script>
        </div>
    </div>


    <!-- Gráfico de linhas múltiplas --> 
    <div class="row">
        <h2 align="middle">Numero de Crusos/Hbilitações por Regional - de 2005 a <?php
            echo $anoSelecionadoPOST;
            ?></h2>
        <div id="line_chart" style="width: 1100px; height: 500px"></div>
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
                $sql = "SELECT COUNT(distinct curso) AS count FROM `$ano` WHERE regional=";
                echo "['$ano',";
                chartData($arrayUnidades, $sql);
                if ($ano < $anoSelecionadoPOST)
                    echo "],\n";
                else 
                    echo "]";
            } 
            ?> ]);

          var options = {
            legend: { position: 'bottom' }
          };
        
          var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        
          chart.draw(data, options);  
      }
    </script>

    
<?php 
    
    ?> 










    <!-- Tabela com o número de vagas ofertadas por regional -->
    <div class="row"">
        <h2>Número de Vagas Ofertadas por Regional</h2>
        <table id="tabelaVagasRegional" class="table" style="width: 900px; align-self: middle;" >
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
                $sql = "SELECT COUNT(distinct curso) AS count FROM `$anoSelecionadoPOST` WHERE municipio=";
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