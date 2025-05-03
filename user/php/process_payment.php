<?php
session_start();
include "../db/connect.php";

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra nếu giỏ hàng trống
if (!isset($_POST['cart_data']) || empty($_POST['cart_data'])) {
    header("Location: cart.php");
    exit();
}

// Lấy thông tin từ form
$receiver_name = trim($_POST['receiver_name']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);
$email = trim($_POST['email']);
$note = trim($_POST['note']);
$payment_method = $_POST['payment_method'];
$total_price = $_POST['total_price'];
$cart = json_decode($_POST['cart_data'], true);

// Lưu thông tin đơn hàng vào cơ sở dữ liệu
$stmt = $conn->prepare("INSERT INTO orders (username, receiver_name, phone, address, email, note, payment_method, total_price, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssssssd", $_SESSION['username'], $receiver_name, $phone, $address, $email, $note, $payment_method, $total_price);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // Lưu chi tiết đơn hàng
    foreach ($cart as $item) {
        $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // Xóa giỏ hàng
    unset($_SESSION['cart']);
    $_SESSION['cart_count'] = 0;

    // Chuyển hướng đến trang xác nhận thanh toán thành công
    header("Location: payment_success.php?order_id=$order_id");
    exit();
} else {
    echo "Đặt hàng thất bại. Vui lòng thử lại.";
}
?>