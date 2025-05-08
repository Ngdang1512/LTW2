<?php
include '../db_admin/connect.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_code = trim($_POST['product_code']);
    $title = trim($_POST['title']);
    $brand = trim($_POST['brand']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $image = $product['image']; // Giữ hình ảnh cũ nếu không có hình ảnh mới

    // Kiểm tra và xử lý upload hình ảnh mới
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $upload_dir = "../adminNGDANG/image/";
        $upload_path = $upload_dir . $image;

        // Kiểm tra định dạng file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            $error = "Chỉ chấp nhận các định dạng JPG, PNG, GIF, WEBP.";
        } else {
            // Di chuyển file upload vào thư mục
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $error = "Không thể upload hình ảnh!";
            }
        }
    }

    // Nếu không có lỗi, cập nhật sản phẩm vào cơ sở dữ liệu
    if (!isset($error)) {
        $stmt = $conn->prepare("UPDATE products SET product_code = ?, title = ?, brand = ?, category = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssssdsi", $product_code, $title, $brand, $category, $price, $description, $image, $id);

        if ($stmt->execute()) {
            header("Location: product_list.php");
            exit();
        } else {
            $error = "Không thể cập nhật sản phẩm!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .content {
        margin-left: 250px; /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
        padding: 20px;
    }
</style>

<body>
<div class="container mt-5">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <h2 class="text-center">Sửa sản phẩm</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form class="content" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_code" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="product_code" name="product_code" value="<?php echo $product['product_code']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $product['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Hãng</label>
            <select class="form-select" id="brand" name="brand" required>
                <option value="Yonex" <?php echo $product['brand'] == 'Yonex' ? 'selected' : ''; ?>>Yonex</option>
                <option value="Lining" <?php echo $product['brand'] == 'Lining' ? 'selected' : ''; ?>>Lining</option>
                <option value="Mizuno" <?php echo $product['brand'] == 'Mizuno' ? 'selected' : ''; ?>>Mizuno</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Phân loại</label>
            <select class="form-select" id="category" name="category" required>
                <option value="Vợt cầu lông" <?php echo $product['category'] == 'Vợt cầu lông' ? 'selected' : ''; ?>>Vợt cầu lông</option>
                <option value="Quần áo thể thao" <?php echo $product['category'] == 'Quần áo thể thao' ? 'selected' : ''; ?>>Quần áo thể thao</option>
                <option value="Phụ kiện" <?php echo $product['category'] == 'Phụ kiện' ? 'selected' : ''; ?>>Phụ kiện</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá sản phẩm</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo $product['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
            <img id="preview" class="preview-img" src="<?php echo $product['image']; ?>" alt="Hình ảnh hiện tại" style="max-width: 100px;">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        <a href="product_list.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    }
</script>
</body>
</html>