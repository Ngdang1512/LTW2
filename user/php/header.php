<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<header class="navbar navbar-expand-lg" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd;">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/user/php/index.php">
            <img src="/user/image/logo.jpg" alt="Badminton Logo" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
            <span class="fw-bold fs-4 text-dark">Badminton Store</span>
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link text-dark fw-semibold" href="/user/php/index.php">Trang chủ</a></li>
                <li class="nav-item dropdown position-static">
                    <a class="nav-link super-dropdown-toggle text-dark fw-semibold" href="/user/php/products.php" id="productsDropdown" role="button">
                        Sản phẩm
                    </a>
                    <ul class="dropdown-menu shadow">
                        <!-- Vợt cầu lông -->
                        <li class="dropdown-item dropdown position-relative">
                            <a class="dropdown-toggle text-dark no-underline" href="/user/php/products-rackets.php" id="racketDropdown" role="button" style="text-decoration: none;">
                                Vợt cầu lông
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/products-yonex-page-1.php">Yonex</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/products-lining-page-1.php">Lining</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/products-victor-page-1.php">Victor</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/products-mizuno-page-1.php">Mizuno</a></li>
                            </ul>
                        </li>
                        <!-- Giày cầu lông -->
                        <li class="dropdown-item dropdown position-relative">
                            <a class="dropdown-toggle text-dark no-underline" href="/user/php/products-shoes.php" id="shoesDropdown" role="button" style="text-decoration: none;">
                                Giày cầu lông
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/shoes-yonex.php">Yonex</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/shoes-lining.php">Lining</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/shoes-victor.php">Victor</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/shoes-mizuno.php">Mizuno</a></li>
                            </ul>
                        </li>
                        <!-- Quả cầu lông -->
                        <li class="dropdown-item dropdown position-relative">
                            <a class="dropdown-toggle text-dark no-underline" href="#" id="shuttlecockDropdown" role="button" style="text-decoration: none;">
                                Quả cầu lông
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/shuttlecock-yonex.php">Yonex</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/shuttlecock-victor.php">Victor</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/shuttlecock-lining.php">Lining</a></li>
                            </ul>
                        </li>
                        <!-- Phụ kiện cầu lông -->
                        <li class="dropdown-item dropdown position-relative">
                            <a class="dropdown-toggle text-dark no-underline" href="#" id="accessoriesDropdown" role="button" style="text-decoration: none;">
                                Phụ kiện cầu lông
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/accessories-grip.php">Quấn cán</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/accessories-bag.php">Túi cầu lông</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/accessories-string.php">Dây cước</a></li>
                                <li><a class="dropdown-item text-dark no-underline" href="/user/php/accessories-others.php">Phụ kiện khác</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link text-dark fw-semibold" href="about.php">Thông tin</a></li>
                <li class="nav-item"><a class="nav-link text-dark fw-semibold" href="contact.php">Liên hệ</a></li>
            </ul>

            <!-- Cart and Auth Buttons -->
            <div class="d-flex align-items-center">
                <a href="cart.php" class="btn btn-outline-dark me-3 position-relative">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $cart_count; ?>
                    </span>
                </a>
                <!-- Kiểm tra trạng thái đăng nhập -->
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="d-flex align-items-center">
                    <a href="user-info.php" class="btn btn-outline-dark me-3 d-flex align-items-center">
                        <i class="fa-solid fa-user me-2"></i> <!-- Icon user -->
                        <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></span>
                    </a>
                    <div class="d-flex align-items-center">
                        <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-dark me-2">Đăng nhập</a>
                    <a href="register.php" class="btn btn-dark text-white">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</header>

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($cart_items)): ?>
                    <ul class="list-group">
                        <?php foreach ($cart_items as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['title']); ?>" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($item['title']); ?></h6>
                                        <small class="text-muted">Giá: <?= htmlspecialchars($item['price']); ?> VND</small>
                                    </div>
                                </div>
                                <span class="badge bg-primary rounded-pill">x<?= $item['quantity']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center">Giỏ hàng của bạn đang trống.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <a href="cart.php" class="btn btn-primary">Xem giỏ hàng</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tùy chỉnh cho super-dropdown-toggle */
    .super-dropdown-toggle {
        position: relative;
    }

    .super-dropdown-toggle::before {
        content: '\25BC'; /* Mã Unicode cho mũi tên xuống */
        position: absolute;
        right: 0; /* Căn mũi tên bên phải */
        top: 50%; /* Căn giữa theo chiều dọc */
        transform: translateY(-50%); /* Đảm bảo mũi tên nằm chính giữa */
        font-size: 0.6rem; /* Kích thước mũi tên */
        color: #000; /* Màu mũi tên */
        transition: transform 0.3s ease-in-out; /* Hiệu ứng mượt khi hover */
    }

    .super-dropdown-toggle:hover::before,
    .dropdown:hover > .super-dropdown-toggle::before {
        transform: translateY(-50%) rotate(-180deg); /* Xoay mũi tên 90 độ */
    }

    /* Hiển thị menu con khi hover vào mục cha */
    .dropdown:hover > .dropdown-menu {
        display: block; /* Hiển thị menu con khi hover */
        opacity: 1; /* Hiển thị rõ menu */
        transform: translateY(0); /* Menu trượt xuống */
        transition: all 0.3s ease-in-out; /* Hiệu ứng mượt */
    }

    .dropdown-menu {
        display: none; /* Ẩn menu con mặc định */
        opacity: 0; /* Menu trong suốt */
        transform: translateY(-10px); /* Menu trượt lên một chút */
        transition: all 0.3s ease-in-out; /* Hiệu ứng mượt */
    }

    /* Hiển thị menu con bên phải */
    .dropdown-menu-right {
        left: 100%; /* Đẩy menu con sang bên phải */
        top: 0;
        position: absolute;
    }

    /* Hiệu ứng hover cho các mục con */
    .dropdown-item {
        position: relative;
    }

    .dropdown-item:hover {
    color: #000; /* Màu xanh dương khi hover */
    }

    .dropdown-item::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #000; /* Màu đen cho thanh ngang */
        transition: width 0.3s ease-in-out;
    }

    .dropdown-item:hover::after {
        width: 100%; /* Thanh ngang chạy hết chiều rộng */
    }

    /* Hiệu ứng hover cho các liên kết trong header */
    .nav-link {
        position: relative;
        display: inline-block;
        color: #000;
        text-decoration: none !important; /* Loại bỏ gạch chân */
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #000; /* Màu đen cho thanh ngang */
        transition: width 0.3s ease-in-out;
    }

    .nav-link:hover::after {
        width: 100%; /* Thanh ngang chạy hết chiều rộng */
    }

    .nav-link:hover {
        color: black; /* Màu xanh dương khi hover */
    }

    /* Hiệu ứng hover cho nút đăng nhập và đăng ký */
    .btn-outline-dark:hover {
        background-color: #000;
        color: #fff;
        transition: background-color 0.3s ease, color 0.3s ease; /* Hiệu ứng mượt */
    }

    .btn-dark:hover {
        background-color: #333;
        color: #fff;
        transition: background-color 0.3s ease, color 0.3s ease; /* Hiệu ứng mượt */
    }
</style>