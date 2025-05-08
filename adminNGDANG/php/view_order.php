<!-- filepath: d:\xampp\htdocs\LTW2\adminNGDANG\php\view_order.php -->
<?php
include '../db_admin/connect.php';

// Kiểm tra và lấy ID đơn hàng từ URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Không tìm thấy ID đơn hàng. Vui lòng kiểm tra lại.");
}
$id = $_GET['id'];

// Lấy thông tin đơn hàng
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Lấy danh sách sản phẩm trong đơn hàng
$product_stmt = $conn->prepare("
    SELECT p.title, p.price, p.image, od.quantity 
    FROM order_details od 
    JOIN products p ON od.product_id = p.id 
    WHERE od.order_id = ?
");
$product_stmt->bind_param("i", $id);
$product_stmt->execute();
$products = $product_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table td, .table th {
            text-align: center; /* Căn giữa theo chiều ngang */
            vertical-align: middle; /* Căn giữa theo chiều dọc */
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
    <h2 class="text-center">Chi tiết đơn hàng</h2>
    <div class="mb-3">
        <strong>ID đơn hàng:</strong> <?php echo $order['id']; ?>
    </div>
    <div class="mb-3">
        <strong>Khách hàng:</strong> <?php echo $order['receiver_name']; ?>
    </div>
    <div class="mb-3">
        <strong>Ngày đặt:</strong> <?php echo $order['created_at']; ?>
    </div>
    <div class="mb-3">
        <strong>Tổng tiền:</strong> <?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND
    </div>
    <div class="mb-3">
        <strong>Trạng thái:</strong> <?php echo $order['status']; ?>
    </div>
    <h4>Sản phẩm trong đơn hàng</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo $product['image']; ?>" alt="Hình ảnh sản phẩm" style="max-width: 100px; height: auto;"></td>
                    <td><?php echo $product['title']; ?></td>
                    <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?> VND</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="order_list.php" class="btn btn-secondary">Quay lại</a>
</div>
</body>
</html>