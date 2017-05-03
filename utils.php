<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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

function connect()
{
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

function dropdownAnos()
{
  $conn = connect();
  $tabelas = $conn->query('SHOW TABLES');

  // $tabelas = $conn->query("SELECT distinct(ano_ingresso) from `2016-1` order by ano_ingresso desc ");

  $str = "";
  while ($tabela = $tabelas->fetch_array()) {
    $str = $str . "<option value='" . $tabela[0] . "'>" . $tabela[0] . "</option><br />";
  }

  $conn->close();
  echo $str;
}

function opcoesGrafico()
{
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
                        options: {
                          responsive: true,
                          maintainAspectRatio: true,
                          scales: { yAxes: [{ ticks: { beginAtZero:true} }] } }

                    });";
  echo $str;
}

// Função geral para gerar gráficos.
// Parametros:
// $sql: string que define qual será a consulta sql
// $array: array que contém os dados das legendas (regionais, graus academicos, etc)

function chartData($array, $sql)
{
  $conn = connect();
  $ano = htmlspecialchars($_GET['anos']); // $ano = htmlspecialchars($_POST['anos']);

  // Esse for each irá fazer a query que irá contar quantos estudantes cada unidade tem.
  // O resultado será salvo de maneira associativa em um array chamado regionais.
  // Outros dois arrays serao criados para passar os valores para o array principal.
  // Cada unidade receberá a contagem da quantidade de alunos que ela contém
  // Para fazer a contagem utilizei o parametro COUNT onde municipio = cidade da unidade

  foreach($array as $key => $value) {
    $result = $conn->query($sql . "'" . $key . "'");
    if (!$result) echo $conn->error;
    while ($row = $result->fetch_assoc()) {
      $array[$key] = $row["count"];
    }
  }

  // Dando push no array para inserir o Total, que é a soma de todas as regionais

  array_push($array, array_sum($array));

  // Essa função será util para utilizar os valores retornados para gerar gráficos
  // Portanto, preciso retornar uma string que contenha apenas os números para usar
  // no parâmetro "data" da biblioteca chartJS.
  // String a ser retornada pelo programa

  $str = "";
  foreach($array as $key => $value) {
    $str.= "$value ,";
  }

  // Removendo a última vírgula do array

  $str = rtrim($str, ",");
  $conn->close();
  echo ($str);
}

function consultaSimplesRetornaArray($sql)
{

  // Conectando ao banco

  $conn = connect();
  $arrayResultados = array();

  // Realiza consulta e fetch todos os resultados na variável resultado

  if ($query = $conn->query($sql)) {
    $resultado = $query->fetch_all();
    foreach($resultado as $key => $value) {
      foreach($value as $key => $ano) {
        array_push($arrayResultados, $ano);
      }
    }
  }

  return $arrayResultados;
  $conn->close();
}

function consultaSimplesRetornaString($sql)
{
  // Conectando ao banco
  $conn = connect();

  $result = $conn->query($sql);
  if (!$result)
    echo $conn->error;

  $aux = 0;
  while ($row = $result->fetch_assoc()) {
    $array[$aux] = $row["count"];
    $aux++;
  }

  //String a ser retornada pelo programa
  $str = "";
  foreach($array as $key => $value) {

    $value = round($value, 2);
    $str.= "$value ,";
  }

  $conn->close();
  echo ($str);
}

function consultaSimplesRetornaString2($sql)
{
  // Conectando ao banco
  $conn = connect();

  $result = $conn->query($sql);
  if (!$result)
    echo $conn->error;

  $aux = 0;
  while ($row = $result->fetch_assoc()) {
    $array[$aux] = $row["count"];
    $aux++;
  }

  //String a ser retornada pelo programa
  $str = "";
  foreach($array as $key => $value) {

    $value = round($value, 2);
    $str.= "$value ,";
  }

  $conn->close();
  return $str;
}

function consultaSimplesRetornaSomaAsString($array, $sql)
{
  $conn = connect();
  $ano = htmlspecialchars($_GET['anos']); // $ano = htmlspecialchars($_POST['anos']);
  foreach($array as $key => $value) {
    $result = $conn->query($sql . "'" . $key . "'");
    if (!$result) echo $conn->error;
    while ($row = $result->fetch_assoc()) {
      $array[$key] = $row["count"];
    }
  }

  // Dando push no array para inserir o Total, que é a soma de todas as regionais
  array_push($array, array_sum($array));
  $conn->close();
  echo round(end($array), 2);
}

function consultaSimplesRetornaMediaAsString($array, $sql)
{
  $conn = connect();
  $ano = htmlspecialchars($_GET['anos']); // $ano = htmlspecialchars($_POST['anos']);
  foreach($array as $key => $value) {
    $result = $conn->query($sql . "'" . $key . "'");
    if (!$result) echo $conn->error;
    while ($row = $result->fetch_assoc()) {
      $array[$key] = $row["count"];
    }
  }

  // Calculando o tamanho "real" do array, retirando as posições com 0.
  $tamanhoArray = 0;
  foreach ($array as $key => $value) {
    if ($value != NULL)
      $tamanhoArray+=1;
  }

  // Dando push no array para inserir o Total, que é a média de todas as regionais
  array_push($array, array_sum($array)/$tamanhoArray);

  $conn->close();
  echo round(end($array), 2);
}

function consultaSimplesRetornaUmValor ($sql) {
  $conn = connect();

  $result = $conn->query($sql);
  if (!$result)
    echo $conn->error;

  $array;
  while ($row = $result->fetch_assoc()) {
    $array[0] = $row["count"];
  }

  $conn->close();
  echo round(end($array), 2);
}

function consultaSimplesRetornaUmValor2 ($sql) {
  $conn = connect();

  $result = $conn->query($sql);
  if (!$result)
    echo $conn->error;

  $array;
  while ($row = $result->fetch_assoc()) {
    $array[0] = $row["count"];
  }

  $conn->close();
  return round(end($array), 2);
}

?>
