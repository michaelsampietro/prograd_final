
<!-- Tela de loading -->
	<div class="modal"><!-- Place at bottom of page --></div>

	<footer>
	<div class="container">
		<h1>footer</h1>
	</div>
	</footer>

	<!-- On Page Load script -->
	<script type="text/javascript">
		    function onPageLoad() {
		        insereTabelaVagasRegional();
		        insereTabelaNumeroDeCursos();
		    }

		    // abrindo/fechando quando tem canvas
		    $(document).ready(function() {
		        $(".row").each(function() {
		            $("h3").each(function() {
		                $(this).siblings("canvas").hide();
		                $(this).siblings("h7").hide();
		                $(this).siblings("table").hide();
		            });
		            $("h3").click(function() {
		                // se tiver escondido, quando clicar no h3 é pra ir pro centro
		                // se não tiver escondido, quando clicar é pro h3 ir pra esquerda..
		                if ($(this).siblings("canvas").is(":hidden")) {
		                    $(this).addClass("text-center");
		                    $(this).siblings("canvas").show();
		                    $(this).siblings("h7").show();
		                } else {
		                    $(this).removeClass("text-center");
		                    $(this).siblings("canvas").hide();
		                    $(this).siblings("h7").hide();
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
