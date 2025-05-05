<?php
include "connect.php";

$id = $_POST["id"];
$result = $conn->query("SELECT sold FROM ad_products WHERE id=$id");
$row = $result->fetch_assoc();

if ($row["sold"] == 1) {
  $conn->query("UPDATE ad_products SET visible=0 WHERE id=$id");
} else {
  $conn->query("DELETE FROM ad_products WHERE id=$id");
}
?>
