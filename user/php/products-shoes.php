<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .card-text.price {
            color: #e74c3c;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .products-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Hiển thị 4 sản phẩm mỗi hàng */
            gap: 20px; /* Khoảng cách giữa các sản phẩm */
        }

        .product {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            padding: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
            transition: none;
            transition: none;
        }

        .product p {
            font-size: 1rem;
            color: #000;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include "header.php"; ?>

    <!-- Sản phẩm -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Sản phẩm nổi bật</h1>

        <?php
        // Gộp chung danh sách sản phẩm
        $products = [
            // Danh sách sản phẩm vợt
            ["id" => 9, "image" => "/image/65z3.jpg", "title" => "Yonex Power Cushion 65Z3", "price" => "2,800,000 VND", "brand" => "Yonex"],
            ["id" => 10, "image" => "/image/88dial3.webp", "title" => "Yonex Power Cushion 88 Dial 3", "price" => "3,200,000 VND", "brand" => "Yonex"],
            ["id" => 11, "image" => "/image/aerusZ2.webp", "title" => "Yonex Aerus Z2", "price" => "3,500,000 VND", "brand" => "Yonex"],
            ["id" => 12, "image" => "/image/comfortZ3.webp", "title" => "Yonex Comfort Z3", "price" => "3,100,000 VND", "brand" => "Yonex"],
            ["id" => 13, "image" => "/image/ayau005-1.webp", "title" => "Lining AYAU005-1", "price" => "2,700,000 VND", "brand" => "Lining"],
            ["id" => 14, "image" => "/image/ayazt003-1.webp", "title" => "Lining AYAZT003-1", "price" => "3,000,000 VND", "brand" => "Lining"],
            ["id" => 15, "image" => "/image/ayzu015-1.webp", "title" => "Lining AYZU015-1", "price" => "3,800,000 VND", "brand" => "Lining"],
            ["id" => 16, "image" => "/image/bladepro.jpg", "title" => "Lining Blade Pro", "price" => "2,900,000 VND", "brand" => "Lining"],
        ];

        // Hiển thị sản phẩm theo thương hiệu
        $brands = ["Yonex", "Lining"];
        foreach ($brands as $brand) {
            echo '<h3 class="mt-4">' . $brand . '</h3>';
            echo '<div class="products-list">';
            foreach ($products as $product) {
                if ($product["brand"] === $brand) {
                    echo '<div class="product">';
                    echo '<a href="/user/php/products-detail.php?id=' . $product["id"] . '" style="text-decoration: none;">';
                    echo '<img src="' . $product["image"] . '" alt="' . $product["title"] . '">';
                    echo '<h4 class="product-title">' . $product["title"] . '</h4>';
                    echo '<p>Giá: ' . $product["price"] . '</p>';
                    echo '</a>';
                    echo '</div>';
                }
            }
            echo '</div>';
        }
        ?>
    </div>

    <!-- Footer -->
    <?php include "footer.php"; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>