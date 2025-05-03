<?php
session_start();
include('../db/connect.php')?>
 
<?php 
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (empty($username) || empty($password) || empty($email)) {
        echo "Vui lòng điền đầy đủ thông tin.";
        exit();
    }

    // Kiểm tra xem username đã tồn tại hay chưa
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
        exit();
    }

    // Nếu username chưa tồn tại, thêm vào cơ sở dữ liệu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php?success=1");
        exit();
    } else {
        echo "Lỗi khi thêm dữ liệu: " . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/user/css/login.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <title>Register</title>
</head>

<body>
    <div id="wrapper">
        <form action="register.php" method="post" id="form-register">
            <h1 class="form-heading">Đăng ký tài khoản</h1>
            
            <div class="form-group">
                <i class="far fa-user"></i>
                <input type="text" class="form-input"name="username" placeholder="Tên đăng nhập" required>
            </div>

            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" class="form-input" placeholder="Email" required>
            </div>

            <div class="form-group">
                <i class="fas fa-key"></i>
                <input type="password" name="password" class="form-input" placeholder="Mật khẩu" required>
            </div>
             
            <input type="submit" name="dangky" value="Đăng ký" class="form-submit">

            <div class="back-link">
                <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            </div>

            <div class="back-home">
                <a href="/user/php/index.php">
                    <i class="fas fa-home" style="color: black; cursor: pointer;"></i>
                </a>
            </div>
            
        </form>
    </div>

</body>
</html>
