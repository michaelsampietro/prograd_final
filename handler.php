<?php 
    require_once 'utils.php';
    require_once 'includes/header.php';
    
    $ano = htmlspecialchars($_POST['anos']);
    ?>
<?php 
    $arrayUnidades = array('Goiânia' => 0,'Jataí' => 0,'Catalão' => 0,'Goiás' => 0);
    $arrayGrauAcademico = array('BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
    ?>
<div class="container">
    <div class="row">
        <div>
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por regional</h3>
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
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE municipio=";
                    chartData($arrayUnidades, $sql); ?>],
                    <?php opcoesGrafico(); ?>;
            </script>
        </div>
    </div>
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
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE grau_academico=";
                    chartData($arrayGrauAcademico, $sql); ?>],
                    <?php opcoesGrafico(); ?>;
            </script>
        </div>
    </div>
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
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Catalao' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql); ?>],
                    <?php opcoesGrafico(); ?>;
            </script>
        </div>
    </div>
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
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Goiania' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql); ?>],
                    <?php opcoesGrafico(); ?>;
            </script>
        </div>
    </div>
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
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Goias' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql); ?>],
                    <?php opcoesGrafico(); ?>;
            </script>
        </div>
    </div>
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
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Jatai' and grau_academico=";
                    chartData($arrayGrauAcademico, $sql); ?>],
                    <?php opcoesGrafico(); ?>;
            </script>
        </div>
    </div>
    <!-- Gráfico de linhas múltiplas --> 
    <div class="row">
        <h2 align="middle">Numero de Crusos/Hbilitações por Regional - de 2005 a <?php echo $anos; ?></h2>
        <div id="line_chart" style="width: 1100px; height: 500px"></div>
    </div>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            
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
            [<?php 
            $sql = "SELECT COUNT(distinct curso) AS count_est FROM `$ano` WHERE municipio=";
            echo "'$ano',";
            chartData($arrayUnidades, $sql); ?> ]]);
            
        
          var options = {
            legend: { position: 'bottom' }
          };
        
          var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        
          chart.draw(data, options); 
        } 
    </script>
    <!-- Tabela com o número de vagas ofertadas por regional -->
    <div class="row">
    <h2>Número de Vagas Ofertadas por Regional</h2>
    <table class="table" style="width: 900px;">
        <tr>
            <th class="tg-yw4l"><br></th>
            <th class="tg-yw4l">2005</th>
            <th class="tg-yw4l">2006</th>
            <th class="tg-yw4l">2007</th>
            <th class="tg-yw4l">2008</th>
            <th class="tg-yw4l">2009</th>
            <th class="tg-yw4l">2010</th>
            <th class="tg-yw4l">2011</th>
            <th class="tg-yw4l">2012</th>
            <th class="tg-yw4l">2013</th>
            <th class="tg-yw4l">2014</th>
            <th class="tg-yw4l">2015</th>
        </tr>
        <tr>
            <td class="tg-yw4l">Goiânia</td>
            <td class="tg-yw4l">2318</td>
            <td class="tg-yw4l">2508</td>
            <td class="tg-yw4l">2548</td>
            <td class="tg-yw4l">2523</td>
            <td class="tg-yw4l">3786</td>
            <td class="tg-yw4l">4046</td>
            <td class="tg-yw4l">4065</td>
            <td class="tg-yw4l">4045</td>
            <td class="tg-yw4l">4135</td>
            <td class="tg-yw4l">4325</td>
            <td class="tg-yw4l">4265</td>
        </tr>
        <tr>
            <td class="tg-yw4l">Jataí</td>
            <td class="tg-yw4l">360</td>
            <td class="tg-yw4l">550</td>
            <td class="tg-yw4l">610</td>
            <td class="tg-yw4l">705</td>
            <td class="tg-yw4l">880</td>
            <td class="tg-yw4l">980</td>
            <td class="tg-yw4l">980</td>
            <td class="tg-yw4l">1020</td>
            <td class="tg-yw4l">1020</td>
            <td class="tg-yw4l">1050</td>
            <td class="tg-yw4l">1080</td>
        </tr>
        <tr>
            <td class="tg-yw4l">Catalão</td>
            <td class="tg-yw4l">300</td>
            <td class="tg-yw4l">500</td>
            <td class="tg-yw4l">590</td>
            <td class="tg-yw4l">710</td>
            <td class="tg-yw4l">950</td>
            <td class="tg-yw4l">970</td>
            <td class="tg-yw4l">980</td>
            <td class="tg-yw4l">980</td>
            <td class="tg-yw4l">990</td>
            <td class="tg-yw4l">1110</td>
            <td class="tg-yw4l">1110</td>
        </tr>
        <tr>
            <td class="tg-yw4l">Goiás</td>
            <td class="tg-yw4l">60</td>
            <td class="tg-yw4l">60</td>
            <td class="tg-yw4l">60</td>
            <td class="tg-yw4l">160</td>
            <td class="tg-yw4l">160</td>
            <td class="tg-yw4l">160</td>
            <td class="tg-yw4l">160</td>
            <td class="tg-yw4l">160</td>
            <td class="tg-yw4l">210</td>
            <td class="tg-yw4l">380</td>
            <td class="tg-yw4l">470</td>
        </tr>
        <tr>
            <td class="tg-yw4l">Total</td>
            <td class="tg-yw4l">3038</td>
            <td class="tg-yw4l">3618</td>
            <td class="tg-yw4l">3808</td>
            <td class="tg-yw4l">3998</td>
            <td class="tg-yw4l">5776</td>
            <td class="tg-yw4l">6156</td>
            <td class="tg-yw4l">6185</td>
            <td class="tg-yw4l">6205</td>
            <td class="tg-yw4l">6355</td>
            <td class="tg-yw4l">6865</td>
            <td class="tg-yw4l">6925</td>
        </tr>
    </table>
    </div>
</div>
<?php
    require_once 'includes/footer.php';
    ?>