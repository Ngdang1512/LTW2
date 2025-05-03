<?php
session_start();
include "../db/connect.php";

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng
$username = $_SESSION['username'];

// Truy vấn danh sách hóa đơn của người dùng
$sql_orders = "SELECT * FROM orders WHERE username = ? ORDER BY created_at DESC";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("s", $username);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();

$orders = [];
while ($row = $result_orders->fetch_assoc()) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử mua hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "header.php"; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Lịch sử mua hàng</h1>

        <?php if (empty($orders)): ?>
            <p>Bạn chưa có đơn hàng nào.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Mã đơn hàng:</strong> <?= $order['id'] ?> <br>
                        <strong>Ngày đặt:</strong> <?= $order['created_at'] ?> <br>
                        <strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VND
                    </div>
                    <div class="card-body">
                        <h5>Chi tiết đơn hàng:</h5>
                        <ul>
                            <?php
                            // Truy vấn chi tiết đơn hàng
                            $sql_details = "SELECT od.*, p.title FROM order_details od 
                                            JOIN products p ON od.product_id = p.id 
                                            WHERE od.order_id = ?";
                            $stmt_details = $conn->prepare($sql_details);
                            $stmt_details->bind_param("i", $order['id']);
                            $stmt_details->execute();
                            $result_details = $stmt_details->get_result();

                            while ($detail = $result_details->fetch_assoc()):
                            ?>
                                <li>
                                    <?= htmlspecialchars($detail['title']) ?> x <?= $detail['quantity'] ?> - 
                                    <?= number_format($detail['price'] * $detail['quantity'], 0, ',', '.') ?> VND
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>