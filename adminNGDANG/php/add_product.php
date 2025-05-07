<?php
include '../db_admin/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $product_code = trim($_POST['product_code']);
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $brand = trim($_POST['brand']);
    $image = '';

     // Kiểm tra và xử lý upload hình ảnh
     if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $upload_dir = "../uploads/";
        $upload_path = $upload_dir . $image;
  
    // Kiểm tra định dạng file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        $error = "Chỉ chấp nhận các định dạng JPG, PNG, GIF.";
    } else {
        // Di chuyển file upload vào thư mục
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            $error = "Không thể upload hình ảnh!";
        }
    }
} else {
    $error = "Vui lòng chọn hình ảnh!";
}

if (!isset($error)) {
    $stmt = $conn->prepare("INSERT INTO products (product_code, title, category, price, description, image, brand) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsds", $product_code, $title, $category, $price, $description, $image, $brand);

    if ($stmt->execute()) {
        header("Location: product_list.php");
        exit();
    } else {
        $error = "Không thể thêm sản phẩm!";
    }
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
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Thêm sản phẩm</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_code" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="product_code" name="product_code" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Hãng </label>
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
            <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)" required>
            <img id="preview" class="preview-img" src="#" alt="Xem trước hình ảnh" style="display: none;">
        </div>
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        <a href="product_list.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }
</script>
</body>
</html>