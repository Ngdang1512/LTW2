<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item_id'])) {
    $remove_item_id = $_POST['remove_item_id'];

    // Kiểm tra nếu giỏ hàng tồn tại
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $remove_item_id) {
                unset($_SESSION['cart'][$key]); // Xóa sản phẩm khỏi giỏ hàng
                break;
            }
        }

        // Sắp xếp lại chỉ số mảng
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        // Cập nhật lại số lượng sản phẩm trên biểu tượng giỏ hàng
        $_SESSION['cart_count'] = count($_SESSION['cart']);
    }
}

// Hiển thị giỏ hàng
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="cart-container">
   
        <h2>Giỏ hàng của bạn</h2>
        <?php if (!empty($cart)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" style="width: 100px;"></td>
                            <td><?= htmlspecialchars($item['title']) ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</td>
                            <td>
                                <form action="cart.php" method="post" style="display:inline;">
                                    <input type="hidden" name="remove_item_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-summary">
                <h3>Tổng giá trị: 
                    <span id="total-price">
                        <?php
                        $total = 0;
                        foreach ($cart as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                        echo number_format($total, 0, ',', '.') . " VND";
                        ?>
                    </span>
                </h3>
                <div class="cart-actions">
                    <!-- Nút tiếp tục mua hàng -->
                    <a href="products.php" class="btn btn-continue-shopping">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua hàng
                    </a>
                    <!-- Nút thanh toán -->
                    <form action="payment.php" method="POST">
                    <input type="hidden" name="cart_data" value="<?= htmlspecialchars(json_encode($cart)) ?>">
                    <input type="hidden" name="total_price" value="<?= $total ?>">
                    <button type="submit" id="checkout-button" class="btn btn-primary mt-3">Thanh toán</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="products.php" class="btn btn-secondary">Tiếp tục mua hàng</a>
        <?php endif; ?>
    </div>
</body>
</html>