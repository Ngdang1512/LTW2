<?php
include('../db/connect.php'); // Kết nối cơ sở dữ liệu

$search_results = []; // Mảng lưu kết quả tìm kiếm
$query = ""; // Biến lưu từ khóa tìm kiếm

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query']) && !empty($_GET['query'])) {
    $query = trim($_GET['query']); // Lấy từ khóa tìm kiếm từ URL

    // Truy vấn tìm kiếm sản phẩm từ bảng `products`
    $stmt = $conn->prepare("SELECT id, title, price, image FROM products WHERE title LIKE ?");
    $search_term = "%" . $query . "%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    // Lưu kết quả tìm kiếm vào mảng
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }
        .product-card .card-body {
            padding: 15px;
            text-align: center;
        }
        .product-card .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }
        .product-card .card-text {
            font-size: 16px;
            color: #555;
            margin-bottom: 15px;
        }
        .product-card .btn-primary {
            background-color: #000;
            border: none;
        }
        .product-card .btn-primary:hover {
            background-color: #333;
        }
        .search-header {
            margin-bottom: 30px;
            text-align: center;
        }
        .search-header h3 {
            font-size: 24px;
            font-weight: bold;
            color: #000;
        }
        .search-header p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <!-- Thanh tìm kiếm -->
        <form class="d-flex mb-4" method="GET" action="query.php">
            <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($query); ?>">
            <button class="btn btn-dark" type="submit">Tìm kiếm</button>
        </form>

        <!-- Kết quả tìm kiếm -->
        <div class="search-header">
            <?php if (!empty($query)): ?>
                <h3>Kết quả tìm kiếm cho từ khóa: "<?= htmlspecialchars($query); ?>"</h3>
                <p>Hiển thị các sản phẩm phù hợp với từ khóa của bạn.</p>
            <?php else: ?>
                <h3>Vui lòng nhập từ khóa để tìm kiếm sản phẩm.</h3>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php if (!empty($search_results)): ?>
                <?php foreach ($search_results as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="product-card">
                            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['title']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['title']); ?></h5>
                                <p class="card-text">Giá: <?= number_format($product['price'], 0, ',', '.'); ?> VND</p>
                                <a href="products-detail.php?id=<?= $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Không tìm thấy sản phẩm nào phù hợp với từ khóa.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?> 
</body>
</html>