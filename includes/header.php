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
	  	<!-- Não utilizando mais na versao final! -->
 		<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->

	  	<!-- Chart.js -->
	  	<script src="charts/Chart.js"></script>

  		<!-- Arquivos Bootstrap -->
	  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  		<!-- Jquery -->
  		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

  		<!-- Biblioteca de loading -->
  		<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script>

  		<script type="text/javascript">
  			//create trigger to resizeEnd event     
			/*$(window).resize(function() {
			    if(this.resizeTO) clearTimeout(this.resizeTO);
			    this.resizeTO = setTimeout(function() {
			        $(this).trigger('resizeEnd');
			    }, 500);
			});

			//redraw graph when window resize is completed  
			$(window).on('resizeEnd', function() {
			    drawChart();
			});*/

			// abrindo/fechando quando tem canvas
		    $(document).ready(function() {
		    	$(".row").each(function() {
		    		$("h3").each(function(){
    					$(this).siblings("canvas").hide();
		    		});
		    		$("h3").click(function(){
		    			// se tiver escondido, quando clicar no h3 é pra ir pro centro
		    			// se não tiver escondido, quando clicar é pro h3 ir pra esquerda..
		    			if($(this).siblings("canvas").is(":hidden")){
		    				$(this).addClass("text-center");
		    				$(this).siblings("canvas").show();
		    			} else {
		    				$(this).removeClass("text-center");
		    				$(this).siblings("canvas").hide();
		    			}
		    		});
		    	});
		    });

		    $(document).ready(function() {
		    	$(".row").each(function() {
		    		$("h3").each(function(){
    					$(this).siblings("div").hide();
		    		});
		    	});
		    });

		    $(document).ready(function() {
		    	$(".row").each(function() {
		    		$("h3").each(function(){
    					$(this).siblings("table").hide();
		    		});
		    		$("h3").click(function(){
		    			$(this).siblings("table").toggle();
		    		})
		    	});
		    });

		    $(document).ready(function() {
		    	$.LoadingOverlay("hide");
		    })

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