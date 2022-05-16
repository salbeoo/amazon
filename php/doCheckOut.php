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
$sql->bind_param("ssis", $country, $address, $code, $city);

if ($sql->execute() === TRUE) {
    $idIndirizzo = $sql->insert_id;
    $idUte=$_SESSION["idUtenteLog"] ;


    $sql2 = "UPDATE utente SET idIndirizzo=$idIndirizzo,telefono=$mobile WHERE id=$idUte";
    $conn->query($sql2);

    $idCarrellino=$_SESSION["idCarrello"];
    $idPagato=1;
    $sql3 = "UPDATE carrello SET pagato=$idPagato WHERE idCarrelloCodice=$idCarrellino";
    $conn->query($sql3);

    $data = date("y-m-d");
    $ora=time();
    $sql5 = $conn->prepare("INSERT INTO ordine (data, ora, idCarrello) VALUES (?, ?, ?)");
    $sql5->bind_param("ssi", $data, $ora, $idCarrellino);
    $sql5->execute();

    header("location:../index.php");

}
