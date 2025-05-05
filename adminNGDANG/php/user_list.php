<!-- filepath: d:\xampp\htdocs\LTW2\adminNGDANG\php\user_list.php -->
<?php
include '../db_admin/connect.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
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
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-center">Danh sách người dùng</h2>
        <a href="dashboard.php" class="btn">Quay lại Dashboard</a> <!-- Nút quay lại -->
    </div>
    <a href="add_user.php" class="btn mb-3">Thêm người dùng</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM admin_users");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>" . ($row['status'] === 'active' ? 'Hoạt động' : 'Bị khóa') . "</td>
                        <td>
                            <a href='edit_user.php?id={$row['id']}' class='btn btn-sm'>Sửa</a>
                            <a href='delete_user.php?id={$row['id']}' class='btn btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                            <a href='lock_user.php?id={$row['id']}&status={$row['status']}' class='btn btn-sm'>
                                " . ($row['status'] === 'active' ? 'Khoá' : 'Mở') . "
                            </a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>