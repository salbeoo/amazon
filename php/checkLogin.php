<?php
include("sessioni.php");
include("connection.php");



$email=$_POST["email"];
$password=$_POST["password"];


$sql = "SELECT  * FROM utente join carrello on utente.id = carrello.idUtente where password = '".md5($password)."' and email = '$email' and pagato=0";

$result = $conn->query($sql);

echo $conn->error;
if ($result->num_rows>0) {
    // echo "New record created successfully";
    $row = $result->fetch_assoc();
    
    setcookie("utente_id", $row["utente.id"], time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("user_name", $row["nome"], time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("user_surname", $row["cognome"], time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("utente_email", $row["email"], time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("carrello_id", $row["carrello.id"], time() + (86400 * 30), "/"); // 86400 = 1 day


    $_SESSION["utente_id"] = $_COOKIE["utente_id"];
    $_SESSION["user_name"] = $_COOKIE["user_name"];
    $_SESSION["user_surname"] =  $_COOKIE["user_surname"];
    $_SESSION["utente_email"] =  $_COOKIE["utente_email"];
    $_SESSION["carrello_id"] =  $_COOKIE["carrello_id"];
    
    header("location:../index.php");
  } else {
    header("location:../html/login.html?ErroreLogin");
  }

// echo $conn->error;
  
$conn->close();

?>