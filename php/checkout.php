<?php
include("sessioni.php");
include("connection.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CHECKOUT</title>
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
</head>

<body>
    <!-- Topbar Start -->
    <!-- Navbar Start -->
    <?php
    include("viewNavbar.php");
    ?>
    <!-- Navbar End -->
    <!-- Topbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <form action="doCheckOut.php" method="POST">
            <div class="row px-xl-5">

                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Mobile </label>
                                <input class="form-control" type="text" placeholder="+123 456 789" name="mobile" require>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" name="country">
                                    <option selected>United States</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address </label>
                                <input class="form-control" type="text" placeholder="123 Street" name="address" require>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" placeholder="New York" name="city" require>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Postal code</label>
                                <input class="form-control" type="text" placeholder="123" name="code" require>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>
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
                                    <div class="d-flex justify-content-between">
                                    <p>' . $row2["nome"] . '</p>
                                    <p>€' . $row2["prezzo"] * $row["quantita"] . '</p>
                                </div>
                                ';
                                    }
                                }
                                $_SESSION["SUM"] = $sum;
                                $_SESSION["SUMTOT"] = $sum + 10;
                                echo $stringa;
                            }
                            ?>

                            <hr class="mt-0">
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
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="paypal" require>
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="directcheck" require>
                                    <label class="custom-control-label" for="directcheck">Direct Check</label>
                                </div>
                            </div>
                            <div class="">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="banktransfer" require>
                                    <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <input type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" value="Place order"></input>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <!-- Checkout End -->


    <?php
    include("viewFooter.php");
    ?>


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