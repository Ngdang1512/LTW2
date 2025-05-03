<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_title = $_POST['product_title'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = isset($_POST['product_quantity']) ? intval($_POST['product_quantity']) : 1;

    // Tạo mảng sản phẩm
    $product = [
        'id' => $product_id,
        'title' => $product_title,
        'price' => $product_price,
        'image' => $product_image,
        'quantity' => $product_quantity
    ];

    // Kiểm tra nếu giỏ hàng chưa tồn tại, tạo giỏ hàng
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Luôn thêm sản phẩm mới vào giỏ hàng
    $_SESSION['cart'][] = $product;

    // Tăng số lượng sản phẩm trên biểu tượng giỏ hàng
    if (!isset($_SESSION['cart_count'])) {
        $_SESSION['cart_count'] = 0;
    }
    $_SESSION['cart_count']++;

    // Trả về số lượng sản phẩm trên biểu tượng giỏ hàng
    echo json_encode(['cart_count' => $_SESSION['cart_count']]);
    exit;
}