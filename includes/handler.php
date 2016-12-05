<?php 
	require_once 'utils.php';
	require_once 'includes/header.php';

	function graficoTeste () {
		$conn = connect();
		$ano = htmlspecialchars($_POST['anos']);

        $regionais = array( 'Jataí' => 0,
                            'Goiânia' => 0,
                            'Goiás' => 0,
                            'Catalão' => 0);

        foreach ($regionais as $cidade => $qtdAlunos) {
            $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE municipio='$cidade'";
            $result = $conn->query($sql);
            if(!$result)
                echo $conn->error;
            
            while($row = $result->fetch_assoc()) {
                $regionais[$cidade] = $row["count_est"];
            }
        }

        array_push($regionais, array_sum($regionais));

        /*$str = "";
        foreach ($regionais as $cidade => $qtdAlunos) {
            $str = $qtdAlunos 
        }*/

	  $conn->close();
	}
?>

<div class="container">
			<div class="row">
				<div class="grafico col-md-6">
					<canvas id="myChart" width="auto" height="auto"></canvas>
					<script>
					var ctx = document.getElementById("myChart");
					var myChart = new Chart(ctx, {
					    type: 'bar',
					    data: {
					        labels: ["Jataí", "Goiânia", "Goiás", "Catalão", "Total"],
					        datasets: [{
					            label: '# of Votes',
					            data: [10, 10, 10, 10, 10] ,
					            backgroundColor: [
					                'rgba(255, 99, 132, .9)',
					                'rgba(54, 162, 235, .9)',
					                'rgba(255, 206, 86, .9)',
					                'rgba(75, 192, 192, .9)',
					                'rgba(153, 102, 255, .9)'
					            ],
					            borderColor: [
					                'rgba(255,99,132,1)',
					                'rgba(54, 162, 235, 1)',
					                'rgba(255, 206, 86, 1)',
					                'rgba(75, 192, 192, 1)',
					                'rgba(153, 102, 255, 1)'
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
				</div>
				</div>


<?php
    require_once 'includes/footer.php';
?>