<?php 
    require_once 'utils.php';
    require_once 'includes/header.php';
    
    $ano = htmlspecialchars($_POST['anos']);
    ?>
<!-- Estrutura básica da biblioteca de Chart JS para criar um gráfico -->
<div class="container">
    <div class="row">
        <div class="grafico col-md-6 col-xs-5">
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por regional</h3>
            <canvas id="myChart" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Jataí", "Goiânia", "Goiás", "Catalão", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'Jatai' => 0,'Goiânia' => 0,'Goiás' => 0,'Catalão' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE municipio='";
                    grafico_1($array, $sql); ?>],
                            backgroundColor: [
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)'
                            ],
                            borderColor: [
                                'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            </script>
        </div>
        <div class="grafico col-md-6">
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por regional</h3>
            <canvas id="myChart2" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart2");
                var myChart2 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE grau_academico=";
                    grafico_1($array, $sql); ?>],
                            backgroundColor: [
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)'
                            ],
                            borderColor: [
                                'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: { scales: { yAxes: [{ ticks: { beginAtZero:true} }] } }
                });
            </script>
        </div>
        <!-- end of chart -->
    </div>
    <!-- end of row -->
    <!-- new row -->
    <!-- Grafico referente ao
    	NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016 POR GRAU ACADÊMICO NA REGIONAL CATALÃO -->
    <div class='row'>
        <div class="grafico col-md-6">
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por grau acadêmico na regional Catalão</h3>
            <canvas id="myChart3" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart3");
                var myChart3 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
                    graficoTeste($array, $sql); ?>],
                            backgroundColor: [
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)',
                            	'rgba(54, 162, 235, .7)'
                            ],
                            borderColor: [
                                'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)',
                            	'rgba(0, 0, 0, .5)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: { scales: { yAxes: [{ ticks: { beginAtZero:true} }] } }
                });
            </script>
        </div>
        <!-- end of chart -->
    </div>
</div>

<?php
    require_once 'includes/footer.php';
    ?>

