<?php
include("php/sessioni.php");
include("php/connection.php");

echo json_encode($_COOKIE);
if (!isset($_COOKIE["user_name"])) {
    setcookie("user_name", "guest", time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("utente_id", "-1", time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("utente_email", "prova@gmail.com", time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("carrello_id", "1000", time() + (86400 * 30), "/"); // 86400 = 1 day
} else {
    $_SESSION["idUtente"] = $_COOKIE["utente_id"];
    $_SESSION["email"] = $_COOKIE["utente_email"];
    $_SESSION["idCarrello"] = $_COOKIE["carrello_id"];
}

if (isset($_GET["idProdottoAcquisto"])) {
    setcookie("carrello_prodotti", $_GET["idProdottoAcquisto"], time() + (86400 * 30), "/"); // 86400 = 1 day

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon</title>

    <link rel="stylesheet" type="text/css" href="html/css/util.css">
    <link rel="stylesheet" type="text/css" href="html/css/main.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Amazon</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="html/login.html">Login</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Carrello</a>
            </li>
        </ul>
    </nav>


    <?php
    if (!isset($_SESSION["idCarrello"])) {
        $_SESSION["idCarrello"] = 10;
    }
    $stringa = ""/* "<div class='container>" */;
    $sql = "SELECT * FROM articolo";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $stringa .= "
        <div class='container-box col-lg-2 col-md-5 col-sm-4'>
        <div class='container-immagine'>
            <img class='img-prodotto col' src='$row[immagine]' alt='ciai'>
        </div>
        <div class='container-title col'>
            $row[nome]
            <div class='container-descrizione col'>
                $row[descrizione]
            </div>
        </div>
        <div class='container-prezzo col'>
            $row[prezzo]€
        </div>
        <div class='container-button'>
        <button class='button-style' type='button' onclick='aggiungiProdotto(" . "$row[id]" . ")'>Aggiungi al carrello</button>
        </div>
    </div>";
    }
    // $stringa="</div>";
    echo $stringa;
    ?>
    <!-- <div class="container-box">
        <div class="container-immagine">
            <img class="img-prodotto" src="cavalloRuotato.png">
        </div>
        <div class="container-title">
            Bello mio
        </div>
        <div class="container-prezzo">
            6,99€
        </div>
    </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>

<script>
    function aggiungiProdotto(i) {
        window.location.replace('index.php?idProdottoAcquisto=' + i);
        // setcookie("carrello_prodotti", i, time() + (86400 * 30), "/"); // 86400 = 1 day
    }
</script>