<?php 

include_once('includes/header.php'); 
include_once('utils.php');

// $email = htmlspecialchars($_POST["email"]);
// $password = hash("md5", htmlspecialchars($_POST["pass"]));

$host = 'localhost';
$user = 'root';
$pass = 'quiegh3A';
$banco = 'prograd_users';
$conn = mysqli_connect($host, $user, $pass, $banco);
if (!$conn) {
  print ("Não foi possível fazer conexão ao bando de dados.");
  exit();
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, hash("md5" , $_POST['pass']));

// $query = "INSERT INTO Users(email,password)";
// $query .= " VALUES ('$email', '$password')";

$query = "SELECT * FROM Users WHERE email='$email' and senha='$password'";
$result = mysqli_query($conn, $query);
mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) === 0) {
  echo "Email/Senha inválidos!" . mysqli_connect_error();
}
else 
  echo "Olá, $email!";

?>

<div class="nav">
    <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#section-add-user">Adicionar Usuario</a></li>
        <li><a href="#section-modify-user">Modificar Usuario</a></li>
        <li><a href="#section-remove-user">Remover Usuario</a></li>
        <li><a href="#section-add-data">Adicionar Dados</a></li>
    </ul>
</div>

<div class="col-md-8">
  <div id="inicio" class="tab-content">
    <h2>Início</h2>
    <p>Bem-vindo, essa é a página de administrador. Nela voce pode adicionar, modificar e remover usuários, além de adicionar novos dados para serem mostrados na página de usuário.</p>
</div>
<div id="section-add-user" class="tab-content">
  <div class="row">
    <h2>Adicioar novo usuário</h2>         
    <form class="form-horizontal" method="post" action="handlers/add-user-handler.php">
      <fieldset>
        <!-- Form Name -->
        <legend>Cadastre o novo usuário</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Nome</label>  
          <div class="col-md-4">
          <input id="nome" name="nome" placeholder="Digite o Nome" class="form-control input-md" required="" type="text">
          <span class="help-block"> </span>  
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Sobrenome</label>  
          <div class="col-md-4">
          <input id="sobrenome" name="sobrenome" placeholder="Digite o sobrenome" class="form-control input-md" required="" type="text">
          <span class="help-block"> </span>  
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Email</label>  
          <div class="col-md-4">
          <input id="email" name="email" placeholder="Digite o email" class="form-control input-md" required="" type="email">
          <span class="help-block"> </span>  
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Senha</label>  
          <div class="col-md-4">
            <input id="senha" name="senha" placeholder="Digite a senha" class="form-control input-md" required="" type="password">
            <span class="help-block"> </span>  
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Confirme a Senha</label>  
          <div class="col-md-4">
            <input id="confirm-senha" name="confirm-senha" placeholder="Digite a senha novamente" class="form-control input-md" required="" type="password">
            <span class="help-block"> </span>  
          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton"> </label>
          <div class="col-md-4">
            <button id="submit" name="submit" class="btn btn-primary">Cadastrar!</button>
          </div>
      </div>
    </fieldset>
    </form>
  </div>
</div>
<div id="section-modify-user" class="tab-content">
    <h2>Modificar Usuario</h2>
</div>
<div id="section-remove-user" class="tab-content">
    <h2>Remover Usuario</h2>
</div>
<div id="section-add-data" class="tab-content">
    <h2>Adicionar Dados</h2>
    <p>asfasdf</p>
</div>
</div>



<script>
$(document).ready(function () {
    $('.nav ul li:first').addClass('active');
    $('.tab-content:not(:first)').hide();
    $('.nav ul li a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
    });
});
</script>



<?php
include_once('includes/footer.php'); 
?>
