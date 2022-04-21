<?php
include("sessioni.php");
include("connection.php");


$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT  *,utente.id FROM utente left join carrello on utente.id = carrello.idUtente where password = '" . md5($password) . "' and email = '$email' ";
// and pagato=0
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  // echo "New record created successfully";
  //  echo  var_dump($row);
  $row = $result->fetch_assoc();

  $idUtente = $row["id"];
  $nomeUtente = $row["nome"];
  $email = $row["email"];
  $ruolo = $row["ruolo"];
  $idCarrello = $row["idCarrelloCodice"];

  // if ($row["idCarrelloCodice"] == null) {

  //   $pagato = 0;
  //   $data = date("y-m-d");

  //   $sql2 = $conn->prepare("INSERT INTO carrello (data,idUtente,pagato) VALUES (?,?,?)");
  //   $sql2->bind_param("sii", $data, $idUtente, $pagato);
  //   $sql2->execute();
  // }

  $_SESSION["idUtenteLog"] = $idUtente;
  $_SESSION["nome"] = $nomeUtente;
  $_SESSION["email"] = $email;
  $_SESSION["ruolo"] = $ruolo;
  $_SESSION["idCarrello"] =  $idCarrello;

  // setcookie("utente_id", $idUtente, time() + (86400 * 30), "/"); // 86400 = 1 day
  // setcookie("carrello_id", $idCarrello, time() + (86400 * 30), "/"); // 86400 = 1 day

  // setcookie("user_name", "guest", time() + (86400 * 30), "/"); // 86400 = 1 day
  // setcookie("utente_email", "prova@gmail.com", time() + (86400 * 30), "/"); // 86400 = 1 day

  header("location:../index.php");
} else {
  header("location:../html/login.html?ErroreLogin");
}

$conn->close();
