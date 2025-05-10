<?php
include '../db/connect.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: user_list.php");
    exit();
} else {
    echo "Không thể xóa người dùng!";
}
?>