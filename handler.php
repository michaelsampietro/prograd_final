<?php 
    require_once 'utils.php';
    require_once 'includes/header.php';
    
    $ano = htmlspecialchars($_POST['anos']);
    ?>
<!-- Estrutura básica da biblioteca de Chart JS para criar um gráfico -->
<div class="container">
    <div class="row">
        <div>
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por regional</h3>
            <canvas id="myChart" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Jataí", "Goiânia", "Goiás", "Catalão", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'Jatai' => 0,'Goiânia' => 0,'Goiás' => 0,'Catalão' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE municipio=";
                    graficoBarra($array, $sql); ?>],
                    <?php opcoes_grafico(); ?>;
            </script>
        </div>
    </div>
    <div class='row'>
        <div >
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por regional</h3>
            <canvas id="myChart2" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart2");
                var myChart2 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE grau_academico=";
                    graficoBarra($array, $sql); ?>],
                    <?php opcoes_grafico(); ?>;
            </script>
        </div>
    </div>

    <div class='row'>
        <div>
            <h3 align="middle">Número de estudantes matriculados em abril de 2016 por grau acadêmico na regional Catalão</h3>
            <canvas id="myChart3" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart3");
                var myChart3 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Catalao' and grau_academico=";
                    graficoBarra($array, $sql); ?>],
                    <?php opcoes_grafico(); ?>;
            </script>
        </div>
    </div>

    <div class='row'>
        <div>
            <h3 align="middle">NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016
                POR GRAU ACADÊMICO NA REGIONAL GOIÂNIA
            </h3>
            <canvas id="myChart4" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart4");
                var myChart4 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Goiania' and grau_academico=";
                    graficoBarra($array, $sql); ?>],
                    <?php opcoes_grafico(); ?>;
            </script>
        </div>
    </div>

    <div class='row'>
        <div>
            <h3 align="middle">NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016
                POR GRAU ACADÊMICO NA REGIONAL GOIAS
            </h3>
            <canvas id="myChart5" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart5");
                var myChart5 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Goias' and grau_academico=";
                    graficoBarra($array, $sql); ?>],
                    <?php opcoes_grafico(); ?>;
            </script>
        </div>
    </div>

    <div class='row'>
        <div>
            <h3 align="middle">NÚMERO DE ESTUDANTES MATRICULADOS EM ABRIL DE 2016
                POR GRAU ACADÊMICO NA REGIONAL JATAÍ
            </h3>
            <canvas id="myChart6" width="auto" height="auto"></canvas>
            <script>
                var ctx = document.getElementById("myChart6");
                var myChart6 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Bacharelado", "Bacharelado/Licenciatura", "Grau Não Definido", "Licenciatura", "Total"],
                        datasets: [{
                            label: 'Número de estudantes',
                            data: [<?php
                    $array = array( 'BACHARELADO' => 0,'BACHARELADO E LIC.' => 0,'GRAU NÃO DEFINIDO' => 0,'LICENCIATURA' => 0);
                    $sql = "SELECT COUNT(Estudante) AS count_est FROM `$ano` WHERE Regional='Jatai' and grau_academico=";
                    graficoBarra($array, $sql); ?>],
                    <?php opcoes_grafico(); ?>;
            </script>
        </div>
    </div>

</div>
<?php
    require_once 'includes/footer.php';
    ?>