<?php
include 'db.php';

$id = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE orders SET status='$status' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Cập nhật thành công.";
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>