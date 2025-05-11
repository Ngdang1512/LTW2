<?php
include '../db/connect.php';

$error = null; // Khởi tạo biến $error mặc định là null

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $id = intval($_POST['id']);
    $product_code = trim($_POST['product_code']);
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $brand = trim($_POST['brand']);
    $image = null; // Khởi tạo giá trị mặc định là NULL

    // Kiểm tra giá trị từ input ẩn
    if (!empty($_POST['image_name'])) {
        $image_name = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_POST['image_name'])); // Xử lý tên file
        $upload_dir = __DIR__ . "/../../image/"; // Đường dẫn tuyệt đối đến thư mục "image"
        $upload_file = $upload_dir . $image_name;

        // Tạo thư mục "image" nếu chưa tồn tại
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        // Di chuyển file vào thư mục "image"
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $image = "/image/" . $image_name; // Lưu đường dẫn tương đối vào cơ sở dữ liệu
            echo "Đường dẫn hình ảnh: " . $image . "<br>"; // Kiểm tra giá trị của $image
        } else {
            $error = "Không thể tải lên hình ảnh.";
        }
    } else {
        $error = "Vui lòng chọn một file hình ảnh hợp lệ.";
    }

    // Nếu không có lỗi, thêm sản phẩm vào cơ sở dữ liệu
    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO products (id, product_code, title, category, price, description, image, brand) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdsss", $id, $product_code, $title, $category, $price, $description, $image, $brand);

        if ($stmt->execute()) {
            echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href = 'product_list.php';</script>";
        } else {
            echo "Lỗi SQL: " . $stmt->error . "<br>";
        }
    } else {
        echo "Lỗi: " . $error . "<br>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content {
            margin-left: 250px; /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
        }
        .preview-img {
            max-width: 200px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <h2 class="text-center">Thêm sản phẩm</h2>

    <!-- Hiển thị thông báo lỗi -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form class="content" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="id" class="form-label">ID sản phẩm</label>
            <input type="number" class="form-control" id="id" name="id" required>
        </div>
        <div class="mb-3">
            <label for="product_code" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="product_code" name="product_code" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Hãng</label>
            <select class="form-select" id="brand" name="brand" required>
                <option value="Yonex">Yonex</option>
                <option value="Lining">Lining</option>
                <option value="Mizuno">Mizuno</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Phân loại</label>
            <select class="form-select" id="category" name="category" required>
                <option value="Vợt cầu lông">Vợt cầu lông</option>
                <option value="Giày cầu lông">Giày cầu lông</option>
                <option value="Quần áo thể thao">Quần áo thể thao</option>
                <option value="Phụ kiện">Phụ kiện</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá sản phẩm</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="updateFileName()">
            <input type="hidden" id="image_name" name="image_name">
            <small class="text-muted">Chọn file hình ảnh từ máy tính.</small>
            <p id="selected-image" class="text-success mt-2"></p>
        </div>

        <script>
            function updateFileName() {
                const fileInput = document.getElementById('image');
                const fileNameInput = document.getElementById('image_name');
                const selectedImage = document.getElementById('selected-image'); // Thẻ hiển thị đường dẫn

                if (fileInput.files.length > 0) {
                    const fileName = fileInput.files[0].name;
                    fileNameInput.value = fileName;
                    selectedImage.textContent = "Hình ảnh được chọn: /image/" + fileName;
                    console.log("Tên file được chọn: " + fileName);
                } else {
                    selectedImage.textContent = "";
                }
            }
        </script>
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        <a href="/admin/php/product_list.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>