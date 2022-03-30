<?php
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

$sql = "SELECT  email FROM utente  where email = $email";
$result = $conn->query($sql);

if ($result->num_rows) {
  header("location:../html/registrazione.html?msg=ErroreRegistrazione");
} else {
  $sql = $conn->prepare("INSERT INTO utente (nome, cognome, dataNascita,sesso,email,password) VALUES (?, ?, ?, ?, ?,?)");
  $sql->bind_param("ssssss", $nome, $cognome, $dataNascita, $genere, $email, $password);


  if ($sql->execute() === TRUE) {
    header("location:../index.php");
  } else {
    // header("location:registrazione.html?ErroreGenerico");
  }
}
$sql->close();
$conn->close();
