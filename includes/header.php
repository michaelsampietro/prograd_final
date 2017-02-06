<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bootstrap Example</title>
	  	<meta charset="utf-8">
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
	  	<!-- Arquivo CSS -->
	  	<link rel="stylesheet" type="text/css" href="style.css">

	  	<!-- Google Visualization API -->
 		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	  	<!-- Chart.js -->
	  	<script src="charts/Chart.js"></script>

  		<!-- Arquivos Bootstrap -->
	  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  		<!-- Jquery -->
  		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  		<script type="text/javascript">
  			//create trigger to resizeEnd event     
			$(window).resize(function() {
			    if(this.resizeTO) clearTimeout(this.resizeTO);
			    this.resizeTO = setTimeout(function() {
			        $(this).trigger('resizeEnd');
			    }, 500);
			});

			//redraw graph when window resize is completed  
			$(window).on('resizeEnd', function() {
			    drawChart();
			});

			// abrindo/fechando quando tem canvas
		    $(document).ready(function() {

		    	$(".row").each(function() {
		    		$("h3").click(function(){
    					$(this).siblings("canvas").toggle();
		    		});
		    	});
		    });

		    $(document).ready(function() {
		    	$(".row").each(function() {
		    		$("h3").click(function(){
    					$(this).siblings("div").toggle();
		    		});
		    	});
		    });

		    $(document).ready(function() {
		    	$(".row").each(function() {
		    		$("h3").click(function(){
    					$(this).siblings("table").toggle();
		    		});
		    	});
		    });
  		</script>

	</head>

	<body onload="onPageLoad();">
		<nav class="navbar navbar-default navbar-collapse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="../prograd_michael/index.php">
		        <img alt="Brand" src="images/ufg_logo.png">
		      </a>
		      <a id="relatorios" class="navbar-brand" >Página de relatórios UFG por ano</a>
		    </div>
		  </div>
		</nav>