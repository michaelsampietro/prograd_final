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
		<!-- Arquivo CSS de impressão -->
		<link rel="stylesheet" type="text/css" media="print" href="styles/print.css">

	  	<!-- Chart.js -->
	  	<script src="charts/Chart.js"></script>

  		<!-- Arquivos Bootstrap -->
	  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  		<!-- Jquery -->
			<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

  		<!-- Loading btn -->
  		<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script>
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
