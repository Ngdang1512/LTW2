<?php
include 'db.php';

$customer_name = $_POST['customer_name'];
$order_date = $_POST['order_date'];
$address = $_POST['address'];
$status = $_POST['status'];

$sql = "INSERT INTO orders (customer_name, order_date, address, status)
        VALUES ('$customer_name', '$order_date', '$address', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "Thêm đơn hàng thành công.";
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>