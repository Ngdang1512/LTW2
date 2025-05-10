<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db/connect.php';

// Truy vấn tổng số người dùng
$result_users = $conn->query("SELECT COUNT(*) AS total_users FROM users");
$total_users = $result_users->fetch_assoc()['total_users'];

// Truy vấn tổng số sản phẩm
$result_products = $conn->query("SELECT COUNT(*) AS total_products FROM products");
$total_products = $result_products->fetch_assoc()['total_products'];

// Truy vấn tổng số đơn hàng
$result_orders = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
$total_orders = $result_orders->fetch_assoc()['total_orders'];

// Truy vấn doanh thu tháng này
$result_monthly_revenue = $conn->query("
    SELECT SUM(total_price) AS monthly_revenue 
    FROM orders 
    WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
      AND YEAR(created_at) = YEAR(CURRENT_DATE()) 
      AND status = 'Thành công'
");
$monthly_revenue = $result_monthly_revenue->fetch_assoc()['monthly_revenue'] ?? 0;

// Truy vấn doanh thu năm nay
$result_yearly_revenue = $conn->query("
    SELECT SUM(total_price) AS yearly_revenue 
    FROM orders 
    WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) 
      AND status = 'Thành công'
");
$yearly_revenue = $result_yearly_revenue->fetch_assoc()['yearly_revenue'] ?? 0;

// Truy vấn doanh thu theo tháng trong năm hiện tại
$monthly_revenue_data = [];
for ($i = 1; $i <= 12; $i++) {
    $result = $conn->query("
        SELECT SUM(total_price) AS revenue 
        FROM orders 
        WHERE MONTH(created_at) = $i 
          AND YEAR(created_at) = YEAR(CURRENT_DATE()) 
          AND status = 'Thành công'
    ");
    $monthly_revenue_data[] = $result->fetch_assoc()['revenue'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Trang quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .btn {
            background-color: #000;
            color: #fff;
            border: 1px solid #000;
        }
        .btn:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card h5 {
            font-size: 1.25rem;
        }
        .card .card-body {
            text-align: center;
        }
        .content {
            margin-left: 550px; /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Nội dung chính -->
        <div class="content">
            <h1 class="text-center mb-4">Chào mừng đến với Admin Panel</h1>
            <p class="text-center mb-5">Quản lý hệ thống cửa hàng cầu lông của bạn một cách dễ dàng.</p>

            <!-- Cards hiển thị tổng quan -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Người dùng</h5>
                            <p class="card-text">Tổng số: <strong><?php echo $total_users; ?></strong></p>
                            <a href="/admin/php/user_list.php" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm</h5>
                            <p class="card-text">Tổng số: <strong><?php echo $total_products; ?></strong></p>
                            <a href="/admin/php/product_list.php" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đơn hàng</h5>
                            <p class="card-text">Tổng số: <strong><?php echo $total_orders; ?></strong></p>
                            <a href="/admin/php/order_list.php" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Thống kê tổng doanh thu</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Loại doanh thu</th>
                                <th>Số tiền (VND)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Doanh thu tháng này</td>
                                <td><strong><?php echo number_format($monthly_revenue, 0, ',', '.'); ?></strong></td>
                            </tr>
                            <tr>
                                <td>Doanh thu năm nay</td>
                                <td><strong><?php echo number_format($yearly_revenue, 0, ',', '.'); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Biểu đồ doanh thu dạng đường -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Biểu đồ doanh thu (vùng)</h5>
                    <canvas id="area-chart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Biểu đồ dạng vùng (Area Chart)
        const areaCtx = document.getElementById('area-chart').getContext('2d');
        const revenueAreaChart = new Chart(areaCtx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: <?php echo json_encode($monthly_revenue_data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền vùng
                    borderColor: 'rgba(75, 192, 192, 1)', // Màu đường viền
                    borderWidth: 2,
                    fill: true, // Bật chế độ vùng
                    tension: 0.4 // Làm mượt đường
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true, // Hiển thị chú thích
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // Ẩn lưới trục X
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)' // Màu lưới trục Y
                        }
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>