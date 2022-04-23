<?php
include("sessioni.php");
include("connection.php");

if($_SESSION["idUtenteLog"]==-1){
    $_SESSION["commento"]=$_GET["message"];
    //ricordarsi di sistemare i commenti per dopo quando si logga
    header("location:../html/login.html");
}else{
    $data = date("y-m-d");
    $commento=$_GET["message"];
    $stelle=null;
    $idArticolo=$_SESSION["idArticoloFocus"];
    $idUtente=$_SESSION["idUtenteLog"];

    $sql = $conn->prepare("INSERT INTO commento (data, commento, stelle,idArticolo,idUtente) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("ssiii", $data, $commento, $stelle, $idArticolo, $idUtente);   
    if ($sql->execute() === TRUE) {
        header("location:detail.php?idArticolo=".$_SESSION["idArticoloFocus"]);
    }
}

?>