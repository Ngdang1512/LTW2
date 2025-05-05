<?php
session_start();
include "../db/connect.php";
// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Khởi tạo giỏ hàng và tổng giá trị
$cart = [];
$total_price = 0;

if (isset($_SESSION['buy_now'])) {
    // Xử lý "Mua ngay"
    $cart[] = $_SESSION['buy_now'];
    $total_price = $_SESSION['buy_now']['price'] * $_SESSION['buy_now']['quantity'];
    unset($_SESSION['buy_now']); // Xóa sản phẩm "Mua ngay" sau khi xử lý
} elseif (isset($_POST['cart_data'])) {
    // Xử lý thanh toán từ giỏ hàng
    $cart = json_decode($_POST['cart_data'], true);
    $total_price = $_POST['total_price'];
}
// Nếu giỏ hàng trống, chuyển hướng về trang giỏ hàng
if (empty($cart)) {
    header("Location: cart.php");
    exit();
}
// Lấy thông tin người dùng từ cơ sở dữ liệu
$username = $_SESSION['username'];
$sql_user = "SELECT * FROM users WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 0) {
    die("Không tìm thấy thông tin người dùng. Vui lòng kiểm tra lại.");
}

$user = $result_user->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badminton Racket Store - Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            font-weight: bold;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #000;
            border: none;
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #fff;
            color: #000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Thanh toán</h1>
        <div class="row">
            <!-- Thông tin nhận hàng -->
            <div class="col-md-6">
                <h2>Thông tin nhận hàng</h2>
                <form action="process_payment.php" method="POST">
                    <div class="mb-3">
                        <label for="receiver_name" class="form-label">Họ và tên người nhận hàng</label>
                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>
            </div>

            <!-- Đơn hàng -->
            <div class="col-md-6">
                <h2>Đơn hàng</h2>
                <?php foreach ($cart as $item): ?>
                <div class="d-flex justify-content-between mb-3">
                    <span><?= htmlspecialchars($item['title']) ?> x <?= htmlspecialchars($item['quantity']) ?></span>
                    <span><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</span>
                </div>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Tổng cộng:</span>
                    <span><?= number_format($total_price, 0, ',', '.') ?> VND</span>
                </div>
                <input type="hidden" name="cart_data" value="<?= htmlspecialchars(json_encode($cart)) ?>">
                <input type="hidden" name="total_price" value="<?= $total_price ?>">
            </div>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="mt-4">
            <h2>Phương thức thanh toán</h2>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" required>
                <label class="form-check-label" for="cod">
                    Thanh toán khi nhận hàng (COD)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="online" value="online" required>
                <label class="form-check-label" for="online">
                    Thanh toán trực tuyến
                </label>
            </div>
        </div>

        <!-- Nút đặt hàng -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary btn-lg">ĐẶT HÀNG</button>
        </div>
        </form>
    </div>
</body>
</html>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
</html>