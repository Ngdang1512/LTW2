<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badminton Racket Store</title>
    <link rel="stylesheet" href="/user/css/payment.css">
    <link rel="stylesheet" href="/user/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="checkout-container">
        <?php include 'header.php'; ?>

        <div class="content">
            <!-- Thông tin nhận hàng -->
            <div class="shipping-info">
                <h2>Thông tin nhận hàng</h2>
                <input type="text" placeholder="Họ và tên người nhận hàng">
                <input type="text" placeholder="Số điện thoại">
                <input type="text" placeholder="Địa chỉ">
                <input type="email" placeholder="Email">
                <input type="text" placeholder="Ghi chú đơn hàng (tùy chọn)">
            </div>

            <!-- Thanh toán -->
            <div class="payment-options">
                <h2>Thanh toán</h2>
                <label><input type="radio" name="payment" checked> Thanh toán khi nhận hàng (COD)</label>
                <label><input type="radio" name="payment"> Thanh toán qua ngân hàng</label>
                <button class="payment-button red">THANH TOÁN THẺ (Visa, MasterCard, JCB)</button>
                <button class="payment-button blue">TRẢ GÓP QUA THẺ Visa, Master, JCB</button>
                <button class="payment-button yellow">MUA TRẢ GÓP</button>
            </div>

            <!-- Đơn hàng -->
            <div class="order-summary">
                <h2>Đơn hàng</h2>
                <div class="info-product">
                </div>
                <div class="total">
                    <h3>Tổng cộng</h3>
                </div>
                <div class="buttons">
                    <button onclick="window.location.href='/user/php/cart.php'" class="btn-edit-cart">Sửa giỏ hàng</button>
                    <button class="btn-place-order">ĐẶT HÀNG</button>
                </div>
            </div>
        </div>
    </div>

    <!---footer--->
    <?php include 'footer.php'; ?>

    <script src="/user/js/index.js"></script>
    <script src="/user/js/login.js"></script>
    <script src="/user/js/search.js"></script>
    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
</html>
