<?php
$base = '/user';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Tài Khoản</title>
    <link rel="stylesheet" href="/user/css/user-info.css">
    <link rel="stylesheet" href="/user/css/index.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="user-container">
        <h1>THÔNG TIN TÀI KHOẢN</h1>
        <div id="user-info">
            <span class="welcome" style="color: black;">Xin chào, <span id="user-name-account" class="user-name"></span></span>
        </div>

        <h2>THÔNG TIN KHÁCH HÀNG</h2>
        <div class="customer-info">
            <pre><span class="icon">👤</span>Họ tên: <span id="customer-name"></span></pre>
            <pre><span class="icon">📤</span>Email: <span id="customer-email"></span></pre>
            <pre><span class="icon">📞</span>Số ĐT: <span id="customer-phone"></span></pre>
            <pre><span class="icon">📍</span>Địa chỉ: <span id="customer-address"></span></pre>
        </div>

        <button class="edit-button" id="edit-button">SỬA THÔNG TIN</button>

        <div id="edit-form" style="display: none;">
            <h2>SỬA THÔNG TIN KHÁCH HÀNG</h2>
            <label for="edit-name">Họ Tên:</label>
            <input type="text" id="edit-name" placeholder="Họ Tên"/>

            <label for="edit-email">Email:</label>
            <input type="text" id="edit-email" placeholder="Email"/>

            <label for="edit-phone">Số ĐT:</label>
            <input type="text" id="edit-phone" placeholder="Số ĐT"/>

            <label for="edit-address">Địa chỉ:</label>
            <input type="text" id="edit-address" placeholder="Địa chỉ"/>

            <label for="edit-birthdate">Ngày sinh:</label>
            <input type="date" id="edit-birthdate" />

            <label for="edit-gender">Giới tính:</label>
            <select id="edit-gender">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>

            <h2>ĐỔI MẬT KHẨU</h2>
            <label for="edit-password">Mật khẩu mới:</label>
            <input type="password" id="edit-password" placeholder="Mật khẩu mới"/>

            <label for="edit-password-confirm">Nhập lại mật khẩu:</label>
            <input type="password" id="edit-password-confirm" placeholder="Nhập lại mật khẩu"/>
            
            <button id="save-button">Lưu</button>
            <button id="cancel-button">Hủy</button>
        </div>
        
        <h2>ĐƠN HÀNG CỦA BẠN</h2>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Đơn hàng</th>
                    <th>Ngày</th>
                    <th>Địa chỉ</th>
                    <th>Giá trị</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="no-orders">Không có đơn hàng nào.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="/user/js/user-info.js"></script>
    <script src="/user/js/login.js"></script>
    <script src="/user/js/index.js"></script>
    <script src="/user/js/register.js"></script>
    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
</html>
