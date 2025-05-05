<?php
include 'connect.php';

$username = $_POST['username'];
$email = $_POST['email'];

$stmt = $conn->prepare("INSERT INTO ad_users (username, email) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();

echo "success";
?>
