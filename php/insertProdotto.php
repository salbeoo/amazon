<?php

include("sessioni.php");
include("connection.php");

if (isset($_GET["idProdottoAcquisto"])) {
    $quantita=1;
    $sql = $conn->prepare("INSERT INTO contiene_acquisto (idArticolo, idCarrello , quantita) VALUES (?, ?, ?)");
    $sql->bind_param("iii", $_GET["idProdottoAcquisto"],$_SESSION["idCarrello"],$quantita);

    if ($sql->execute() === TRUE) {
        header("location:index.php");
    } else {
        // header("location:index.php?ErroreGenerico");
    }

    $sql->close();
    $conn->close();
}
?>
