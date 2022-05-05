<?php


$stringaNav = '

    <div class="container-fluid">
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="../index.php" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"></span>SHOPBEO</h1>
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
                ';

$idCarrello = $_SESSION["idCarrello"];
$sql = "SELECT count(*) FROM contiene_acquisto where idCarrello=$idCarrello ";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $stringaNav .= '<span class="badge">' . $row["count(*)"] . '</span>';
}
$stringaNav .= '
            </a>
        </div>
    </div>
    </div>


    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 2;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        ';

$sql = "SELECT * FROM categoria";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $stringaNav .= '<a href="categorie.php?categoriaS=' . $row["tipo"] . '" class="nav-item nav-link">' . $row["tipo"] . '</a>';
};
$stringaNav .= '
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">S</span>HOPBEO</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="../index.php" class="nav-item nav-link">Home</a>
                            <a href="shop.php" class="nav-item nav-link">Shop</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            ';

if (isset($_SESSION["email"]))
    $stringaNav .= '<a href="utente.php" class="nav-item nav-link">' . $_SESSION["nome"] . '</a>';
else {
    $stringaNav .= '    
    <a href="login.php" class="nav-item nav-link">Login</a>
    <a href="register.php" class="nav-item nav-link">Register</a>
    ';
}
$stringaNav .= '
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
';
echo $stringaNav;
