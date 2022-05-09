<?php
include("sessioni.php");
include("connection.php");

$mobile = $_POST["mobile"];
$country = $_POST["country"];
$address = $_POST["address"];
$city = $_POST["city"];
$code = $_POST["code"];
$pagamento = $_POST["payment"];


$sql = $conn->prepare("INSERT INTO indirizzo (nazione, via, civico,paese) VALUES (?, ?, ?, ?)");
$sql->bind_param("iiii", $country, $address, $code, $city);

if ($sql->execute() === TRUE) {
    $idIndirizzo = $sql->insert_id;
    $idUte=$_SESSION["idUtenteLog"] ;


    $sql2 = "UPDATE utente SET idIndirizzo=$idIndirizzo,telefono=$mobile WHERE id=$idUte";
    $conn->query($sql2);

    header("location:../index.php");

}
