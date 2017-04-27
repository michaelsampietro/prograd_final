<?php

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
$nome = mysqli_real_escape_string($conn, $_POST['nome']);
$sobrenome = mysqli_real_escape_string($conn, $_POST['sobrenome']);
$password = mysqli_real_escape_string($conn, hash("md5" , $_POST['password']));

$query = "INSERT INTO Users(email,nome, sobrenome, senha)";
$query .= " VALUES ('$email', '$password')";

// $query = "SELECT * FROM Users WHERE email='$email' and password='$password'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) === 0) {
  echo "Email/Senha inválidos!" . mysqli_connect_error();
}
else 
  echo "Olá, $nome!";

header("Location: http://200.137.197.234/prograd_michael/login.php"); /* Redirect browser */
exit();

?>