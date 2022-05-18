<?php
include("sessioni.php");
include("connection.php");

if($_SESSION["idUtenteLog"]==-1){
    $_SESSION["commento"]=$_GET["message"];
    //ricordarsi di sistemare i commenti per dopo quando si logga
    header("location:login.php");
}else{
    $data = date("y-m-d");
    $commento=$_GET["message"];
    $stelle=null;
    $idArticolo=$_SESSION["idArticoloFocus"];
    $idUtente=$_SESSION["idUtenteLog"];
// print_r($_SESSION);
    $sql = $conn->prepare("INSERT INTO commento (commento, stelle,idArticolo,idUtente) VALUES (?, ?, ?, ?)");
    $sql->bind_param("siii", $commento, $stelle, $idArticolo, $idUtente);   
    if ($sql->execute() === TRUE) {
        header("location:detail.php?idArticolo=".$_SESSION["idArticoloFocus"]);
    }
    echo $sql->error;
}
