<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$product_id = $_POST['product_id'] ?? null;

if ($product_id) {
    // Đưa vào giỏ hàng trước (giống addtocart)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    // Sau đó chuyển thẳng đến trang thanh toán
    header("Location: checkout.php");
    exit();
} else {
    echo "Không có sản phẩm để mua.";
}
?>