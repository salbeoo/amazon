<?php
include("sessioni.php");
include("connection.php");

if (isset($_GET["idArticoloEliminare"])) {
    $sql = "DELETE FROM contiene_acquisto WHERE idArticolo=$_GET[idArticoloEliminare] AND idCarrello=$_SESSION[idCarrello]";
    $conn->query($sql);
}

if (isset($_GET["idArticoletto"])) {
    $sql = "UPDATE contiene_acquisto set quantita=$_GET[nProdotti] WHERE idArticolo=$_GET[idArticoletto]";
    $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SHOPBEO Cart</title>
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
                window.location.replace('cart.php?idArticoloEliminare=' + id);
            }
        }

        function addProdotto(i){
            var quantita=document.getElementById("numeroProdotti").value;
            window.location.replace('cart.php?idArticoletto=' + i+"&nProdotti="+quantita);
        }

        function decProdotto(i){
            var quantita=document.getElementById("numeroProdotti").value;
            window.location.replace('cart.php?idArticoletto=' + i+"&nProdotti="+quantita);
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

    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                        if (isset($_SESSION["idCarrello"])) {
                            $stringa = ""/* "<div class='container>" */;
                            $idCarrello = $_SESSION["idCarrello"];
                            $sql = "SELECT * FROM contiene_acquisto where idCarrello=$idCarrello ";
                            $result = $conn->query($sql);


                            $sum = 0;
                            while ($row = $result->fetch_assoc()) {
                                $articoletto = $row["idArticolo"];
                                $sql2 = "SELECT * FROM articolo where id=$articoletto";
                                $result2 = $conn->query($sql2);
                                while ($row2 = $result2->fetch_assoc()) {
                                    $sum += $row2['prezzo'] * $row["quantita"];
                                    $stringa .= '
                                    <tr>
                                    <td class="align-middle"><img src="../' . $row2["immagine"] . '" alt="" style="width: 50px;">' . $row2["nome"] . '</td>
                                    <td class="align-middle">€' . $row2["prezzo"] . '</td>
                                    <td class="align-middle">

                                    <div class="d-flex align-items-center quantity mx-auto mb-4 pt-2">
                                        <div class="input-group quantity quantity mx-auto mr-3" style="width: 130px;">
                                            <div class="input-group-btn">
                                                <button onclick="decProdotto('.$row2["id"].')" class="btn btn-primary btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="number" id="numeroProdotti" class="form-control bg-secondary text-center" min="1" value="' . $row["quantita"] . '">
                                            <div class="input-group-btn quantity mx-auto">
                                                <button onclick="addProdotto('.$row2["id"].')" class="btn btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    </td>
                                    <td class="align-middle">€' . $row2["prezzo"] * $row["quantita"] . '</td>
                                    <td class="align-middle"><button type="button" onclick="change(' . $row["idArticolo"] . ')" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                                </tr>';
                                }
                            }
                            $_SESSION["SUM"] = $sum;
                            $_SESSION["SUMTOT"] = $sum + 10;
                            echo $stringa;
                        }

                        ?>

                        <!-- <div class="input-group-btn">
                            <button class="btn btn-sm btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div> -->

                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <?php
                            if (isset($_SESSION["SUM"])) {
                                echo ' <h6 class="font-weight-medium">€' . $_SESSION["SUM"] . '</h6>';
                            } else
                                echo ' <h6 class="font-weight-medium">€0</h6>';

                            ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <?php
                            if (isset($_SESSION["SUM"])) {
                                echo '<h5 class="font-weight-bold">€' . $_SESSION["SUMTOT"] . '</h5>';
                            } else
                                echo '<h5 class="font-weight-bold">€10</h5>';

                            ?>
                        </div>
                        <a href="checkUserLog.php"> <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


    <?php
    include("viewFooter.php");
    ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>