<?php
include '../db/connect.php';

// Khởi tạo câu truy vấn SQL cơ bản
$sql = "SELECT * FROM products WHERE 1=1";

// Kiểm tra nếu có bộ lọc nào được áp dụng và thêm vào câu truy vấn SQL
if (isset($_GET['price'])) {
    $price = $_GET['price'];
    if ($price == 'under-2m') {
        $sql .= " AND price < 2000000";
    } elseif ($price == '2m-4m') {
        $sql .= " AND price BETWEEN 2000000 AND 4000000";
    } elseif ($price == 'above-4m') {
        $sql .= " AND price > 4000000";
    }
}

if (isset($_GET['brand'])) {
    $brand = $_GET['brand'];
    $sql .= " AND brand = '$brand'";
}

if (isset($_GET['length'])) {
    $length = $_GET['length'];
    $sql .= " AND length = $length";
}

if (isset($_GET['handle_length'])) {
    $handle_length = $_GET['handle_length'];
    $sql .= " AND handle_length = $handle_length";
}

if (isset($_GET['swingweight'])) {
    $swingweight = $_GET['swingweight'];
    if ($swingweight == 'under-82') {
        $sql .= " AND swingweight < 82";
    } elseif ($swingweight == '82-84') {
        $sql .= " AND swingweight BETWEEN 82 AND 84";
    } elseif ($swingweight == '84-86') {
        $sql .= " AND swingweight BETWEEN 84 AND 86";
    } elseif ($swingweight == '86-88') {
        $sql .= " AND swingweight BETWEEN 86 AND 88";
    } elseif ($swingweight == 'above-88') {
        $sql .= " AND swingweight > 88";
    }
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
    <title>Sản phẩm Yonex</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
        }
        #products {
            display: grid;
            grid-template-columns: 1fr 4fr; /* Bộ lọc chiếm 1 phần, sản phẩm chiếm 4 phần */
            gap: 20px;
        }
        .filter-form {
            background: #f8f9fa;
            padding: 15px; /* Giảm padding để thu nhỏ bảng filter */
            border-radius: 8px;
            border: 1px solid #ccc;
            height: fit-content;
            font-size: 0.9rem; /* Thu nhỏ chữ trong filter */
        }
        .filter-form h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #000;
        }
        .filter-form label {
            font-size: 1rem;
            color: #000;
            display: block;
            margin-bottom: 10px;
        }
        .filter-form button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .filter-form button:hover {
            background-color: #ccc;
            color: #000;
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
        }
        .product p {
            font-size: 1rem;
            color: #000;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }
        .pagination .page-link, .pagination .current-page {
            display: inline-block;
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            color: #000;
            border: 1px solid #ccc;
        }
        .pagination .current-page {
            background: #000;
            color: #fff;
            border-color: #000;
        }
        .pagination .page-link:hover {
            background: #ccc;
            color: #000;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section id="products" class="container mt-5">
        <!-- Bộ lọc -->
        <form action="filter-products.php" method="GET" class="filter-form">
            <h3>Lọc theo giá</h3>
            <label><input type="checkbox" name="price[]" value="under-2m"> Dưới 2 triệu</label>
            <label><input type="checkbox" name="price[]" value="2m-4m"> Từ 2 triệu - 4 triệu</label>
            <label><input type="checkbox" name="price[]" value="above-4m"> Trên 4 triệu</label>

            <h3>Lọc theo thương hiệu</h3>
            <label><input type="checkbox" name="brand" value="Yonex"> Yonex</label>
            <label><input type="checkbox" name="brand" value="Lining"> Lining</label>
            <label><input type="checkbox" name="brand" value="Victor"> Victor</label>
            <label><input type="checkbox" name="brand" value="Mizuno"> Mizuno</label>

            <h3>Chiều dài vợt</h3>
            <label><input type="checkbox" name="length" value="665"> 665 mm</label>
            <label><input type="checkbox" name="length" value="670"> 670 mm</label>
            <label><input type="checkbox" name="length" value="675"> 675 mm</label>

            <h3>Chiều dài cán vợt</h3>
            <label><input type="checkbox" name="handle_length" value="200"> 200 mm</label>
            <label><input type="checkbox" name="handle_length" value="205"> 205 mm</label>
            <label><input type="checkbox" name="handle_length" value="210"> 210 mm</label>

            <h3>Swingweight</h3>
            <label><input type="checkbox" name="swingweight" value="under-82"> Dưới 82 kg/cm²</label>
            <label><input type="checkbox" name="swingweight" value="82-84"> 82-84 kg/cm²</label>
            <label><input type="checkbox" name="swingweight" value="84-86"> 84-86 kg/cm²</label>
            <label><input type="checkbox" name="swingweight" value="86-88"> 86-88 kg/cm²</label>
            <label><input type="checkbox" name="swingweight" value="above-88"> Trên 88 kg/cm²</label>

            <button type="submit" class="btn btn-primary mt-3">Áp dụng bộ lọc</button>
        </form>

        <!-- Danh sách sản phẩm -->
        <div class="products-list">
            <?php
            // Mô phỏng danh sách sản phẩm
            $products = [
                ["id" => 1,"image" => "/image/88d.webp", "title" => "Yonex Astrox 88D Pro", "price" => "4.000.000 VND"],
                ["id" => 2,"image" => "/image/nnf800.jpg", "title" => "Yonex Nanoflare 800", "price" => "3.000.000 VND"],
                ["id" => 3,"image" => "/image/arc11pro.jpg", "title" => "Yonex Arcsaber 11 Pro", "price" => "7.000.000 VND"],
                ["id" => 4,"image" => "/image/duorazstrike.jpg", "title" => "Yonex Duora Z-Strike", "price" => "1.580.000 VND"],
                ["id" => 1,"image" => "/image/88d.webp", "title" => "Yonex Astrox 88D Pro", "price" => "4.000.000 VND"],
                ["id" => 2,"image" => "/image/nnf800.jpg", "title" => "Yonex Nanoflare 800", "price" => "3.000.000 VND"],
                ["id" => 3,"image" => "/image/arc11pro.jpg", "title" => "Yonex Arcsaber 11 Pro", "price" => "7.000.000 VND"],
                ["id" => 4,"image" => "/image/duorazstrike.jpg", "title" => "Yonex Duora Z-Strike", "price" => "1.580.000 VND"],
                ["id" => 1,"image" => "/image/88d.webp", "title" => "Yonex Astrox 88D Pro", "price" => "4.000.000 VND"],
                ["id" => 2,"image" => "/image/nnf800.jpg", "title" => "Yonex Nanoflare 800", "price" => "3.000.000 VND"],
                ["id" => 3,"image" => "/image/arc11pro.jpg", "title" => "Yonex Arcsaber 11 Pro", "price" => "7.000.000 VND"],
                ["id" => 4,"image" => "/image/duorazstrike.jpg", "title" => "Yonex Duora Z-Strike", "price" => "1.580.000 VND"]
            ];

            // Hiển thị sản phẩm
            foreach ($products as $product) {
                echo '<div class="product">';
                echo '<a href="/user/php/products-detail.php?id=' . $product["id"] . '" style="text-decoration: none;">';
                echo '<img src="' . $product["image"] . '" alt="' . $product["title"] . '">';
                echo '<h4 class="product-title">' . $product["title"] . '</h4>';
                echo '<p>Giá: ' . $product["price"] . '</p>';
                echo '</a>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <!-- Phân trang -->
    <div class="pagination">
        <span class="current-page">1</span>
        <a href="/user/php/products-yonex-page-2.php" class="page-link">2</a>
        <a href="/user/php/products-yonex-page-3.php" class="page-link">3</a>
        <a href="/user/php/products-yonex-page-2.php" class="page-link">Trang sau &raquo;</a>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dc2acc0315.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>

</html>