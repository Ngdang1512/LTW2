<?php
session_start();
include('../db/connect.php');
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION["username"] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Sai mật khẩu.";
        }
    } else {
        $error_message = "Tài khoản không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
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
                    <h3 class="text-center mb-4">Đăng nhập</h3>
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger text-center"><?= $error_message ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Lưu tài khoản</label>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Đăng nhập</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="/user/php/register.php">Chưa có tài khoản? Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
