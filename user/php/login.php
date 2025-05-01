<?php
session_start(); 
include('../db/connect.php');
$success_message = ""; // Biến lưu thông báo thành công


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

        if ($user['password'] === $password) { // nếu bạn dùng hash, hãy dùng password_verify()
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "Sai mật khẩu.";
        }
    } else {
        echo "Sai tài khoản hoặc mật khẩu.";
    }
}
?>
<?php if (isset($_SESSION['username'])): ?>
    <div id="user-icon">
        <i class="fa-regular fa-circle-user" onclick="window.location.href='user-info.php'"></i>
        <span id="Logout" class="logout" onclick="logout()">Đăng xuất 
            <span id="user-name"><?= htmlspecialchars($_SESSION['username']) ?></span>
        </span>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/user/css/login.css" />
</head>
<body>
  <div id="wrapper">
  
        <form action="" method="post" id="form-login">
            <h1 class="form-heading">Đăng nhập</h1>
            <div class="form-group">
                <i class="far fa-user"></i>
                <input type="text" class="form-input"  name="username" placeholder="Tên đăng nhập">
            </div>

            <div class="form-group">
                <i class="fas fa-key"></i>
                <input type="password" class="form-input" name ="password" placeholder="Mật khẩu">
                <div id="eye">
                    <i class="far fa-eye"></i>
                </div>
            </div>
           
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me</label>
                <a href="forgot-password.php" id="forgot-password">Forgot password</a>
            </div>
           
            <input type="submit" name="login" value="Đăng nhập"  class="form-submit">

            <div class="register-link">
                <p>Dont't have an account? 
                    <a href="../php/register.php" id="register">Đăng ký</a>
                </p>
            </div>
            

            <div class="back-home">
                <a href="index.php">
                    <i class="fas fa-home" style="color: black; cursor: pointer;"></i>
                </a>
            </div>
        </form>
    </div>

</body>
</html>
