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
                header("location:categorie.php?categoriaS="+$_GET["categoriaS"]);
            }
        } else {

            // setcookie("carrello_prodotti", $_GET["idProdottoAcquisto"], time() + (86400 * 30), "/"); // 86400 = 1 day
            $sql = $conn->prepare("INSERT INTO contiene_acquisto (idArticolo, idCarrello,quantita) VALUES (?, ?,?)");
            $sql->bind_param("iii", $idArticolo, $idCarrello, $quantita);
            // echo $sql;

            // $sql="INSERT INTO contiene_acquisto (idArticolo,idCarrello) values('$idArticolo','$idCarrello')";
            // $conn->query($sql)
            if ($sql->execute() === TRUE) {
                header("location:categorie.php?categoriaS="+$_GET["categoriaS"]);
            }
        }
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
        function change(id,stringaUrl) {
            var richiesta = window.confirm("Vuoi cancellare l'articolo?");
            if (richiesta) {
                window.location.replace('categorie.php?idArticoloEliminare=' + id+"&categoriaS="+stringaUrl);
            }
        }

        function aggiungiProdotto(i,stringaUrl) {
            window.location.replace('categorie.php?idProdottoAcquisto=' + i+"&categoriaS="+stringaUrl);
            // setcookie("carrello_prodotti", i, time() + (86400 * 30), "/"); // 86400 = 1 day
        }

        function filtra(stringaUrl) {
            let c, s, z, a, b, x;
            c = document.getElementById("price-1").checked;
            s = document.getElementById("price-2").checked;
            z = document.getElementById("price-3").checked;
            a = document.getElementById("price-4").checked;
            b = document.getElementById("price-5").checked;
            x = document.getElementById("price-6").checked;

            let sql = "SELECT * FROM articolo join categoria on articolo.idCategoria=categoria.codice WHERE categoria.tipo='"+stringaUrl+"' ";
            let i = false;
            if (c == true) {
                i = true;
                sql += "prezzo >=0 AND prezzo<=100  ";
            } else if (s == true) {
                sql += and(i);
                sql += "prezzo >=100 AND prezzo<=200  ";
                i = true;
            } else if (z == true) {
                sql += and(i);
                sql += "prezzo >=200 AND prezzo<=300  ";
                i = true;
            } else if (a == true) {
                sql += and(i);
                sql += "prezzo >=300 AND prezzo<=400  ";
                i = true;
            } else if (b == true) {
                sql += and(i);
                sql += "prezzo >=400 AND prezzo<=500  ";
                i = true;
            } else if (x == true) {
                sql += and(i);
                sql += "prezzo >=500  ";
                i = true;
            }else
                sql = "SELECT * FROM articolo join categoria on articolo.idCategoria=categoria.codice WHERE categoria.tipo='"+stringaUrl+"'";
            window.location.replace("categorie.php?categoriaS="+stringaUrl+"&sql="+sql);
        }

        // function and(i) {
        //     if (i == true) {
        //         return " AND ";
        //     } else
        //         return "";
        // }
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


    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">
                <?php
                    echo $_GET["categoriaS"]
                ?>
            </h1>
        </div>
    </div>

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
                            <?php
                            echo '<input type="radio" name="radioBB" checked class="custom-control-input" id="price-all" onclick="filtra('.$_GET["categoriaS"].')>';
                            ?>
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] . '</span>';
                            }
                            ?>

                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <?php
                            echo '<input type="radio" name="radioBB"  class="custom-control-input" id="price-1" onclick="filtra('.$_GET["categoriaS"].')">';
                            ?>
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=0 and prezzo<=100";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] . '</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <?php
                            echo '<input type="radio" name="radioBB"  class="custom-control-input" id="price-2" onclick="filtra('.$_GET["categoriaS"].')">';
                            ?>
                            <label class="custom-control-label" for="price-2">$100 - $200</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=100 and prezzo<=200";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] . '</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <?php
                            echo '<input type="radio" name="radioBB"  class="custom-control-input" id="price-3" onclick="filtra('.$_GET["categoriaS"].')">';
                            ?>
                            <label class="custom-control-label" for="price-3">$200 - $300</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=200 and prezzo<=300";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] . '</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <?php
                            echo '<input type="radio" name="radioBB"  class="custom-control-input" id="price-4" onclick="filtra('.$_GET["categoriaS"].')">';
                            ?>
                            <label class="custom-control-label" for="price-4">$300 - $400</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=300 and prezzo<=400";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] . '</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <?php
                            echo '<input type="radio" name="radioBB"  class="custom-control-input" id="price-5" onclick="filtra('.$_GET["categoriaS"].')">';
                            ?>
                            <label class="custom-control-label" for="price-5">$400 - $500</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=400 and prezzo<=500";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] . '</span>';
                            }
                            ?>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <?php
                            echo '<input type="radio" name="radioBB"  class="custom-control-input" id="price-6" onclick="filtra('.$_GET["categoriaS"].')">';
                            ?>
                            <label class="custom-control-label" for="price-6">>$500</label>
                            <?php
                            $sql = "SELECT count(*) FROM articolo where prezzo>=500";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo '<span class="badge border font-weight-normal">' . $row["count(*)"] . '</span>';
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
                    } else if (isset($_GET["sql"]))
                        $sql = $_GET["sql"];
                    else
                        $sql = "SELECT * FROM articolo join categoria on articolo.idCategoria=categoria.codice WHERE categoria.tipo='".$_GET["categoriaS"]."'";

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
                                $stringa .= '<input type="button" value="Elimina articolo" onclick="change('. $row["id"] . ',"'.$_GET["categoriaS"].'")" class="btn btn-sm text-dark p-0"/>';
                            }
                        }
                        $stringa .= '
                                <button type="button" class="btn btn-sm text-dark p-0" onclick="aggiungiProdotto(' . $row["id"] . ',"'.$_GET["categoriaS"].'")"><i class="fas fa-shopping-cart text-primary mr-1"></i> Add To Cart</button>
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


    <?php
    include("viewFooter.php");
    ?>


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