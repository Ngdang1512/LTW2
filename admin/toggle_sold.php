<?php
include "connect.php";

$id = $_POST["id"];
$sold = $_POST["sold"];

$stmt = $conn->prepare("UPDATE products SET sold=? WHERE id=?");
$stmt->bind_param("ii", $sold, $id);
$stmt->execute();
?>
