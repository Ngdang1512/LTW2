<!-- filepath: d:\xampp\htdocs\LTW2\adminNGDANG\php\register.php -->
<?php
include '../db_admin/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Kiểm tra xem username đã tồn tại chưa
    $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Tên người dùng đã tồn tại!";
    } else {
        // Thêm tài khoản mới
        $stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            header("Location: /adminNGDANG/php/login.php");
            exit();
        } else {
            $error = "Đã xảy ra lỗi khi đăng ký!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #212529;
            color: #fff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #fff;
            color: #212529;
            border: 1px solid #212529;
            scale: 1.02;
            transition: all 0.3s ease-in-out;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Đăng ký Admin</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Tên người dùng</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
            <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none">Đã có tài khoản? Đăng nhập</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>