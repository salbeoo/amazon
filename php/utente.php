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
    <title>Pagina personale</title>

    <link rel="stylesheet" type="text/css" href="../html/css/util.css">
    <link rel="stylesheet" type="text/css" href="../html/css/main.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../index.php">SHOPEBO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

            </ul>

    </nav>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-50 p-b-90">
                <form class="login100-form validate-form flex-sb flex-w" action="../php/sessioniDestroy.php" method="post">
                    <!-- METTI RIFERIMENTO AL METHOD E ACTION -->
                    <span class="login100-form-title p-b-51">
                        <?php
                        echo $_SESSION["nome"];
                        ?>
                    </span>


                    <!-- <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                        <input class="input100" type="email" name="email" placeholder="E-mail">
                        <span class="focus-input100"></span>
                    </div>


                    <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                    </div> -->

                    <?php
                    $ddd = ""/* "<div class='container>" */;
                    $id = $_SESSION["idUtenteLog"];
                    $sql = "SELECT ruolo FROM utente where id='$id'";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        if ($row["ruolo"] == 1) {
                            $ddd .= '<div class="wrap-input100 validate-input m-b-16" data-validate="Password is required">
                            <a href="addArticolo.php" class="login100-form-btn" style="color: white;">Inserimento articolo</a>
                            <span class="focus-input100"></span>
                        </div>
                        ';
                        }
                    }
                    echo $ddd;
                    ?>

                    <div class="container-login100-form-btn m-t-17">
                        <button class="login100-form-btn" type="submit">
                            Log out
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>