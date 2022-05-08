<?php
include("sessioni.php");
include("connection.php");


if (isset($_GET["idArticoloEliminare"])) {
    $sql = "DELETE FROM articolo WHERE id=$_GET[idArticoloEliminare]";
    $conn->query($sql);
}

if (isset($_GET["idArticoloSalvare"])) {
    $sql = "UPDATE articolo set quantita=$_GET[nProdotti]  WHERE id=$_GET[idArticoloSalvare]";
    $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina prodotti</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- 
    <link rel="stylesheet" type="text/css" href="../html/css/util.css">
    <link rel="stylesheet" type="text/css" href="../html/css/main.css"> -->

    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script>
        function change(id) {
            var richiesta = window.confirm("Vuoi cancellare l'articolo?");
            if (richiesta) {
                window.location.replace('vistaProdottiTabella.php?idArticoloEliminare=' + id);
            }
        }

        function salva(id) {
            var nProdotto=document.getElementById("nArticoli"+id).value;
            window.location.replace('vistaProdottiTabella.php?idArticoloSalvare=' + id+'&nProdotti='+nProdotto);

        }
    </script>
</head>

<body>
    <!-- Topbar Start -->
    <!-- Navbar Start -->
    <?php
    include("viewNavbar.php");
    ?>
    <!-- Navbar End -->
    <!-- Topbar End -->
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../index.php">SHOPEBO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

            </ul>

    </nav> -->

    <div class="limiter">
        <div class="table-responsive">
            <form class="login100-form validate-form flex-sb flex-w" action="../php/sessioniDestroy.php" method="post">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">ID</th>
                            <th scope="col">Codice</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Prezzo</th>
                            <th scope="col">Peso</th>
                            <th scope="col">Quantità</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql3 = "SELECT * FROM articolo";
                        $stringa = ""/* "<div class='container>" */;
                        $result = $conn->query($sql3);
                        while ($row = $result->fetch_assoc()) {
                            $stringa .= '
                            <tr>                            
                            <td><img src="../' . $row["immagine"] . '" alt="Image"  style="width: 45px;"></td>
                            <th scope="row">' . $row["id"] . '</th>
                            <td>' . $row["codice"] . '</td>
                            <td>' . $row["nome"] . '</td>
                            <td>€' . $row["prezzo"] . '</td>
                            <td>' . $row["peso"] . '</td>
                            <td><input style="width:100px"type="number" id="nArticoli'.$row["id"].'" value="' . $row["quantita"] . '"/></td>
                            <td>
                            <button onclick="change(' . $row["id"] . ')" class="btn btn-sm text-dark p-0" type="button" /><i class="fa fa-trash fa-2x"></i></button>
                            <button onclick="salva(' . $row["id"] . ')" class="btn btn-sm text-dark p-0" type="button" /><i class="fa fa-save fa-2x"></i></button>
                            
                            </td>
                            </td>
                            </tr>
                            ';
                        }
                        echo $stringa;
                        ?>

                    </tbody>
                </table>

                <?php
                $ddd = ""/* "<div class='container>" */;
                $id = $_SESSION["idUtenteLog"];
                $sql = "SELECT ruolo FROM utente where id='$id'";
                $result = $conn->query($sql);

                while ($row2 = $result->fetch_assoc()) {
                    if ($row2["ruolo"] == 1) {
                    }
                }
                echo $ddd;
                ?>

                <!-- <div class="container-login100-form-btn m-t-17">
                        <button class="login100-form-btn" type="submit">
                            Log out
                        </button>
                    </div> -->

            </form>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>