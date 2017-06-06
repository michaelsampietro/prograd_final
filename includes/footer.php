



<nav id="footer" class="navbar navbar-default">
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
			 CEP: 74690-900 <br><br>
		 </p>
	 </div>
	 <div class="col-md-3">
		 <p>
			 Telefone: (62) 3521-1070 <br>
			 FAX: (62) 3521-1162 <br>
			 Contato: prograd@ufg.br <br>
			 <b><a  target="_blank" class="link-footer" href="https://prograd.ufg.br/feedback">Fale Conosco</a></b><br><br>

			 <b><a  target="_blank" class="link-footer" href="http://www.ouvidoria.ufg.br/">Ouvidoria </a></b>
			 <b><a  target="_blank" class="link-footer" href="https://www.ufg.br/pages/63497">Políticas de Privacidade </a></b>
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
