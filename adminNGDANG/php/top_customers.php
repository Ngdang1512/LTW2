<!-- filepath: d:\xampp\htdocs\LTW2\adminNGDANG\php\top_customers.php -->
<?php
include '../db_admin/connect.php';

if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

    // Lấy danh sách 5 khách hàng có tổng tiền mua hàng cao nhất
    $stmt = $conn->prepare("
        SELECT u.full_name, o.username, SUM(o.total_price) AS total_spent, COUNT(o.id) AS order_count
        FROM orders o
        JOIN users u ON o.username = u.username
        WHERE o.created_at BETWEEN ? AND ?
        GROUP BY o.username
        ORDER BY total_spent DESC
        LIMIT 5
    ");
    $stmt->bind_param("ss", $from_date, $to_date);
    $stmt->execute();
    $customers = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Thống kê khách hàng</h2>
    <?php if (!empty($customers) && $customers->num_rows > 0): ?>
        <?php while ($customer = $customers->fetch_assoc()): ?>
            <div class="mb-4">
                <h4>Khách hàng: <?php echo $customer['full_name']; ?> (<?php echo $customer['username']; ?>)</h4>
                <p><strong>Tổng tiền:</strong> <?php echo number_format($customer['total_spent'], 0, ',', '.'); ?> VND</p>
                <p><strong>Số đơn hàng:</strong> <?php echo $customer['order_count']; ?></p>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Lấy danh sách đơn hàng của khách hàng
                        $order_stmt = $conn->prepare("
                            SELECT o.id, o.created_at, o.total_price, o.status, u.full_name
                            FROM orders o
                            JOIN users u ON o.username = u.username
                            WHERE o.username = ? AND o.created_at BETWEEN ? AND ?
                            ORDER BY o.created_at DESC
                        ");
                        $order_stmt->bind_param("sss", $customer['username'], $from_date, $to_date);
                        $order_stmt->execute();
                        $orders = $order_stmt->get_result();

                        while ($order = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                <td><?php echo $order['created_at']; ?></td>
                                <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo $order['status']; ?></td>
                                <td><a href="view_order.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Xem chi tiết</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center">Không có dữ liệu trong khoảng thời gian đã chọn.</p>
    <?php endif; ?>
    <a href="order_list.php" class="btn btn-secondary">Quay lại</a>
</div>
</body>
</html>