<?php
include("sessioni.php");
include("connection.php");

$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$dataNascita = $_POST["dataNascita"];
$genere = $_POST["genere"];
$email = $_POST["email"];
$password = md5($_POST["password"]);

// echo $nome;
// echo $cognome;
// echo $dataNascita;
// echo $genere;
// echo $email;
// echo $password;
// $sql = "INSERT INTO utente (Username, Password, Nome,Cognome,DataDiNascita,Immagine) VALUES ('$username', '".md5($password)."', '$nome', '$cognome', '$datadinascita', '$target_file')";

$sql = $conn->prepare("INSERT INTO utente (nome, cognome, dataNascita,sesso,email,password) VALUES (?, ?, ?, ?, ?,?)");
$sql->bind_param("ssssss", $nome, $cognome, $dataNascita, $genere, $email, $password);

if ($sql->execute() === TRUE) {

  //controllo che non ci sia un carrello guest con articoli
  $idUtente = $sql->insert_id;
  $pagato = 0;
  $data = date("y-m-d");

  if (isset($_SESSION["idCarrello"])) {
    $idCarrelloCod=$_SESSION["idCarrello"];
    // echo $idCarrelloCod;
    $sql2 = "UPDATE carrello SET idUtente=$idUtente WHERE idCarrelloCodice=$idCarrelloCod";
    // $sql2 = $conn->prepare("UPDATE carrello SET idUtente=? WHERE idUtente=?");
    // $idUtenteWhere=$idUtente;
    // $sql2->bind_param("ii",$idUtente, $idUtenteWhere);
    // echo $sql2;
    $conn->query($sql2);
  } else {
    $sql2 = $conn->prepare("INSERT INTO carrello (data,idUtente,pagato) VALUES (?,?,?)");
    $sql2->bind_param("sii", $data, $idUtente, $pagato); 
    $sql2->execute();
  }


  // header("location:../index.php");
} else {
  // header("location:../html/register.html?ErroreGenerico");
}

$sql->close();
$conn->close();
