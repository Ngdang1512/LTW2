<?php
include '../db/connect.php';

// Hàm định dạng giá sản phẩm
function formatPrice($price) {
    return number_format($price, 0, ',', '.') . ' VND';
}

// Khởi tạo câu truy vấn SQL cơ bản
$sql = "SELECT * FROM products WHERE 1=1";

// Kiểm tra nếu có bộ lọc nào được áp dụng và thêm vào câu truy vấn SQL
if (isset($_GET['price'])) {
    $prices = $_GET['price'];
    $priceConditions = [];
    foreach ($prices as $price) {
        if ($price == 'under-2m') {
            $priceConditions[] = "price < 2000000";
        } elseif ($price == '2m-4m') {
            $priceConditions[] = "price BETWEEN 2000000 AND 4000000";
        } elseif ($price == 'above-4m') {
            $priceConditions[] = "price > 4000000";
        }
    }
    $sql .= " AND (" . implode(" OR ", $priceConditions) . ")";
}

if (isset($_GET['brand'])) {
    $brands = $_GET['brand'];
    $brandConditions = [];
    foreach ($brands as $brand) {
        $brandConditions[] = "brand = '$brand'";
    }
    $sql .= " AND (" . implode(" OR ", $brandConditions) . ")";
}

if (isset($_GET['length'])) {
    $lengths = $_GET['length'];
    $lengthConditions = [];
    foreach ($lengths as $length) {
        $lengthConditions[] = "length = $length";
    }
    $sql .= " AND (" . implode(" OR ", $lengthConditions) . ")";
}

if (isset($_GET['handle_length'])) {
    $handle_lengths = $_GET['handle_length'];
    $handleLengthConditions = [];
    foreach ($handle_lengths as $handle_length) {
        $handleLengthConditions[] = "handle_length = $handle_length";
    }
    $sql .= " AND (" . implode(" OR ", $handleLengthConditions) . ")";
}

if (isset($_GET['swingweight'])) {
    $swingweights = $_GET['swingweight'];
    $swingweightConditions = [];
    foreach ($swingweights as $swingweight) {
        if ($swingweight == 'under-82') {
            $swingweightConditions[] = "swingweight < 82";
        } elseif ($swingweight == '82-84') {
            $swingweightConditions[] = "swingweight BETWEEN 82 AND 84";
        } elseif ($swingweight == '84-86') {
            $swingweightConditions[] = "swingweight BETWEEN 84 AND 86";
        } elseif ($swingweight == '86-88') {
            $swingweightConditions[] = "swingweight BETWEEN 86 AND 88";
        } elseif ($swingweight == 'above-88') {
            $swingweightConditions[] = "swingweight > 88";
        }
    }
    $sql .= " AND (" . implode(" OR ", $swingweightConditions) . ")";
}

$result = $conn->query($sql);
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả lọc sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
        }
        .products-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .product {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            padding: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 350px; /* Đặt chiều cao cố định cho thẻ sản phẩm */
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
        }
        .product p {
            font-size: 1rem;
            color: #000;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .selected-filters {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        .selected-filters h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #000;
        }
        .selected-filters p {
            font-size: 1rem;
            color: #000;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <section class="container mt-5">
        <h2>Kết quả lọc sản phẩm</h2>
        <div class="selected-filters">
            <h3>Bộ lọc đã chọn</h3>
            <p>
            <?php
            $selectedFilters = [];
            if (isset($_GET['price'])) {
                $selectedFilters[] = "Giá: " . implode(", ", $_GET['price']);
            }
            if (isset($_GET['brand'])) {
                $selectedFilters[] = "Thương hiệu: " . implode(", ", $_GET['brand']);
            }
            if (isset($_GET['length'])) {
                $selectedFilters[] = "Chiều dài vợt: " . implode(", ", $_GET['length']) . " mm";
            }
            if (isset($_GET['handle_length'])) {
                $selectedFilters[] = "Chiều dài cán vợt: " . implode(", ", $_GET['handle_length']) . " mm";
            }
            if (isset($_GET['swingweight'])) {
                $selectedFilters[] = "Swingweight: " . implode(", ", $_GET['swingweight']);
            }
            echo implode(", ", $selectedFilters);
            ?>
            </p>
        </div>
        <div class="products-list">
            <?php
            if (count($products) > 0) {
                foreach ($products as $product) {
                    echo '<div class="product">';
                    echo '<a href="/user/php/products-detail.php?id=' . $product["id"] . '" style="text-decoration: none;">';
                    echo '<img src="' . $product["image"] . '" alt="' . $product["title"] . '">';
                    echo '<h4 class="product-title">' . $product["title"] . '</h4>';
                    echo '<p>Giá: ' . formatPrice($product["price"]) . '</p>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>Không có sản phẩm nào phù hợp với bộ lọc của bạn.</p>';
            }
            ?>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
</html>
