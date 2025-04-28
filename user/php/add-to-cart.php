<!-- filepath: d:\xampp\htdocs\LTW\user\php\add-to-cart.php -->
<?php
session_start();

// Lấy dữ liệu từ form
$product_id = $_POST['product_id'];
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// Kiểm tra hành động tăng hoặc giảm số lượng
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'increase') {
        $quantity += 1;
    } elseif ($_POST['action'] === 'decrease') {
        $quantity -= 1;
        if ($quantity < 1) {
            $quantity = 1; // Đảm bảo số lượng không nhỏ hơn 1
        }
    }
}

// Lưu số lượng vào session hoặc cơ sở dữ liệu
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$_SESSION['cart'][$product_id]['quantity'] = $quantity;

// Chuyển hướng trở lại trang chi tiết sản phẩm
header("Location: /user/php/products-detail.php");
exit;
?>