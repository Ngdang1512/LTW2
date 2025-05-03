<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra nếu người dùng đã chọn hình thức thanh toán
    if (!isset($_POST['payment_method'])) {
        echo "Vui lòng chọn hình thức thanh toán.";
        exit;
    }

    $payment_method = $_POST['payment_method'];
    $total_price = $_POST['total_price'];

    // Xử lý thanh toán
    if ($payment_method === 'online') {
        echo "Bạn đã chọn thanh toán trực tuyến. Tổng số tiền: " . number_format($total_price, 0, ',', '.') . " VND";
        // Thêm logic xử lý thanh toán trực tuyến tại đây
    } elseif ($payment_method === 'cash') {
        echo "Bạn đã chọn thanh toán tiền mặt khi nhận hàng. Tổng số tiền: " . number_format($total_price, 0, ',', '.') . " VND";
        // Thêm logic xử lý thanh toán tiền mặt tại đây
    } else {
        echo "Hình thức thanh toán không hợp lệ.";
    }
}
?>