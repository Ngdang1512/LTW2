<?php
session_start();
include "../db/connect.php";

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin đơn hàng từ URL
if (!isset($_GET['order_id'])) {
    echo "Không tìm thấy hóa đơn.";
    exit();
}

$order_id = intval($_GET['order_id']);
$username = $_SESSION['username'];

// Lấy thông tin đơn hàng
$sql_order = "SELECT * FROM orders WHERE id = ? AND username = ?";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("is", $order_id, $username);
$stmt_order->execute();
$result_order = $stmt_order->get_result();

if ($result_order->num_rows === 0) {
    echo "Không tìm thấy hóa đơn.";
    exit();
}

$order = $result_order->fetch_assoc();

// Lấy chi tiết sản phẩm trong đơn hàng
$sql_details = "SELECT od.*, p.title FROM order_details od 
                JOIN products p ON od.product_id = p.id 
                WHERE od.order_id = ?";
$stmt_details = $conn->prepare($sql_details);
$stmt_details->bind_param("i", $order_id);
$stmt_details->execute();
$result_details = $stmt_details->get_result();

// Lấy thông tin thẻ thanh toán (nếu có)
$sql_card = "SELECT * FROM payment_cards WHERE order_id = ?";
$stmt_card = $conn->prepare($sql_card);
$stmt_card->bind_param("i", $order_id);
$stmt_card->execute();
$result_card = $stmt_card->get_result();
$card = $result_card->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h1 class="text-success">Thanh toán thành công!</h1>
        <div class="card mt-4">
            <div class="card-header">
                <strong>Mã đơn hàng:</strong> <?= $order['id'] ?><br>
                <strong>Ngày đặt:</strong> <?= $order['created_at'] ?><br>
                <strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VND
            </div>
            <div class="card-body">
                <h5>Chi tiết đơn hàng:</h5>
                <ul>
                    <?php while ($detail = $result_details->fetch_assoc()): ?>
                        <li>
                            <?= htmlspecialchars($detail['title']) ?> x <?= $detail['quantity'] ?> - 
                            <?= number_format($detail['price'] * $detail['quantity'], 0, ',', '.') ?> VND
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php if ($card): ?>
                    <h5 class="mt-4">Thông tin thẻ thanh toán:</h5>
                    <p><strong>Ngân hàng:</strong> <?= htmlspecialchars($card['bank_name']) ?></p>
                    <p><strong>Tên chủ thẻ:</strong> <?= htmlspecialchars($card['card_holder']) ?></p>
                    <p><strong>Ngày hết hạn:</strong> <?= htmlspecialchars($card['card_expiry']) ?></p>
                    <p><strong>Số thẻ:</strong> <?= htmlspecialchars($card['card_serial']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <a href="index.php" class="btn btn-primary mt-4">Quay về trang chủ</a>
    </div>
</body>
</html>