
<!-- Tela de loading -->
	<div class="modal"><!-- Place at bottom of page --></div>

	<footer>
	<div id="footer" class="container">
		<h1>footer</h1>
	</div>
	</footer>

	<!-- On Page Load script -->
	<script type="text/javascript">
		    function onPageLoad() {
		        insereTabelaVagasRegional();
		        insereTabelaNumeroDeCursos();
		    }

		    // $(document).ready(function() {
		    //     // $("#container-geral *").removeAttr("style");
		    //     $("body").show();
		    // });

		    // abrindo/fechando quando tem canvas
		    $(document).ready(function() {
		        $(".row").each(function() {
		            $("h3").each(function() {
		                $(this).siblings("canvas").hide();
		                $(this).siblings("h7").hide();
		                $(this).siblings("table").hide();
		                $(this).addClass("noprint");
		            });
		            $("h3").click(function() {
		                // se tiver escondido, quando clicar no h3 é pra ir pro centro
		                // se não tiver escondido, quando clicar é pro h3 ir pra esquerda..
		                if ($(this).siblings("canvas").is(":hidden")) {
		                    $(this).addClass("text-center");
		                    $(this).siblings("canvas").show();
		                    $(this).siblings("h7").show();
		                    $(this).removeClass("noprint");
		                } else {
		                    $(this).removeClass("text-center");
		                    $(this).siblings("canvas").hide();
		                    $(this).siblings("h7").hide();
		                    $(this).addClass("noprint");
		                }
		            });
		        });
		    });
				
		    $(document).ready(function() {
		        $(".row").each(function() {
		            $("h3").each(function() {
		                $(this).siblings("div").hide();
		            });
		        });
		    });
		    $(document).ready(function() {
		        $(".row").each(function() {
		            $("h3").each(function() {
		                $(this).siblings("table").hide();
		            });
		            $("h3").click(function() {
		                $(this).siblings("table").toggle();
		            })
		        });
		    });

		    // escondendo loading button
		    $(document).ready(function() {
		        $.LoadingOverlay("hide");
		    });
		</script>

	</body>
</html>
