<?php require_once('includes/header.php'); ?>

<div class='container'>
	<div class='row'>
	<div class=' panel panel-default col-xs-5'>
		<div class='panel-body'>
			<h3>Bem Vindo!</h3>
			<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ultricies pulvinar mauris. Proin eu justo imperdiet, hendrerit urna vel, imperdiet risus. Nam ac ligula vel nulla mattis euismod. Fusce tempor ante ac nulla commodo euismod. Fusce vitae turpis eleifend, vehicula est suscipit, maximus risus. Duis vitae condimentum ligula. Curabitur sit amet congue massa. Mauris feugiat pharetra arcu in euismod. Donec ut ante dignissim, bibendum risus quis, lobortis lectus. Phasellus in justo non lacus lobortis posuere imperdiet et ipsum. Proin faucibus a sapien eget luctus.Pellentesque congue nunc justo, a malesuada erat ornare at. Proin maximus ac magna ac aliquet. Pellentesque viverra erat rutrum sem vulputate, sed varius metus eleifend. Nullam metus est, ultricies id leo vel, ullamcorper consequat augue. Sed non libero et tortor pulvinar volutpat. Morbi tortor elit, consectetur quis mi nec, eleifend commodo lacus. Vestibulum pretium, velit pharetra hendrerit venenatis, erat nibh ornare est, eu finibus eros justo quis augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nibh justo, scelerisque a eros vitae, dapibus laoreet ex. In convallis dictum nisl. </p>
		</div>
	</div>

	<div class='container panel panel-default col-xs-offset-1 col-xs-5'>
		<div class='panel-body'>
			<form action="handler.php" method="post">
    			<div class='form-group'>
      				<label for='sel1'><h3>Escolha um ano abaixo:</h3></label>
      				<select class='form-control' id='sel1' name='anos'>
						<!-- Função para gerar um dropdown com anos -->
						<?php require_once('utils.php'); dropdownAnos(); ?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Ver relatórios</button>
			</form>
		</div>
	</div>
</div>
</div>

<?php require_once('includes/footer.php'); ?>
