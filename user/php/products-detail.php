<?php
include '../db/connect.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Không tìm thấy sản phẩm.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo $product['title']; ?> - Badminton Racket Store</title>
</head>

<style>
    .product-info p {
    font-size: 1rem;
    margin-bottom: 10px;
    }

    .product-version, .product-sizes, .product-promotions {
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .product-version h2, .product-sizes h2, .product-promotions h2 {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .product-version ul, .product-sizes ul, .product-promotions ul {
        list-style: none;
        padding: 0;
    }

    .product-version ul li, .product-sizes ul li, .product-promotions ul li {
        margin-bottom: 5px;
        font-size: 1rem;
        color: #555;
    }
    .product-description, .product-specifications, .product-highlights, .product-usage, .product-reviews, .product-faqs {
    background-color: #f9f9f9;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 20px;
    }
    .product-description h2, .product-specifications h2, .product-highlights h2, .product-usage h2, .product-reviews h2, .product-faqs h2 {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .product-images img {
        max-width: 100%;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    /* Nút chính (Thêm vào giỏ hàng) */
    .custom-btn {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #fff;
        color: #000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transform: scale(1.05); /* Hiệu ứng phóng to nhẹ */
    }

    /* Nút viền (Mua ngay) */
    .custom-btn-outline {
        background-color: transparent;
        color: #000;
        border: 2px solid #000;
        padding: 10px 20px;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .custom-btn-outline:hover {
        background-color: #000;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transform: scale(1.05); /* Hiệu ứng phóng to nhẹ */
    }

    /* Số lượng */
    .product-quantity .btn {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
        font-weight: bold;
        text-align: center;
        line-height: 1;
    }

    .product-quantity input {
        font-size: 1.2rem;
        text-align: center;
    }
    .product-quantity input[type="number"]::-webkit-inner-spin-button,
    .product-quantity input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

</style>

<body>
    <?php include 'header.php'; ?>

    <main class="product-detail-container container mt-5">
        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-6">
                <div class="product-images">
                    <div class="main-image text-center">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="img-fluid">
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <div class="product-info">
                    <h1 class="product-title"><?php echo $product['title']; ?></h1>
                    <div class="price text-danger fw-bold fs-4"><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</div>
                    <p><strong>Mã sản phẩm:</strong> <?php echo $product['product_code']; ?></p>
                    <p><strong>Thương hiệu:</strong> <?php echo $product['brand']; ?></p>
                    <p><strong>Tình trạng:</strong> <?php echo $product['status']; ?></p>

                    <div class="product-quantity mt-4">
                        <h2 class="fs-5">Số lượng</h2>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(-1)">-</button>
                            <input type="number" id="quantity" value="1" min="1" max="99" class="form-control text-center mx-2" style="width: 60px;">
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(1)">+</button>
                        </div>
                    </div>

                    <div class="product-promotions mt-4">
                        <h2 class="fs-5">Ưu đãi</h2>
                        <?php echo $product['promotions']; ?>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary btn-lg custom-btn">Thêm vào giỏ hàng</button>
                        <button class="btn btn-outline-secondary btn-lg custom-btn-outline">Mua ngay</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Các phần chi tiết khác -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="product-highlights">
                    <h2 class="fs-5">Đặc điểm nổi bật</h2>
                    <?php echo $product['highlights']; ?>
                </div>

                <div class="product-usage mt-4">
                    <h2 class="fs-5">Hướng dẫn sử dụng</h2>
                    <?php echo $product['usage_instructions']; ?>
                </div>

                <div class="product-reviews mt-4">
                    <h2 class="fs-5">Đánh giá sản phẩm</h2>
                    <?php echo $product['reviews']; ?>
                </div>

                <div class="product-faqs mt-4">
                    <h2 class="fs-5">Câu hỏi thường gặp</h2>
                    <?php echo $product['faqs']; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

    <script>
    function updateQuantity(change) {
        const quantityInput = document.getElementById('quantity');
        let currentQuantity = parseInt(quantityInput.value);

        // Tăng hoặc giảm số lượng
        currentQuantity += change;

        // Đảm bảo số lượng nằm trong khoảng hợp lệ
        if (currentQuantity < 1) {
            currentQuantity = 1;
        } else if (currentQuantity > 99) {
            currentQuantity = 99;
        }

        // Cập nhật giá trị số lượng
        quantityInput.value = currentQuantity;
    }
    </script>

    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

</body>
</html>