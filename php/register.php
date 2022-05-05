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
        .float-left{
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

    <div class="center" style="  display: flex;justify-content: center;">
        <div class="wrap-login100 p-t-50 p-b-90">
            <form class="login100-form validate-form flex-sb flex-w" action="checkRegistrazione.php" method="post">
                <!-- METTI RIFERIMENTO AL METHOD E ACTION -->

                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <input class="input100" type="text" name="nome" placeholder="Nome" required>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <input class="input100" type="text" name="cognome" placeholder="Cognome" required>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <input class="input100" type="text" name="dataNascita" placeholder="01/01/2003" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <select class="input100" name="genere" required>
                        <option disabled selected hidden>Genere</option>
                        <option>Uomo</option>
                        <option>Donna</option>
                    </select>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <input class="input100" type="email" name="email" placeholder="Email" required>
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <input class="input100" type="password" id="pass1" name="password" placeholder="Password" required>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <input class="input100" type="password" id="pass2" name="confermaPassword" placeholder="Conferma password" onblur="controllaPassword()" required>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                    <span class="input100" id="flag" style="text-align: center;padding: 20px;color: black; display: none;"></span>
                    <span class="focus-input100"></span>
                </div>

                <div class="flex-sb-m w-full p-t-3 p-b-24">
                    <div>
                        <a href="login.php" class="txt1">
                            <!-- METTI RIFERIMENTO AL link -->
                            Sei già registrato? Clicca qui.
                        </a>
                    </div>
                </div>

                <div class="container-login100-form-btn m-t-17">
                    <button class="login100-form-btn" type="submit">
                        Registrati
                    </button>
                </div>

            </form>
        </div>
    </div>

    <?php
    include("viewFooter.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>