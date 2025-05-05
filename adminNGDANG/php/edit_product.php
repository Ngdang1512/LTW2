<?php
include '../db_admin/connect.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM ad_products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $image = $product['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");
    }

    $stmt = $conn->prepare("UPDATE ad_products SET name = ?, category = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $category, $image, $id);

    if ($stmt->execute()) {
        header("Location: product_list.php");
        exit();
    } else {
        $error = "Không thể cập nhật sản phẩm!";
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
<body>
<div class="container mt-5">
    <h2 class="text-center">Sửa sản phẩm</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Phân loại</label>
            <input type="text" class="form-control" id="category" name="category" value="<?php echo $product['category']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <img src="../uploads/<?php echo $product['image']; ?>" alt="Hình ảnh hiện tại" class="mt-3" style="max-width: 100px;">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="product_list.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>