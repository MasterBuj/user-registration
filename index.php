<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
}
session_unset();
session_write_close();
$url = "view/login.view.php";
header("Location: $url");