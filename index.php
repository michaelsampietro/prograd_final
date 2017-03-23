<?php ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('includes/header.php');
    require_once('utils.php');  ?>
<div class='container'>
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
                    <form action="tipos_graficos.php" method="post">
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
<?php require_once('includes/footer.php'); ?>
