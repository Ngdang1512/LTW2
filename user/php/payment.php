<?php
session_start();
include "../db/connect.php";
// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Khởi tạo giỏ hàng và tổng giá trị
$cart = [];
$total_price = 0;

if (isset($_SESSION['buy_now'])) {
    // Xử lý "Mua ngay"
    $cart[] = $_SESSION['buy_now'];
    $total_price = $_SESSION['buy_now']['price'] * $_SESSION['buy_now']['quantity'];
    unset($_SESSION['buy_now']); // Xóa sản phẩm "Mua ngay" sau khi xử lý
} elseif (isset($_POST['cart_data'])) {
    // Xử lý thanh toán từ giỏ hàng
    $cart = json_decode($_POST['cart_data'], true);
    $total_price = $_POST['total_price'];
}
// Nếu giỏ hàng trống, chuyển hướng về trang giỏ hàng
if (empty($cart)) {
    header("Location: cart.php");
    exit();
}
// Lấy thông tin người dùng từ cơ sở dữ liệu
$username = $_SESSION['username'];
$sql_user = "SELECT * FROM users WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 0) {
    die("Không tìm thấy thông tin người dùng. Vui lòng kiểm tra lại.");
}

$user = $result_user->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badminton Racket Store - Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            font-weight: bold;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #000;
            border: none;
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #fff;
            color: #000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Thanh toán</h1>
        <div class="row">
            <!-- Thông tin nhận hàng -->
            <div class="col-md-6">
                <h2>Thông tin nhận hàng</h2>
                <form action="process_payment.php" method="POST">
                    <div class="mb-3">
                        <label for="receiver_name" class="form-label">Họ và tên người nhận hàng</label>
                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>
            </div>

            <!-- Đơn hàng -->
            <div class="col-md-6">
                <h2>Đơn hàng</h2>
                <?php foreach ($cart as $item): ?>
                <div class="d-flex justify-content-between mb-3">
                    <span><?= htmlspecialchars($item['title']) ?> x <?= htmlspecialchars($item['quantity']) ?></span>
                    <span><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</span>
                </div>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Tổng cộng:</span>
                    <span><?= number_format($total_price, 0, ',', '.') ?> VND</span>
                </div>
                <input type="hidden" name="cart_data" value="<?= htmlspecialchars(json_encode($cart)) ?>">
                <input type="hidden" name="total_price" value="<?= $total_price ?>">
            </div>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="mt-4">
            <h2>Phương thức thanh toán</h2>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" required>
                <label class="form-check-label" for="cod">
                    Thanh toán khi nhận hàng (COD)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="online" value="online" required>
                <label class="form-check-label" for="online">
                    Thanh toán trực tuyến
                </label>
            </div>
        </div>

        <!-- Tùy chọn thanh toán trực tuyến -->
        <div id="online-payment-options" class="mt-3" style="display: none;">
            <h3>Chọn phương thức thanh toán trực tuyến:</h3>
            <div class="payment-method">
                <input type="radio" name="online_payment_method" id="momo" value="momo" required>
                <label for="momo">
                    <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="Momo">
                    Chuyển khoản qua Momo
                </label>
            </div>
            <div class="payment-method">
                <input type="radio" name="online_payment_method" id="bank" value="bank" required>
                <label for="bank">
                    <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="Visa/Mastercard">
                    Thanh toán qua ngân hàng
                </label>
            </div>
        </div>

        <!-- Danh sách ngân hàng -->
        <div id="bank-options" class="mt-3" style="display: none;">
            <h4>Chọn ngân hàng:</h4>
            <div class="form-check payment-method">
                <input class="form-check-input" type="radio" name="bank_name" id="vcb" value="vcb" required>
                <label class="form-check-label" for="vcb">
                <img src="data:image/jpeg;base64,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" alt="Vietcombank" style="width: 50px; height: auto;">
                    Vietcombank
                </label>
            </div>
            <div class="form-check payment-method">
                <input class="form-check-input" type="radio" name="bank_name" id="sacombank" value="sacombank" required>
                <label class="form-check-label" for="sacombank">
                    <img src="data:image/png;base64,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" alt="Sacombank" style="width: 50px; height: auto;">
                    Sacombank
                </label>
            </div>
            <div class="form-check payment-method">
                <input class="form-check-input" type="radio" name="bank_name" id="techcombank" value="techcombank" required>
                <label class="form-check-label" for="techcombank">
                    <img src="data:image/png;base64,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" alt="Techcombank" style="width: 50px; height: auto;">
                    Techcombank
                </label>
            </div>
            <div class="form-check payment-method">
                <input class="form-check-input" type="radio" name="bank_name" id="mbbank" value="mbbank" required>
                <label class="form-check-label" for="mbbank">
                    <img src="data:image/png;base64,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" alt="MB Bank" style="width: 50px; height: auto;">
                    MB Bank
                </label>
            </div>
        </div>

        <!-- Form nhập thông tin thẻ -->
        <div id="card-info" class="mt-3" style="display: none;">
        <h4>Nhập thông tin thẻ:</h4>
        <div class="mb-3">
            <label for="card_holder" class="form-label">Tên chủ thẻ *</label>
            <input type="text" class="form-control" id="card_holder" name="card_holder" placeholder="Nhập tên chủ thẻ " required>
        </div>
        <div class="mb-3">
            <label for="card_expiry_month" class="form-label">Tháng hết hạn (MM) *</label>
            <select class="form-select" id="card_expiry_month" name="card_expiry_month" required>
                <option value="" selected>- Chọn tháng -</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                <?php endfor; ?>
            </select>
            </div>
            <div class="mb-3">
                <label for="card_expiry_year" class="form-label">Năm hết hạn (YYYY) *</label>
                <select class="form-select" id="card_expiry_year" name="card_expiry_year" required>
                    <option value="" selected>- Chọn năm -</option>
                    <?php for ($i = date('Y'); $i <= date('Y') + 10; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="card_serial" class="form-label">Số thẻ *</label>
                <input type="text" class="form-control" id="card_serial" name="card_serial" placeholder="Nhập số thẻ" required>
            </div>
        </div>

        <!-- Nút đặt hàng -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary btn-lg">ĐẶT HÀNG</button>
        </div>
        </form>
    </div>
</body>
</html>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const onlinePaymentRadio = document.getElementById('online');
            const codPaymentRadio = document.getElementById('cod');
            const onlinePaymentOptions = document.getElementById('online-payment-options');
            const bankPaymentRadio = document.getElementById('bank');
            const bankOptions = document.getElementById('bank-options');
            const cardInfo = document.getElementById('card-info');
            const bankRadios = document.querySelectorAll('input[name="bank_name"]');

            // Hiển thị tùy chọn thanh toán trực tuyến khi chọn "Thanh toán trực tuyến"
            onlinePaymentRadio.addEventListener('change', function () {
                if (this.checked) {
                    onlinePaymentOptions.style.display = 'block';
                    bankOptions.style.display = 'none';
                    cardInfo.style.display = 'none';
                }
            });

            // Ẩn tùy chọn thanh toán trực tuyến khi chọn "Thanh toán khi nhận hàng"
            codPaymentRadio.addEventListener('change', function () {
                if (this.checked) {
                    onlinePaymentOptions.style.display = 'none';
                    bankOptions.style.display = 'none';
                    cardInfo.style.display = 'none';
                }
            });

            // Hiển thị danh sách ngân hàng khi chọn "Thanh toán qua ngân hàng"
            bankPaymentRadio.addEventListener('change', function () {
                if (this.checked) {
                    bankOptions.style.display = 'block';
                    cardInfo.style.display = 'none';
                }
            });

            // Hiển thị chỉ ngân hàng được chọn và xóa khối của các ngân hàng khác
            bankRadios.forEach(bankRadio => {
                bankRadio.addEventListener('change', function () {
                    const selectedBankId = this.id;

                    // Xóa toàn bộ khối của các ngân hàng khác
                    bankRadios.forEach(bank => {
                        const bankDiv = document.querySelector(`input#${bank.id}`).closest('.form-check');
                        if (bank.id !== selectedBankId && bankDiv) {
                            bankDiv.remove();
                        }
                    });

                    // Hiển thị form nhập thông tin thẻ nếu chọn Vietcombank
                    if (selectedBankId === 'vcb') {
                        cardInfo.style.display = 'block';
                    } else {
                        cardInfo.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
</html>