<?php 

include_once('includes/header.php'); 
include_once('utils.php');

$email = htmlspecialchars($_POST["user"]);
$password = hash("md5", htmlspecialchars($_POST["pass"]));

$conn = connect();

$username = mysqli_real_escape_string($conn, $_POST['user']);
$password = mysqli_real_escape_string($conn, hash("md5" , $_POST['pass']));

$query = "INSERT INTO Users(email,password)";
$query .= " VALUES ('$username', '$password')";


$result = mysqli_query($conn, $query);
if (!$result)
  die("query failed!" . mysqli_connect_error());

// insere valores 

echo "hello, $email. your password is $password";

include_once('includes/footer.php'); 

?>
