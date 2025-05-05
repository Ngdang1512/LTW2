<?php
session_start();
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
// Xử lý các hành động trong giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Xử lý xóa sản phẩm
    if (isset($_POST['remove_item_id'])) {
        $remove_item_id = $_POST['remove_item_id'];
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['id'] == $remove_item_id) {
                    unset($_SESSION['cart'][$key]); // Xóa sản phẩm khỏi giỏ hàng
                    break;
                }
            }
            // Sắp xếp lại chỉ số mảng
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
    // Xử lý tăng/giảm số lượng sản phẩm
    if (isset($_POST['update_item_id']) && isset($_POST['action'])) {
        $update_item_id = $_POST['update_item_id'];
        $action = $_POST['action'];
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $update_item_id) {
                    if ($action === 'increase') {
                        $item['quantity']++; // Tăng số lượng
                    } elseif ($action === 'decrease' && $item['quantity'] > 1) {
                        $item['quantity']--; // Giảm số lượng (không giảm dưới 1)
                    }
                    break;
                }
            }
        }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>

<style>
    body {
        background-color: #ffffff;
        color: #000000;
    }

    .cart-container {
        background-color: #f2f2f2;
        border: 1px solid #ccc;
    }

    .cart-title {
        color: #000000;
    }

    .btn-primary {
        background-color: #28A745;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #28A745;
        scale: 1.05;
        transition: all 0.3s ease;
    }

    .btn-secondary {
        background-color: #000;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #fff;
        border: 1px solid #000;
        scale: 1.05;
        transition: all 0.3s ease;
        color: #000;
    }   
</style>

<body>
    
    <div class="container mt-5">
        <h2 class="mb-4">Giỏ hàng của bạn</h2>
        <?php if (!empty($cart)): ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
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
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="img-fluid" style="width: 100px;"></td>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                    <td>
                        <form action="cart.php" method="post" class="d-flex align-items-center">
                            <input type="hidden" name="update_item_id" value="<?= $item['id'] ?>">
                            <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm">-</button>
                            <input type="text" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" readonly class="form-control text-center mx-2" style="width: 50px;">
                            <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm">+</button>
                        </form>
                    </td>
                    <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</td>
                    <td>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="remove_item_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mt-4">
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
            <div class="mt-3">
                <!-- Nút tiếp tục mua hàng -->
                <a href="products.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua hàng
                </a>
                <!-- Nút thanh toán -->
                <form action="payment.php" method="POST" class="d-inline">
                    <input type="hidden" name="cart_data" value="<?= htmlspecialchars(json_encode($cart)) ?>">
                    <input type="hidden" name="total_price" value="<?= $total ?>">
                    <button type="submit" id="checkout-button" class="btn btn-primary">Thanh toán</button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <p>Giỏ hàng của bạn đang trống.</p>
        <a href="products.php" class="btn btn-secondary">Tiếp tục mua hàng</a>
        <?php endif; ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.btn-increase, .btn-decrease').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var action = button.val();
            var itemId = button.siblings('input[name="update_item_id"]').val();
            $.ajax({
                url: 'cart.php',
                type: 'POST',
                data: {
                    update_item_id: itemId,
                    action: action,
                    ajax: true // Thêm tham số để xác định yêu cầu AJAX
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    // Cập nhật số lượng và tổng giá trị giỏ hàng
                    button.siblings('input[name="quantity"]').val(data.new_quantity);
                    $('#total-price').text(data.total_price + ' VND');
                }
            });
        });
    });
    </script>
</body>
</html>
