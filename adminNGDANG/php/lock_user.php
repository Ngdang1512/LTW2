<?php
include '../db_admin/connect.php';

$id = $_GET['id'];
$status = $_GET['status'] === 'active' ? 'inactive' : 'active';

$stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: user_list.php");
    exit();
} else {
    echo "Không thể cập nhật trạng thái người dùng!";
}
?>