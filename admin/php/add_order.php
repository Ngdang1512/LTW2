<?php
include '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $order_date = $_POST['order_date'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO orders (receiver_name, order_date, address, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $customer_name, $order_date, $address, $status);

    if ($stmt->execute()) {
        $success = "Đơn hàng đã được thêm thành công!";
    } else {
        $error = "Không thể thêm đơn hàng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .content {
        margin-left: 250px;
        padding: 20px;
    }
    .btn-primary{
        background-color: #000;
        color: #fff;
        border: #000;
    }
    .btn-primary:hover {
        background-color: #fff;
        color: #000;
        border: 1px solid #000;
    }
</style>

<body>
<div class="container mt-5">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <h2 class="text-center">Thêm đơn hàng</h2>

    <!-- Hiển thị thông báo -->
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form class="content" method="POST" action="">
        <div class="mb-3">
            <label for="customer_name" class="form-label">Tên khách hàng</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="order_date" class="form-label">Ngày đặt</label>
            <input type="date" class="form-control" id="order_date" name="order_date" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Chưa xác nhận">Chưa xác nhận</option>
                <option value="Đã xác nhận">Đã xác nhận</option>
                <option value="Đang giao">Đang giao</option>
                <option value="Đã giao">Đã giao</option>
                <option value="Đã hủy">Đã hủy</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm đơn hàng</button>
    </form>
</div>
</body>
</html>