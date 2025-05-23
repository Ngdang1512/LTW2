<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../db/connect.php';

// Kiểm tra trạng thái đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}

// Lấy danh sách đơn hàng của người dùng
$sql_orders = "SELECT * FROM orders WHERE username = ? ORDER BY created_at DESC";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("s", $username);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();

$orders = [];
if ($result_orders->num_rows > 0) {
    while ($row = $result_orders->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $birthdate = $conn->real_escape_string($_POST['birthdate']);
    $gender = $conn->real_escape_string($_POST['gender']);

    $sql = "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$phone', address = '$address', birthdate = '$birthdate', gender = '$gender' WHERE username = '$username'";
    if ($conn->query($sql) === TRUE) {
        header("Location: user-info.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Xử lý đổi mật khẩu
$success_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu hiện tại
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            // Mã hóa mật khẩu mới
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Cập nhật mật khẩu trong cơ sở dữ liệu
            $sql = "UPDATE users SET password = '$hashed_password', updated_at = NOW() WHERE username = '$username'";
            if ($conn->query($sql) === TRUE) {
                $success_message = "Đổi mật khẩu thành công.";
            } else {
                echo "<div class='alert alert-danger'>Lỗi: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Mật khẩu mới và xác nhận mật khẩu không khớp.</div>";
        }
    } else {
        $success_message = "Mật khẩu không đúng.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Tài Khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            color: #000;
        }
        .user-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            border: 1px solid #000;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #000;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            background-color: #000;
            color: #fff;
        }
        .btn {
            border: 1px solid #000;
            color: #000;
            background-color: #fff;
        }
        .btn:hover {
            background-color: #000;
            color: #fff;
        }
        .modal {
            display: none; /* Ẩn modal mặc định */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Màu nền mờ */
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
            border-radius: 8px;
        }
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close-btn:hover,
        .close-btn:focus {
            color: #ff4d4d;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <?php if (!empty($success_message)): ?>
        <div id="successModal" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close-btn" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
                <p><?= htmlspecialchars($success_message); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="user-container">
        <!-- Thông tin tài khoản -->
        <div class="card">
            <div class="card-header">
                Thông Tin Tài Khoản
            </div>
            <div class="card-body">
                <?php if (isset($_GET['edit']) && $_GET['edit'] == 'true'): ?>
                    <!-- Form chỉnh sửa thông tin -->
                    <form action="user-info.php" method="POST">
                        <input type="hidden" name="update_info" value="1">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên người dùng:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Họ và tên:</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ:</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Ngày sinh:</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= htmlspecialchars($user['birthdate'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Giới tính:</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="Nam" <?= (isset($user['gender']) && $user['gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                <option value="Nữ" <?= (isset($user['gender']) && $user['gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                <option value="Khác" <?= (isset($user['gender']) && $user['gender'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        <a href="user-info.php" class="btn btn-secondary">Hủy</a>
                    </form>
                <?php else: ?>
                    <!-- Hiển thị thông tin tài khoản -->
                    <p><strong>Tên người dùng:</strong> <?= htmlspecialchars($user['username']); ?></p>
                    <p><strong>Họ và tên:</strong> <?= htmlspecialchars($user['full_name'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Ngày sinh:</strong> <?= htmlspecialchars($user['birthdate'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Giới tính:</strong> <?= htmlspecialchars($user['gender'] ?? 'Chưa cập nhật'); ?></p>
                    <a href="user-info.php?edit=true" class="btn btn-primary mt-3">Chỉnh sửa thông tin</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Đổi mật khẩu -->
        <div class="card">
            <div class="card-header">
                Đổi Mật Khẩu
            </div>
            <div class="card-body">
                <form action="user-info.php" method="POST">
                    <input type="hidden" name="change_password" value="1">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại:</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới:</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-success">Đổi mật khẩu</button>
                </form>
            </div>
        </div>

        <!-- Đơn hàng -->
        <div class="card">
            <div class="card-header">
                Đơn Hàng Của Bạn
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <p>Không có đơn hàng nào.</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong>Mã đơn hàng:</strong> <?= $order['id'] ?> <br>
                                <strong>Ngày đặt:</strong> <?= $order['created_at'] ?> <br>
                                <strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VND
                            </div>
                            <div class="card-body">
                                <h5>Chi tiết đơn hàng:</h5>
                                <ul>
                                    <?php
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
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        document.getElementById('edit-button').addEventListener('click', function () {
            document.getElementById('edit-form').style.display = 'block';
        });

        document.getElementById('cancel-button').addEventListener('click', function () {
            document.getElementById('edit-form').style.display = 'none';
        });
    </script>

</body>
</html>