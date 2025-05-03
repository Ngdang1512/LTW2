<?php
session_start(); 
include('../db/connect.php');
$success_message = ""; // Biến lưu thông báo thành công
$error_message = ""; // Biến lưu thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sử dụng prepared statement nhưng kiểm tra mật khẩu đúng cách hơn
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Sai mật khẩu.";
        }
    } else {
        $error_message = "Sai tài khoản hoặc mật khẩu.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(to bottom, #000000, #1a1a1a); /* Tăng độ sáng của gradient */
        color: #ffffff;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.15); /* Tăng độ sáng của nền card */
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }
    .card-header {
        background-color: transparent;
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: bold;
    }
    .form-control {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.4); /* Tăng độ sáng của viền */
    }
    .form-control::placeholder {
        color: #cccccc; /* Tăng độ sáng của placeholder */
    }
    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.3);
        border-color: #ffffff;
        box-shadow: none;
    }
    .btn-primary {
        background-color: #ffffff;
        color: #000000;
        border: none;
        font-weight: bold;
    }
    .btn-primary:hover {
        background-color: #cccccc;
        color: #000000;
    }
    .alert {
        background-color: rgba(255, 0, 0, 0.9); /* Tăng độ sáng của thông báo lỗi */
        color: #ffffff;
        border: none;
    }
    a {
        color: #ffffff;
        text-decoration: none;
    }
    a:hover {
        color: #cccccc;
    }
</style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <div class="card-header text-center">
                    <h1>Đăng nhập</h1>
                </div>
                <div class="card-body">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
                                <path d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 3.94c.11.063.18.18.18.308v7.512a.34.34 0 0 1-.18.308l-6.857 3.94a.13.13 0 0 1-.125 0L1.08 14.084a.34.34 0 0 1-.18-.308V6.264c0-.128.07-.245.18-.308l6.857-3.94zM8 1.134 1.143 5.074v7.852L8 14.866l6.857-3.94V5.074L8 1.134z"/>
                                <path d="M7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm.93-4.481a.5.5 0 0 1 .938 0l.287 3.5a.5.5 0 0 1-.5.481h-1.5a.5.5 0 0 1-.5-.481l.287-3.5z"/>
                            </svg>
                            <?= htmlspecialchars($error_message) ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Chưa có tài khoản? <a href="../php/register.php">Đăng ký</a></p>
                    <a href="forgot-password.php">Quên mật khẩu?</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>