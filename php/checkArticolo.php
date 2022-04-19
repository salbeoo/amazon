<?php
include("sessioni.php");
include("connection.php");


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


$codice=$_POST["codice"];
$nome=$_POST["nome"];
$descrizione=$_POST["descrizione"];
$quantita=$_POST["quantita"];
$prezzo=$_POST["prezzo"];
$categoria=$_POST["categoria"];
$peso=$_POST["peso"];

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      $uploadOk = 0;
    }
  }
  
  if (file_exists($target_file)) {
    $uploadOk = 0;
  }
  
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $uploadOk = 0;
  }
  
  if ($uploadOk == 0) {
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../".$target_file)) {
      // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
      // echo "Sorry, there was an error uploading your file.";
    }
  }

$sql=$conn->prepare("INSERT INTO articolo (codice, nome, descrizione,quantita,prezzo,idCategoria,immagine,peso) VALUES (?, ?, ?, ?, ?, ?,?,?)");
$sql->bind_param("issiiisi",$codice, $nome, $descrizione, $quantita, $prezzo,$categoria, $target_file,$peso);

if ($sql->execute() === TRUE) {
    header("location:../index.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
$sql->close();
$conn->close();
