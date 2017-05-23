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
  $arrayLeiDeCotas = array(
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
  // O array abaixo inclui todas as categorias de acao afirmativa
  $arrayAcoesAfirmativas = array(
    // 'UFGInclui - Escola Pública' => 0,
    // 'UFGInclui - Negro Escola Pública' => 0,
    '(DC Renda Inferior)' => 0,
    '(PPI Renda Inferior)' => 0,
    '(DC Renda Superior)' => 0,
    '(PPI Renda Superior)' => 0,
    'UFGInclui - Indígena' => 0,
    'UFGInclui - Quilombola' => 0,
    'UFGInclui - Surdo' => 0,
  );

  // Pegando array de anos
  $sql = "SELECT distinct ano_ingresso FROM `$anoSelecionadoPOST` where ano_ingresso >= 2011 order by ano_ingresso asc";
  $arrayAnos = consultaSimplesRetornaArray($sql);
?>

<div class="row">
  <div class="col-sm-3 col-lg-2">
    <div class="sidebar-nav">
      <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="visible-xs navbar-brand">Menu</span>
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="./">Início</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categorias <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <!-- <li class="divider"></li> -->
                <li class="dropdown-header">Tipos de Gráficos</li>
                <li><a href="./handler_novo.php?anos=<?php echo $anoSelecionadoPOST ?>">Contagem</a></li>
                <li><a href="./porcentagem.php?anos=<?php echo $anoSelecionadoPOST ?>">Porcentagem</a></li>
                <li><a href="./media.php?anos=<?php echo $anoSelecionadoPOST ?>">Médias</a></li>
                <li><a href="#">Todos</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="col-sm-9 col-lg-10">

    <div class="row">
        <div class="panel panel-info">
          <div class="panel-heading">
            Teste
          </div>
          <div class="panel-body">
            <table class="table"
            data-toggle="table"
            data-show-export="true">
            <thead>
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
            </thead>
            <tbody>
                <?php foreach ($arrayUnidades as $unidade => $value) : ?>
                    <tr>
                        <td class="text-center"><?php echo $unidade; ?></td>

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
              </tbody>
              <tfoot>
                <!-- Linha TOTAL -->
                </tr>
                    <!-- Criação da última linha (TOTAL), referente à média das columas acima.
                    A estrutura é basicamente a mesma da inserção das estruturas, mas decidi separar para deixar o código um pouco mais legível. As queries continuam basicamente a mesma, a diferença é que é passado um vetor contendo todas as regionais para uma função que retorna a soma da consulta realizada em todas as regionais, obtendo assim o valor total desejado. -->
                    <tr>
                        <th class="text-center">Total</th>
                        <th>
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
                      </th>

                        <!-- Média geral do UFGInclui -->
                        <?php foreach ($arrayAcaoAfirmativa as $acao => $value) : ?>
                            <th>
                                <?php
                                $sql = "SELECT AVG(`media_global`) AS count
                                        FROM `$anoSelecionadoPOST`
                                        WHERE `acao_afirmativa` = '$acao'
                                               AND `ano_ingresso` <= 2012
                                               AND Regional = ";
                                echo consultaSimplesRetornaMediaAsString($arrayUnidades, $sql);
                                ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>


              </tfoot>
            </table>
            <h6> <small>* Para o curso de Letras: Libras da Regional Goiânia</small></h6>
          </div>
        </div>
    </div>

    <hr>

  </div>
</div>
<?php require_once('includes/footer.php'); ?>
