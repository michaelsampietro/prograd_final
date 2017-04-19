
<!-- Tela de loading -->
	<div class="modal"><!-- Place at bottom of page --></div>

	<footer>
	<div id="footer" class="container">
		<h1>footer</h1>
		<a href="#" data-toggle="modal" data-target="#login-modal">Login</a>

		<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  	<div class="modal-dialog">
				<div class="loginmodal-container">
					<h1>Login to Your Account</h1><br>
				  	<form action="login.php" method="post">
						<input type="text" name="user" placeholder="Username">
						<input type="password" name="pass" placeholder="Password">
						<input type="submit" name="login" class="login loginmodal-submit" value="Login">
				  	</form>
						
				  	<div class="login-help">
						<a href="#">Register</a> - <a href="#">Forgot Password</a>
				  	</div>
				</div>
			</div>
	  </div>
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
