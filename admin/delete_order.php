<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM ad_orders WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Xóa thành công.";
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>