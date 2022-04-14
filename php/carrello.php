<?php
include("sessioni.php");
include("connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon</title>

    <link rel="stylesheet" type="text/css" href="../html/css/util.css">
    <link rel="stylesheet" type="text/css" href="../html/css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../index.php">Amazon</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="../html/login.html">Login</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="carrello.php">Carrello</a>
            </li>
        </ul>
    </nav>

    <?php

    $stringa = "<div class='container'>"/* "<div class='container>" */;
    $sql = "SELECT * FROM articolo join contiene_acquisto on articolo.id=contiene_acquisto.idArticolo";
    $result = $conn->query($sql);
    // <a href='php/schedaProdotto.php?idProdottoCliccato=" . "$row[id]" . "'>                </a>
    while ($row = $result->fetch_assoc()) {
        $stringa .= "
            <div class='row align-items-center'>

                    <div class='col'>
                        <div class='container-immagine col'>

                            <img class='img-prodotto col img-fluid' src='../$row[immagine]' alt='ciai'>
                        </div>
                    </div>
                <div class='col'>
                    <div class='container-title col'>
                        $row[nome]
                        <div class='container-descrizione col'>
                            $row[descrizione]
                        </div>
                    </div>
                </div>
                <div class='col'>
                    <div class='container-prezzo col'>
                        $row[prezzo]€
                    </div>
                </div>
                <div class='col ' >
                    <div class='container-button col'>
                    <button class='button-style' type='button' onclick='cancellaProdotto(" . "$row[id]" . ")'>X</button>
                    </div>
                </div>
            </div>";
    }
    $stringa.="</div>";
    echo $stringa;
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>