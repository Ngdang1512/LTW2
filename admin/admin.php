<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM ad_users WHERE email=? AND password=? AND status='active'");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if ($user['role'] === 'admin') {
      $_SESSION["user"] = $email;
      header("Location: admindashboard.php");
      exit();
    } else {
      $error = "❌ Bạn không có quyền truy cập trang quản trị.";
    }
  } else {
    $error = "❌ Sai tài khoản hoặc mật khẩu.";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập Quản trị</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('CauLongBG.jpg') no-repeat center center;
      background-size: cover;
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    form {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0px 10px 25px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      margin-bottom: 20px;
      color: #4364f7;
      text-align: center;
    }

    .input-wrapper {
      margin-left: -12px; /* 👈 Dịch toàn bộ input sang trái */
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #4364f7, #6fb1fc);
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background: linear-gradient(135deg, #3653c9, #5a9ef8);
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<form method="POST">
  <h2>Admin</h2>

  <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

  <div class="input-wrapper">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
  </div>

  <button type="submit">Đăng nhập</button>
</form>

</body>
</html>
