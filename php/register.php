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
    <title>Inserimento</title>

    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">

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

    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script>
        function controllaPassword() {
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;
            if (pass1 == pass2) {
                document.getElementById("flag").style.backgroundColor = "green";
                document.getElementById("flag").style.display = "block";
                document.getElementById("flag").innerHTML = "Password coincidono";
            } else {
                document.getElementById("flag").style.backgroundColor = "red";
                document.getElementById("flag").style.display = "block";
                document.getElementById("flag").innerHTML = "Password non coincidono";
            }
        }
    </script>

    <style>
        .float-left {
            float: left;
        }
    </style>
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
            <?php
            echo '<h1 class="font-weight-semi-bold text-uppercase mb-3">sign up</h1>';
            ?>

        </div>
    </div>

    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <form class="login100-form validate-form flex-sb flex-w" action="checkRegistrazione.php" method="post">
                    <!-- METTI RIFERIMENTO AL METHOD E ACTION -->
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" name="nome" placeholder="Nome" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="cognome" placeholder="Cognome" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="email" name="email" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Genere</label>
                                <select class="form-control" name="genere" required>
                                    <option disabled selected hidden>Genere</option>
                                    <option>Uomo</option>
                                    <option>Donna</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Date of birth</label>
                                <input class="form-control" type="text" name="dataNascita" placeholder="01/01/2003" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Password</label>
                                <input class="form-control" type="password" id="pass1" name="password" placeholder="Password" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Conferma password</label>
                                <input class="form-control" type="password" id="pass2" name="confermaPassword" placeholder="Conferma password" onblur="controllaPassword()" required>
                            </div>

                            <div class="col-md-6 form-group">
                            <label></label>
                                
                            <span class="form-control" id="flag" style="text-align: center;padding: 10px;color: black; display: none;"></span>

                            </div>

                            <span class="input100" id="flag" style="text-align: center;padding: 20px;color: black; display: none;"></span>
                            <span class="focus-input100"></span>
                            
                            <div class="col-md-12 form-group">
                                
                                <div>
                                    <a href="login.php" class="txt1">
                                        <!-- METTI RIFERIMENTO AL link -->
                                        Sei già registrato? Clicca qui.
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="container-login100-form-btn m-t-17">
                        <button class="login100-form-btn" type="submit">
                            Registrati
                        </button>
                    </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

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