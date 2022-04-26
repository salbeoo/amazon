<?php
include("sessioni.php");
include("connection.php");

if (isset($_GET["idArticoloEliminare"])) {
    $sql = "DELETE FROM articolo WHERE id=$_GET[idArticoloEliminare]";
    $conn->query($sql);
}

if (isset($_GET["idProdottoAcquisto"])) {

    $idArticolo = $_GET["idProdottoAcquisto"];
    $idCarrello = $_SESSION["idCarrello"];
    $quantita = 1;
    // setcookie("carrello_prodotti", $_GET["idProdottoAcquisto"], time() + (86400 * 30), "/"); // 86400 = 1 day
    $sql = $conn->prepare("INSERT INTO contiene_acquisto (idArticolo, idCarrello,quantita) VALUES (?, ?,?)");
    $sql->bind_param("iii", $idArticolo, $idCarrello, $quantita);

    // $sql="INSERT INTO contiene_acquisto (idArticolo,idCarrello) values('$idArticolo','$idCarrello')";
    // $conn->query($sql)
    if ($sql->execute() === TRUE) {
        header("location:shop.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SHOPEO STORE</title>
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

    <script>
        function change(id) {
            var richiesta = window.confirm("Vuoi cancellare l'articolo?");
            if (richiesta) {
                window.location.replace('shop.php?idArticoloEliminare=' + id);
            }
        }

        function aggiungiProdotto(i) {
            window.location.replace('shop.php?idProdottoAcquisto=' + i);
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
                <form action="shop.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="prodotto_da_cercare" placeholder="Search for products">
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
                <a href="cart.php" class="btn border">
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
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <?php
                        $categorie = ""/* "<div class='container>" */;
                        $sql = "SELECT * FROM categoria";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $categorie .= '<a href="" class="nav-item nav-link">' . $row["tipo"] . '</a>';
                        };
                        echo $categorie;
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
                            <a href="../index.php" class="nav-item nav-link">Home</a>
                            <a href="shop.php" class="nav-item nav-link active">Shop</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <?php
                            if (isset($_SESSION["email"]))
                                echo '<a href="utente.php" class="nav-item nav-link">' . $_SESSION["nome"] . '</a>'
                            ?>
                            <a href="../html/login.html" class="nav-item nav-link">Login</a>
                            <a href="../html/register.html" class="nav-item nav-link">Register</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" checked class="custom-control-input" id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] .'</span>';
                            }
                            ?>
                           
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1">
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=0 and prezzo<=100";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] .'</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2">
                            <label class="custom-control-label" for="price-2">$100 - $200</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=100 and prezzo<=200";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] .'</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3">
                            <label class="custom-control-label" for="price-3">$200 - $300</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=200 and prezzo<=300";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] .'</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4">
                            <label class="custom-control-label" for="price-4">$300 - $400</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=300 and prezzo<=400";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] .'</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-5">
                            <label class="custom-control-label" for="price-5">$400 - $500</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=400 and prezzo<=500";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] .'</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-6">
                            <label class="custom-control-label" for="price-6">>$500</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=500";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] .'</span>';
                            }
                            ?>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="shop.php">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="prodotto_da_cercare" placeholder="Search by name">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                            <input type="submit" style="display: none" class="fa fa-search bg-transparent" value="">

                                        </span>
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php

                    if (isset($_GET["prodotto_da_cercare"])) {
                        $sql = "SELECT * FROM articolo where nome like '$_GET[prodotto_da_cercare]%'";
                    } else
                        $sql = "SELECT * FROM articolo";

                    $stringa = ""/* "<div class='container>" */;
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $stringa .= '<div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <p class="text-right">' . $row["quantita"] . ' Products</p>
                                <img class="img-fluid w-100" src="../' . $row["immagine"] . '" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">' . $row["nome"] . '</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>€' . $row["prezzo"] . '</h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="detail.php?idArticolo=' . $row["id"] . '" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>';
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
                    }
                    echo $stringa;
                    ?>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->


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
                            <a class="text-dark mb-2" href="../index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        </div>
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
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../mail/jqBootstrapValidation.min.js"></script>
    <script src="../mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>