<?php
include "connect.php";

$id = $_POST["id"];
$name = $_POST["name"];
$category = $_POST["category"];

$stmt = $conn->prepare("UPDATE ad_products SET name=?, category=? WHERE id=?");
$stmt->bind_param("ssi", $name, $category, $id);
$stmt->execute();
?>
