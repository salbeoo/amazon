<?php
session_start();
session_unset();
session_destroy();
// setcookie("user_name", "guest", time() + (86400 * 30), "/"); // 86400 = 1 day
header("location:../index.php");
