<?php
include('../db/connect.php'); // Kết nối cơ sở dữ liệu

$search_results = []; // Mảng lưu kết quả tìm kiếm
$query = ""; // Biến lưu từ khóa tìm kiếm

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query']) && !empty($_GET['query'])) {
    $query = $_GET['query']; // Lấy từ khóa tìm kiếm từ URL

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

    // Nếu là yêu cầu AJAX, trả về JSON
    if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
        header('Content-Type: application/json');
        echo json_encode($search_results);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Cửa hàng bán vợt và phụ kiện cầu lông" />
    <title>Badminton Racket Store</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        #suggestions {
            position: absolute;
            z-index: 1050;
            margin-top: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-height: 300px;
            overflow-y: auto;
            width: 85%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: block;
            opacity: 1;
            visibility: visible;
        }

        .dropdown-item {
            padding: 10px;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        #search-input, #search-form button {
            height: 35px;
            font-size: 14px;
            padding: 5px 10px;
        }
        #search-form button i {
            font-size: 16px; /* Kích thước biểu tượng */
        }
        
    </style>
</head>
<body>
    <!-- Thanh tìm kiếm -->
    <div class="container mt-5 mb-3">
        <div class="row justify-content-end">
            <div class="col-md-4" style="position: relative;">
                <form class="d-flex" id="search-form" method="GET" action="query.php">
                    <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" id="search-input" autocomplete="off">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <!-- Dropdown gợi ý -->
                <div id="suggestions" class="dropdown-menu" style="display: none;"></div>
            </div>
        </div>
    </div>

    <!-- Kết quả tìm kiếm -->
    <div id="search-results" class="container mt-4">
        <?php if (!empty($query)): ?>
            <h3>Kết quả tìm kiếm cho từ khóa: "<?= htmlspecialchars($query); ?>"</h3>
            <div id="results-list" class="row">
                <?php if (!empty($search_results)): ?>
                    <?php foreach ($search_results as $products): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?= htmlspecialchars($products['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($products['title']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($products['title']); ?></h5>
                                    <p class="card-text"><strong>Giá:</strong> <?= number_format($products['price'], 0, ',', '.'); ?> VND</p>
                                    <a href="/user/php/products.php?id=<?= $products['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('search-input').addEventListener('input', function () {
            const query = this.value.trim();

            if (query.length > 0) {
                fetch(`/user/php/search.php?query=${encodeURIComponent(query)}&ajax=1`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const suggestions = document.getElementById('suggestions');
                        suggestions.innerHTML = ''; // Xóa các gợi ý cũ
                        suggestions.style.display = 'block';

                        if (data.length > 0) {
                            data.forEach(product => {
                                const item = document.createElement('div');
                                item.classList.add('dropdown-item');
                                item.innerHTML = `
                                    <div class="d-flex align-items-center">
                                        <img src="${product.image}" alt="${product.title}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                        <div>
                                            <strong>${product.title}</strong><br>
                                            <span>${product.price.toLocaleString()} VND</span>
                                        </div>
                                    </div>
                                `;
                                item.addEventListener('click', () => {
                                    window.location.href = `/user/php/products-detail.php?id=${product.id}`;
                                });
                                suggestions.appendChild(item);
                            });
                        } else {
                            suggestions.innerHTML = '<div class="dropdown-item">Không tìm thấy sản phẩm nào.</div>';
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            } else {
                document.getElementById('suggestions').style.display = 'none';
            }
        });
    </script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>