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
    <style>
        body {
            background-color: #ffffff; /* Màu nền trắng */
            font-family: 'Roboto', sans-serif;
            color: #000000; /* Màu chữ đen */
        }
        .container {
            background-color: #ffffff; /* Màu nền trắng */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bóng mờ nhẹ */
        }
        h2 {
            font-weight: bold;
            color: #000000;
        }
        .table th {
            background-color: #000000;
            color: #ffffff;
            text-align: center;
        }
        .table td, .table th {
            text-align: center; /* Căn giữa theo chiều ngang */
            vertical-align: middle; /* Căn giữa theo chiều dọc */
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-primary {
            background-color: #000000;
            border: none;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #fff;
            color: #000;
        }
        .btn-secondary {
            background-color: #f1f1f1;
            border: none;
            color: #000000;
        }
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        .card-header {
            background-color: #000000;
            color: #ffffff;
        }
        .content {
            margin-left: 250px; /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

<div class="content mt-5">
    <h2 class="text-center mb-4">Thống kê khách hàng</h2>
    <?php if (!empty($customers) && $customers->num_rows > 0): ?>
        <?php while ($customer = $customers->fetch_assoc()): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Khách hàng: <?php echo htmlspecialchars($customer['full_name']); ?> (<?php echo htmlspecialchars($customer['username']); ?>)</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tổng tiền:</strong> <?php echo number_format($customer['total_spent'], 0, ',', '.'); ?> VND</p>
                    <p><strong>Số đơn hàng:</strong> <?php echo $customer['order_count']; ?></p>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID đơn hàng</th>
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
                                SELECT o.id, o.created_at, o.total_price, o.status
                                FROM orders o
                                WHERE o.username = ? AND o.created_at BETWEEN ? AND ?
                                ORDER BY o.created_at DESC
                            ");
                            $order_stmt->bind_param("sss", $customer['username'], $from_date, $to_date);
                            $order_stmt->execute();
                            $orders = $order_stmt->get_result();

                            while ($order = $orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['created_at']; ?></td>
                                    <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td><a href="view_order.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Xem chi tiết</a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center text-danger">Không có dữ liệu trong khoảng thời gian đã chọn.</p>
    <?php endif; ?>
    <a href="order_list.php" class="btn btn-secondary">Quay lại</a>
</div>
</body>
</html>