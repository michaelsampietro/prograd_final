<?php

function connect() {
  $host = 'localhost';
  $user = 'root';
  $pass = 'quiegh3A';
  $banco = 'prograd';

    $conecta = new mysqli($host, $user, $pass, $banco);
    if (!$conecta) {
      print ("Não foi possível fazer conexão ao bando de dados.");
      exit();
    }

    return $conecta;
}

// Função que faz o dropdown dos anos
function dropdownAnos () {
  
  $conn = connect();
  $tabelas = $conn->query('SHOW TABLES');
  
  $str = "";
  while ($tabela = $tabelas->fetch_array()) {
    $str = $str .  "<option value='" . $tabela[0] . "'>" . $tabela[0] . "</option><br>";
  }

  $conn->close();
  echo $str;
}

  function opcoes_grafico () {
    $str = "backgroundColor: [
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
                });";

    echo $str;
  }

	// Função geral para gerar gráficos. 
	// Parametros: 
	// $sql: string que define qual será a consulta sql
	// $array: array que contém os dados das legendas (regionais, graus academicos, etc)
	function graficoBarra ($array, $sql) {
		$conn = connect();
		$ano = htmlspecialchars($_POST['anos']);

        // Esse for each irá fazer a query que irá contar quantos estudantes cada unidade tem.
        // O resultado será salvo de maneira associativa em um array chamado regionais.
        // Outros dois arrays serao criados para passar os valores para o array principal.
        // Cada unidade receberá a contagem da quantidade de alunos que ela contém
        // Para fazer a contagem utilizei o parametro COUNT onde municipio = cidade da unidade
        foreach ($array as $key => $value) {
            $result = $conn->query($sql . "'". $key. "'");
            if(!$result)
                echo $conn->error;

            
            while($row = $result->fetch_assoc()) {
                $array[$key] = $row["count_est"];
            }
        }

        // Dando push no array para inserir o Total, que é a soma de todas as regionais
        array_push($array, array_sum($array));


        // Essa função será util para utilizar os valores retornados para gerar gráficos
        // Portanto, preciso retornar uma string que contenha apenas os números para usar
        // no parâmetro "data" da biblioteca chartJS.

        //String a ser retornada pelo programa
        $str = "";
        foreach ($array as $key => $value) {
		    $str .= "$value ,";
		}
		// Removendo a última vírgula do array
		$str = rtrim($str, ",");

 		$conn->close();
		echo ($str);
	}




?>