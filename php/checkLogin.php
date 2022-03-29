<?php
include("sessioni.php");
include("connection.php");


$email=$_POST["email"];
$password=$_POST["password"];

$sql = "SELECT  last(utente.id),email,carrello.id FROM utente join carrello on utente.id = carrello.idUtente where password = '".md5($password)."' and email = '$email' and pagato=null";
$result = $conn->query($sql);

if ($result->num_rows>0) {
    // echo "New record created successfully";
    $row = $result->fetch_assoc();
    $_SESSION["idUtente"]=$row["utente.id"];
    $_SESSION["email"]=$row["email"];
    $_SESSION["idCarrello"]=$row["carrello.id"];
    header("location:../index.php");
  } else {
    header("location:../html/login.html?ErroreLogin");
  }
  
$conn->close();

?>