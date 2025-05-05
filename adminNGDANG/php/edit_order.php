<?php
include '../db_admin/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM ad_orders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $order_date = $_POST['order_date'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE ad_orders SET customer_name = ?, order_date = ?, address = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $customer_name, $order_date, $address, $status, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Không thể cập nhật đơn hàng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Sửa đơn hàng</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="customer_name" class="form-label">Tên khách hàng</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $order['customer_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="order_date" class="form-label">Ngày đặt</label>
            <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $order['address']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Chưa xác nhận" <?php if ($order['status'] == 'Chưa xác nhận') echo 'selected'; ?>>Chưa xác nhận</option>
                <option value="Đã xác nhận" <?php if ($order['status'] == 'Đã xác nhận') echo 'selected'; ?>>Đã xác nhận</option>
                <option value="Đang giao" <?php if ($order['status'] == 'Đang giao') echo 'selected'; ?>>Đang giao</option>
                <option value="Đã giao" <?php if ($order['status'] == 'Đã giao') echo 'selected'; ?>>Đã giao</option>
                <option value="Đã hủy" <?php if ($order['status'] == 'Đã hủy') echo 'selected'; ?>>Đã hủy</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
    </form>
</div>
</body>
</html>