<?php
include "connect.php";

$id = $_POST["id"];
$status = $_POST["status"];

$stmt = $conn->prepare("UPDATE ad_users SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();
?>
