<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
  $ano = htmlspecialchars($_POST['anos']);

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

// Retorna uma consulta como um array

function consultaSimples($sql)
{
  $conn = connect();
  $ano = htmlspecialchars($_POST['anos']);
  if ($query = $conn->query($sql)) {
    $resultado = $query->fetch_all();
  }
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

  // String a ser retornada pelo programa

  $str = "";
  foreach($array as $key => $value) {

    // $value = preg_replace('/\./', ',', $value);

    $value = round($value, 2);
    $str.= "$value ,";
  }

  $conn->close();
  echo ($str);
}

function consultaSimplesRetornaSomaAsString($array, $sql)
{
  $conn = connect();
  $ano = htmlspecialchars($_POST['anos']);
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
  echo end($array);
}

?>