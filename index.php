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
          </div>
        </div>
      </div>
    </div>

      <div class="col-sm-9 col-lg-10">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        <h3 class="h3-normal">Bem Vindo!</h3>
                        <p>Esta página permite o acesso aos dados estatísticos referentes aos alunos matriculados nos cursos de graduação da UFG. Os dados são baseados nos alunos matriculados por ano.</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-5 col-lg-5">
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
  </div>
</div>
<nav id="footer-index" class="navbar navbar-default">
  <div id="footer-container" class="container">
		<div class="col-md-3">
			<a target="_blank" href="https://www.prograd.ufg.br/">
 			 <img src="./images/logo-prograd-footer.png" alt="PROGRAD - Pró-Reitoria de Graduação">
 		 </a> <br><br>
	 </div>
	 <div class="col-md-3">
		 <p>
			 <b>Pró-Reitoria de Graduação</b>
			 <br>
			 <b>Localização</b>
			 <br>
			 Universidade Federal de Goiás - UFG - Campus Samambaia <br>
			 Prédio da Reitoria - Térreo <br>
			 Avenida Esperança, s/n. <br>
			 Campus Universitário, Goiânia/GO. <br>
			 CEP: 74690-900 <br><br> <br>
       <a target="_blank" href="https://www.ufg.br/pages/63491"><b>Mapas da UFG</b></a>
		 </p>
	 </div>
	 <div class="col-md-3">
		 <p>
			 Telefone: (62) 3521-1070 <br>
			 FAX: (62) 3521-1162 <br>
			 Contato: prograd@ufg.br <br>
			 <b><a  target="_blank" class="link-footer" href="https://prograd.ufg.br/feedback">Fale Conosco</a></b><br><br>

			 <b><a  target="_blank" class="link-footer" href="http://www.ouvidoria.ufg.br/">Ouvidoria </a></b> <br>
			 <b><a  target="_blank" class="link-footer" href="https://www.ufg.br/pages/63497">Políticas de Privacidade </a></b><br>
		 </p>
	 </div>
	 <div class="col-md-3">
		 <a  target="_blank" class="link-footer" href="https://ufgnet.ufg.br/"><b>Portal UFGNet</b></a> <br>
		 <a  target="_blank" class="link-footer" href="https://mail.ufg.br/"><b>WebMail</b></a> <br>
		 <a  target="_blank" class="link-footer" href="https://www.ufg.br/pages/63398"><b>Processos</b></a> <br>
		 <a  target="_blank" class="link-footer" href="http://www.ufg.br/pages/63397-resolucoes"><b>Resoluções</b></a> <br>
		 <a  target="_blank" class="link-footer "href="http://www.ufg.br/pages/63399-telefones"><b>Lista de Telefones</b></a> <br> <br>

		 <a target="_blank" href="http://sic.ufg.br/">
			 <img src="./images/acesso-informacao-footer.png" alt="Acesso à informação">
		 </a> <br>
	 </div>
  </div>
</nav>

<!-- On Page Load script -->
<script type="text/javascript">
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

    $("#sistemas-ufg").change(function() {
      var url = $(this).val();
      window.open(url);
    });
</script>

</body>
</html>
