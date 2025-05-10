<div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="/admin/php/dashboard.php">Trang chủ</a>
    <a href="/admin/php/user_list.php">Quản lý người dùng</a>
    <a href="/admin/php/product_list.php">Quản lý sản phẩm</a>
    <a href="/admin/php/order_list.php">Quản lý đơn hàng</a>
    <a href="/admin/php/logout.php" class="btn mt-3">Đăng xuất</a>
</div>

<style>
    .sidebar {
        height: 100vh;
        background-color: #343a40;
        color: #fff;
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
    }
    .sidebar a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .sidebar a:hover {
        background-color: #495057;
        color: #fff;
    }
</style>