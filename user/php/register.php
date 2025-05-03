<?php
include('../db/connect.php');
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email không hợp lệ.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Mật khẩu xác nhận không khớp.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Tên đăng nhập hoặc email đã tồn tại.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($insert_stmt->execute()) {
                $success_message = "Đăng ký thành công. <a href='login.php'>Đăng nhập ngay</a>";
            } else {
                $error_message = "Đăng ký thất bại. Vui lòng thử lại.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        a {
            text-decoration: none;
            color: #000;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow rounded-4 p-4">
                    <h3 class="text-center mb-4">Đăng ký</h3>
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger text-center"><?= $error_message ?></div>
                    <?php elseif ($success_message): ?>
                        <div class="alert alert-success text-center"><?= $success_message ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Đăng ký</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="/user/php/login.php">Đã có tài khoản? Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
