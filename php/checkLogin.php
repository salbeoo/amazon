<?php
include("sessioni.php");
include("connection.php");


$email=$_POST["email"];
$password=$_POST["password"];

$sql = "SELECT  utente.id,nome,email,carrello.id FROM utente join carrello on utente.id = carrello.idUtente where password = '".md5($password)."' and email = '$email' and pagato=0";
$result = $conn->query($sql);

if ($result->num_rows>0) {
    // echo "New record created successfully";
    $row = $result->fetch_assoc();
    $_SESSION["idUtente"]=$row["utente.id"];
    $_SESSION["nome"]=$row["nome"];
    $_SESSION["email"]=$row["email"];
    $_SESSION["idCarrello"]=$row["carrello.id"];
    
    setcookie("user_name", "guest", time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("utente_id", "-1", time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("utente_email", "prova@gmail.com", time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("carrello_id", "1000", time() + (86400 * 30), "/"); // 86400 = 1 day
    
    header("location:../index.php");
  } else {
    header("location:../html/login.html?ErroreLogin");
  }
  
$conn->close();

?>