<?php
include '../db/connect.php';
session_start();

$where = [];
if (!empty($_GET['status'])) {
    $where[] = "status = '" . $conn->real_escape_string($_GET['status']) . "'";
}
if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $where[] = "created_at BETWEEN '" . $conn->real_escape_string($_GET['from_date']) . "' AND '" . $conn->real_escape_string($_GET['to_date']) . "'";
}
if (!empty($_GET['location'])) {
    $where[] = "address LIKE '%" . $conn->real_escape_string($_GET['location']) . "%'";
}

$where_sql = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$result = $conn->query("SELECT * FROM orders $where_sql");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
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
            scale: 1.05;
            transition: all 0.3s ease-in-out;
        }
        .table-bordered th, .table-bordered td {
            vertical-align: middle;
            text-align: center;
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

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-center">Danh sách đơn hàng</h2>
        <a href="/admin/php/dashboard.php" class="btn">Quay lại Dashboard</a> <!-- Nút quay lại -->
    </div>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="status" class="form-label">Tình trạng đơn hàng</label>
                <select id="status" name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="Chưa xác nhận">Chưa xác nhận</option>
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Thành công">Thành công</option>
                    <option value="Hủy đơn">Hủy đơn</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="from_date" class="form-label">Từ ngày</label>
                <input type="date" id="from_date" name="from_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="to_date" class="form-label">Đến ngày</label>
                <input type="date" id="to_date" name="to_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="location" class="form-label">Địa điểm giao hàng</label>
                <input type="text" id="location" name="location" class="form-control" placeholder="Nhập quận, huyện, thành phố">
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
    </form>

    <form method="GET" action="/admin/php/top_customers.php" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="from_date" class="form-label">Từ ngày</label>
                <input type="date" id="from_date" name="from_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="to_date" class="form-label">Đến ngày</label>
                <input type="date" id="to_date" name="to_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">Thống kê</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM orders");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['receiver_name']}</td>
                        <td>{$row['created_at']}</td>
                        <td>" . number_format($row['total_price'], 0, ',', '.') . " VND</td>
                        <td>
                            <form method='POST' action='update_order_status.php' class='d-inline'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <select name='status' class='form-select form-select-sm' onchange='this.form.submit()'>
                                    <option value='Chưa xác nhận' " . ($row['status'] == 'Chưa xác nhận' ? 'selected' : '') . ">Chưa xác nhận</option>
                                    <option value='Đã xác nhận' " . ($row['status'] == 'Đã xác nhận' ? 'selected' : '') . ">Đã xác nhận</option>
                                    <option value='Thành công' " . ($row['status'] == 'Thành công' ? 'selected' : '') . ">Thành công</option>
                                    <option value='Hủy đơn' " . ($row['status'] == 'Hủy đơn' ? 'selected' : '') . ">Hủy đơn</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href='admin/php/view_order.php?id={$row['id']}' class='btn btn-sm'>Xem</a>
                            <a href='admin/php/delete_order.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa đơn hàng này?\")'>Xóa</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>