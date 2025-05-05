<?php
include "connect.php";

$name = $_POST["name"];
$category = $_POST["category"];
$image = "";

if ($_FILES["image"]["name"] != "") {
  $image = time() . "_" . basename($_FILES["image"]["name"]);
  move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
}

$stmt = $conn->prepare("INSERT INTO ad_products (name, category, image) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $category, $image);
$stmt->execute();
?>
