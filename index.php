<?php ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('includes/header.php');
    require_once('utils.php');  ?>

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
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="col-sm-9 col-lg-10">
    <div class="row">
        <div class="col-xs-12 col-md-5">
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <h3 class="h3-normal">Bem Vindo!</h3>
                    <p>Esta página permite o acesso aos dados estatísticos referentes aos alunos matriculados nos cursos de graduação da UFG. Os dados são baseados nos alunos matriculados por ano.</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-offset-1 col-md-5">
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <form action="handler.php" method="get">
                        <div class='form-group'>
                            <label for='sel1'>
                                <h3 class="h3-normal">Escolha um ano abaixo:</h3>
                            </label>
                            <select class='form-control' id='sel1' name='anos'>
                                <!-- Função para gerar um dropdown com anos -->
                                <?php dropdownAnos(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ver relatórios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Tela de loading -->
	<div class="modal"><!-- Place at bottom of page --></div>

	<footer class="footer-index">
	<!-- <div id="footer" class="container">
		<h1>footer</h1>
		<a href="#" data-toggle="modal" data-target="#login-modal">Login</a>

		<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  	<div class="modal-dialog">
				<div class="loginmodal-container">
					<h1>Login to Your Account</h1><br>
				  	<form action="login.php" method="post">
						<input type="email" name="email" placeholder="E-mail">
						<input type="password" name="pass" placeholder="Senha">
						<input type="submit" name="login" class="login loginmodal-submit" value="Login">
				  	</form>

				  	<div class="login-help">
						<a href="#">Register</a> - <a href="#">Forgot Password</a>
				  	</div>
				</div>
			</div>
	  </div>
	</div> -->

	 <div id="footer-brasil"></div>
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
