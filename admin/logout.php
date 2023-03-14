<?php 
require "../db_connect.php";
unset($_SESSION['logged_user']);

//Перебрасываем после выхода
header('Location: login.php');
?>