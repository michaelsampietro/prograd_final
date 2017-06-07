<?php header('Content-Type: text/html; charset=utf-8'); ?>


<!-- Array com todas as páginas principais
Será usado para gerar o menu lateral dinamicamente. -->
<?php

$pages = array();
$pages["index.php"] = "Início";
$pages["handler.php"] = "Contagem";
$pages["porcentagem.php"] = "Porcentagem";
$pages["media.php"] = "Médias";

$activePage = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Início - Página de Relatórios da UFG</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">

		<meta property="creator.productor" content="http://estruturaorganizacional.dados.gov.br/id/unidade-organizacional/14">

	  	<!-- Arquivos CSS -->
	  <link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" type="text/css" href="styles/navbar-left.css">
		<link rel="stylesheet" type="text/css" href="styles/tipos_graficos.css">
		<link rel="stylesheet" type="text/css" href="styles/login_modal.css">
		<link rel="stylesheet" type="text/css" href="styles/footers.css">
		<!-- <link rel="stylesheet" type="text/css" href="styles/login.css"> -->
		<link rel="stylesheet" type="text/css" media="print" href="styles/print.css">
		<!-- <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css"> -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<link rel="stylesheet" href="./lib/table/css/bootstrap-table.css">

		<script src="./charts/Chart.js"></script>
  	<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js" charset="utf-8"></script>
		<script src="lib/bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <!-- Bootstrap jQuery-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> <!-- Bootstrap -->
		<script src="./lib/table/js/bootstrap-table.js" charset="utf-8"></script>
		<script src="./lib/table/js/bootstrap-table-export.js" charset="utf-8"></script>
		<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css"> bootstrap-table -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.js"></script> <!-- bootstrap-table -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/locale/bootstrap-table-pt-BR.min.js"></script> <!-- bootstrap-table -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/extensions/export/bootstrap-table-export.min.js"></script>
		<script src="./bower_components/jspdf-autotable/examples/libs/jspdf.min.js" charset="utf-8"></script>
		<script src="./bower_components/tableExport.jquery.plugin/tableExport.min.js" charset="utf-8"></script>
		<script src="./bower_components/jspdf-autotable/dist/jspdf.plugin.autotable.js" charset="utf-8"></script>
		<script src="./bower_components/html2canvas/build/html2canvas.min.js" charset="utf-8"></script>

		<!-- Barra brasil -->
		<script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>

		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.5/js/tableexport.min.js" charset="utf-8"></script> -->


		<!-- Loading btn -->
		<!-- <script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script> -->

		<!-- <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" charset="utf-8"></script>
		<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js" charset="utf-8"></script>
		<script src="http://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js" charset="utf-8"></script>
		<script src="cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js" charset="utf-8"></script>
		<script src="cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" charset="utf-8"></script>
		<script src="cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js" charset="utf-8"></script>
		<script src="cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js" charset="utf-8"></script>
		<script src="cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js" charset="utf-8"></script>
		<script src="../lib/table/extensions/table-contextmenu/bootstrap-table-contextmenu.js" charset="utf-8"></script> -->
	</head>

	<body class="" onload="onPageLoad();">
		<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;">
			<ul id="menu-barra-temp" style="list-style:none;">
				<li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED"><a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a></li>
				<li><a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a></li>
			</ul>
		</div>


		  <nav id="navbar-topo" class="navbar navbar-default">
				<div class="container">
					<div class="container-fluid">
						<div class="nav-header">
							<div class="row">
								<div class="col-sm-5">
									<div class="row" style="margin-top: -12px;">
										<div class="imagem-navbar-topo col-xs-6">
											<a class="navbar-brand" target="_blank" href="https://www.prograd.ufg.br/">
												<img alt="Prograd - Pró-Reitoria de Graduação" id="prograd" src="./images/prograd_logo.svg" class="img img-responsive">
											</a>
										</div>
										<div class="imagem-navbar-topo col-xs-6">
											<a class="navbar-brand" target="_blank" href="https://www.ufg.br/">
												<img alt="UFG - Universidade Federal de Goiás" id="ufg" class="img img-responsive" src="./images/ufg_logo.png">
											</a>
									</div>
								</div>
							</div>
							<div class="navbar-right">
								<select id="sistemas-ufg" name="sistemas-ufg">
									<option value="http://ufgnet.ufg.br">Portal UFGNet</option>
									<option value="http://mail.ufg.br">Webmail</option>
									<option value="https://sigaa.sistemas.ufg.br">Matrícula</option>
									<option value="http://sistemas.ufg.br/CONCURSOS_WEB/">Concursos</option>
									<option value="http://portalsig.ufg.br">Portal SIG</option>
								</select>
							</div>
						</div>
					</div>
				</div>
		  </nav>
