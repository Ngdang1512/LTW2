<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/user/css/login.css" />
</head>
<body>
  <div id="wrapper">
        <form action="" id="form-login">
            <h1 class="form-heading">Đăng nhập</h1>
            <div class="form-group">
                <i class="far fa-user"></i>
                <input type="text" class="form-input" placeholder="Tên đăng nhập">
            </div>

            <div class="form-group">
                <i class="fas fa-key"></i>
                <input type="password" class="form-input" placeholder="Mật khẩu">
                <div id="eye">
                    <i class="far fa-eye"></i>
                </div>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me</label>
                <a href="forgot-password.php" id="forgot-password">Forgot password</a>
            </div>

            <input type="submit" value="Đăng nhập" class="form-submit">

            <div class="register-link">
                <p>Dont't have an account? 
                    <a href="register.php" id="register">Đăng ký</a>
                </p>
            </div>

            <div class="back-home">
                <a href="index.php">
                    <i class="fas fa-home" style="color: black; cursor: pointer;"></i>
                </a>
            </div>
        </form>
    </div>

    <script src="<?= $base ?>/js/login.js"></script>
</body>
</html>
