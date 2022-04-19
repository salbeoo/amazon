<?php
session_start();
session_unset();
session_destroy();
// setcookie("user_name", "guest", time() + (86400 * 30), "/"); // 86400 = 1 day
setcookie("utente_id", "", time() + (86400 * 30), "/"); // 86400 = 1 day
// setcookie("utente_email", "prova@gmail.com", time() + (86400 * 30), "/"); // 86400 = 1 day
setcookie("carrello_id", "", time() + (86400 * 30), "/"); // 86400 = 1 day
header("location:../index.php");
