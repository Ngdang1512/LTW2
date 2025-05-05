<!-- filepath: d:\xampp\htdocs\LTW2\adminNGDANG\logout.php -->
<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>