<?php
include("sessioni.php");
include("connection.php");


if($_SESSION["idUtenteLog"]==-1){
    header("location:register.php");
}else
    header("location:checkout.php");
