<?php require_once('includes/header.php'); ?>

<div class='container'>
    <div class="row">
        <div class="col-xs-12 col-md-5">
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <h3>Bem Vindo!</h3>
                    <p>Just some text.</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-offset-1 col-md-5">
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <form action="handler.php" method="post">
                        <div class='form-group'>
                            <label for='sel1'>
                                <h3>Escolha um ano abaixo:</h3>
                            </label>
                            <select class='form-control' id='sel1' name='anos'>
                                <!-- Função para gerar um dropdown com anos -->
                                <?php require_once( 'utils.php'); dropdownAnos(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ver relatórios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>