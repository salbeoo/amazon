<?php
include("sessioni.php");
include("connection.php");


if($_SESSION["idUtenteLog"]==-1){
    header("location:../html/register.html");
}else
    header("location:checkout.php");
