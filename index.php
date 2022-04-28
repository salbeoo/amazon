<?php
include("php/sessioni.php");
include("php/connection.php");

if (!isset($_SESSION["idUtenteLog"])) { //sono un guest
    if (isset($_COOKIE["carrello_id"])) {
        //setto le sessioni
        $_SESSION["idUtenteLog"] = $_COOKIE["utente_id"];
        $_SESSION["idCarrello"] = $_COOKIE["carrello_id"];
    } else {
        //CREO UN CARRELLO
        $pagato = 0;
        $data = date("y-m-d");
        $utentino = NULL;
        $sql = $conn->prepare("INSERT INTO carrello (data,idUtente,pagato) VALUES (?,?,?)");
        $sql->bind_param("sii", $data, $utentino, $pagato);
        if ($sql->execute() === true) {
            setcookie("carrello_id", $sql->insert_id, time() + (86400 * 30), "/"); // 86400 = 1 day
            setcookie("utente_id", "-1", time() + (86400 * 30), "/"); // 86400 = 1 day
            $_SESSION["idUtenteLog"] =-1;
            $_SESSION["idCarrello"] =  $sql->insert_id;
            $_SESSION["ruolo"] = 0;
        }

    }
}else
{
    // $_COOKIE["utente_id"]=$_SESSION["idUtenteLog"]; 
    // $_COOKIE["carrello_id"]=$_SESSION["idCarrello"];
}
// if (isset($_COOKIE["carrello_id"]))
//     $_SESSION["idCarrello"] = $_COOKIE["carrello_id"];
// else {
//     $pagato = 0;
//     $data = date("y-m-d");
//     $utentino = NULL;
//     $sql = $conn->prepare("INSERT INTO carrello (data,idUtente,pagato) VALUES (?,?,?)");
//     $sql->bind_param("sii", $data, $utentino, $pagato);
//     if ($sql->execute() === true) {
//         $last_id = $sql->insert_id;
//         setcookie("carrello_id", $last_id, time() + (86400 * 30), "/"); // 86400 = 1 day
//     } else {
//     }
//     echo $sql->error;
// }



if (isset($_GET["idArticoloEliminare"])) {
    $sql = "DELETE FROM articolo WHERE id=$_GET[idArticoloEliminare]";
    $conn->query($sql);
}

if (isset($_GET["idProdottoAcquisto"])) {

    $idArticolo = $_GET["idProdottoAcquisto"];
    $idCarrello = $_SESSION["idCarrello"];
    $quantita = 1;

    $sql3 = "SELECT COUNT(*) AS conta from contiene_acquisto where idArticolo=$idArticolo and idCarrello=$idCarrello";
    $result = $conn->query($sql3);
    // echo $sql3;

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if ($row["conta"] > 0) {
            $sqlQuantita = "SELECT quantita from contiene_acquisto where idArticolo=$idArticolo and idCarrello=$idCarrello";
            $resultQuantita = $conn->query($sqlQuantita);

            $rowQuantita = $resultQuantita->fetch_assoc();


            $sql = $conn->prepare("UPDATE contiene_acquisto SET quantita=? WHERE idArticolo=? and idCarrello=?");
            $quantita += $rowQuantita["quantita"];

            $sql->bind_param("iii", $quantita, $idArticolo, $idCarrello);
            // echo $sql;
            if ($sql->execute() === TRUE) {
                header("location:index.php");
            }
        } else {

            // setcookie("carrello_prodotti", $_GET["idProdottoAcquisto"], time() + (86400 * 30), "/"); // 86400 = 1 day
            $sql = $conn->prepare("INSERT INTO contiene_acquisto (idArticolo, idCarrello,quantita) VALUES (?, ?,?)");
            $sql->bind_param("iii", $idArticolo, $idCarrello, $quantita);
            // echo $sql;

            // $sql="INSERT INTO contiene_acquisto (idArticolo,idCarrello) values('$idArticolo','$idCarrello')";
            // $conn->query($sql)
            if ($sql->execute() === TRUE) {
                header("location:index.php");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SHOPBEO</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <script>
        function change(id) {
            var richiesta = window.confirm("Vuoi cancellare l'articolo?");
            if (richiesta) {
                window.location.replace('shop.php?idArticoloEliminare=' + id);
            }
        }

        function aggiungiProdotto(i) {
            window.location.replace('index.php?idProdottoAcquisto=' + i);
            // setcookie("carrello_prodotti", i, time() + (86400 * 30), "/"); // 86400 = 1 day
        }
    </script>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">S</span>HOPBEO</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="php/shop.php" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="prodotto_da_cercare" placeholder="Search for products" />
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                                <input type="submit" style="display: none" class="fa fa-search bg-transparent" value="">
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="php/cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <?php
                    $idCarrello = $_SESSION["idCarrello"];
                    $sql = "SELECT count(*) FROM contiene_acquisto where idCarrello=$idCarrello ";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<span class="badge">' . $row["count(*)"] . '</span>';
                    }

                    ?>

                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <?php
                        $categorie = ""/* "<div class='container>" */;
                        $sql = "SELECT * FROM categoria";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $categorie .= '<a href="" class="nav-item nav-link">' . $row["tipo"] . '</a>';
                        };
                        echo $categorie;
                        
                        // echo $_SESSION["idCarrello"];
                        ?>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="php/shop.php" class="nav-item nav-link">Shop</a>
                            <!-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div> -->
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <?php
                            if (isset($_SESSION["email"]))
                                echo '<a href="php/utente.php" class="nav-item nav-link">' . $_SESSION["nome"] . '</a>'
                            ?>

                            <a href="html/login.html" class="nav-item nav-link">Login</a>
                            <a href="html/register.html" class="nav-item nav-link">Register</a>
                        </div>
                    </div>
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-1.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-2.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <!--         <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
        </div> -->
        <div class="row px-xl-5 pb-3">
            <?php

            if (isset($_GET["prodotto_da_cercare"])) {
                $sql = "SELECT * FROM articolo where nome like '$_GET[prodotto_da_cercare]%'";
            } else
                $sql = "SELECT * FROM articolo";

            $stringa = ""/* "<div class='container>" */;
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $stringa .= '
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <p class="text-right">' . $row["quantita"] . ' Products</p>
                    <img class="img-fluid w-100" src="' . $row["immagine"] . '" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">' . $row["nome"] . '</h6>
                    <div class="d-flex justify-content-center">
                        <h6>€' . $row["prezzo"] . '</h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="php/detail.php?idArticolo=' . $row["id"] . '" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>';

                $id = $_SESSION["idUtenteLog"];
                $sql2 = "SELECT ruolo FROM utente where id='$id'";
                $result2 = $conn->query($sql2);

                while ($row2 = $result2->fetch_assoc()) {
                    if ($row2["ruolo"] == 1) {
                        $stringa .= '<input type="button" value="Elimina articolo" onclick="change(' . $row["id"] . ')" class="btn btn-sm text-dark p-0"/>';
                    }
                }
                $stringa .= '
                <button type="button" class="btn btn-sm text-dark p-0" onclick="aggiungiProdotto(' . $row["id"] . ')"><i class="fas fa-shopping-cart text-primary mr-1"></i> Add To Cart</button>
                </div>
            </div>
        </div>';
            };

            echo $stringa;
            ?>
            <!-- // <h6 class="text-muted ml-2"><del>$123.00</del></h6> -->
        </div>
    </div>
    <!-- Products End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">S</span>HOPBEO</h1>
                </a>
                <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="php/shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">SHOPBEO</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="#">SHOPBEO</a><br>
                    Distributed By SHOPBEO
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>