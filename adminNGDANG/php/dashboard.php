<!-- filepath: d:\xampp\htdocs\LTW2\adminNGDANG\php\dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db_admin/connect.php';

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
$result_monthly_revenue = $conn->query("SELECT SUM(total_price) AS monthly_revenue FROM orders WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
$monthly_revenue = $result_monthly_revenue->fetch_assoc()['monthly_revenue'] ?? 0;

// Truy vấn doanh thu năm nay
$result_yearly_revenue = $conn->query("SELECT SUM(total_price) AS yearly_revenue FROM orders WHERE YEAR(created_at) = YEAR(CURRENT_DATE())");
$yearly_revenue = $result_yearly_revenue->fetch_assoc()['yearly_revenue'] ?? 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Trang quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }
        .content {
            margin-left: 250px; /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
        }
        .btn {
            background-color: #000; /* Nền đen */
            color: #fff; /* Chữ trắng */
            border: 1px solid #000; /* Viền đen */
        }
        .btn:hover {
            background-color: #fff; /* Nền trắng */
            color: #000; /* Chữ đen */
            border: 1px solid #000; /* Viền đen */
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
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <a href="dashboard.php">Trang chủ</a>
            <a href="user_list.php">Quản lý người dùng</a>
            <a href="product_list.php">Quản lý sản phẩm</a>
            <a href="order_list.php">Quản lý đơn hàng</a>
            <a href="logout.php" class="btn mt-3">Đăng xuất</a>
        </div>

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
                            <a href="user_list.php" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm</h5>
                            <p class="card-text">Tổng số: <strong><?php echo $total_products; ?></strong></p>
                            <a href="product_list.php" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đơn hàng</h5>
                            <p class="card-text">Tổng số: <strong><?php echo $total_orders; ?></strong></p>
                            <a href="order_list.php" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ hoặc thông tin thêm -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thống kê doanh thu</h5>
                    <p class="card-text">Doanh thu tháng này: <strong><?php echo number_format($monthly_revenue, 0, ',', '.'); ?> VND</strong></p>
                    <p class="card-text">Doanh thu năm nay: <strong><?php echo number_format($yearly_revenue, 0, ',', '.'); ?> VND</strong></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>