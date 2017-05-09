<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bootstrap Example</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  	<!-- Arquivos CSS -->
	  <link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" type="text/css" href="styles/tipos_graficos.css">
		<link rel="stylesheet" type="text/css" href="styles/login_modal.css">
		<link rel="stylesheet" type="text/css" href="styles/login.css">
		<link rel="stylesheet" type="text/css" media="print" href="styles/print.css">
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  	<script src="charts/Chart.js"></script>
  	<script src="https://code.highcharts.com/highcharts.src.js"></script>
		<script src="lib/bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <!-- Bootstrap jQuery-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> <!-- Bootstrap -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css"> <!-- bootstrap-table -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.js"></script> <!-- bootstrap-table -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/locale/bootstrap-table-pt-BR.min.js"></script> <!-- bootstrap-table -->

		<!-- Loading btn -->
		<!-- <script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script> -->
	</head>

	<body onload="onPageLoad();">
		<nav id="header" class="navbar navbar-default navbar-collapse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="../prograd_michael/index.php">
		        <img alt="Brand" src="images/ufg_logo.png">
		      </a>
		      <a id="relatorios" class="navbar-brand" >Página de relatórios UFG por ano</a>
		    </div>
		  </div>
		</nav>
