<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="/user/css/cart.css">
    <link rel="stylesheet" href="/user/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="cart-container">
        <h2>Giỏ hàng của bạn</h2>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="cart-items">
            </tbody>
        </table>
        <div class="cart-summary">
            <h3>Tổng giá trị: <span id="total-price">0 VND</span></h3>
            <button id="checkout-button">Thanh toán</button>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="/user/js/cart.js"></script>
    <script src="/user/js/index.js"></script>
    <script src="/user/js/login.js"></script>
    <script src="/user/js/search.js"></script>
    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
</html>