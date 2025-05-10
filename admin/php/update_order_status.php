<?php
include '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: order_list.php");
        exit();
    } else {
        echo "Không thể cập nhật trạng thái đơn hàng!";
    }
}
?>