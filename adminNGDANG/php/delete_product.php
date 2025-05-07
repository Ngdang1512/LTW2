<?php
include '../db_admin/connect.php';

// Kiểm tra xem tham số id có tồn tại không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: product_list.php");
    exit();
}

$id = intval($_GET['id']); // Đảm bảo id là số nguyên

// Kiểm tra xem sản phẩm đã được bán ra hay chưa
$sold = $conn->query("SELECT COUNT(*) AS count FROM order_details WHERE product_id = $id")->fetch_assoc()['count'];

if ($sold > 0) {
    // Nếu sản phẩm đã được bán ra, ẩn sản phẩm (visible = 0)
    $stmt = $conn->prepare("UPDATE products SET visible = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: product_list.php?message=Sản phẩm đã được bán ra, đã ẩn sản phẩm.");
        exit();
    } else {
        echo "Không thể ẩn sản phẩm!";
    }
} else {
    // Nếu sản phẩm chưa được bán ra, hỏi lại trước khi xóa
    if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
        // Hiển thị thông báo xác nhận
        echo "<script>
            if (confirm('Sản phẩm chưa được bán ra. Bạn có chắc chắn muốn xóa?')) {
                window.location.href = 'delete_product.php?id=$id&confirm=yes';
            } else {
                window.location.href = 'product_list.php';
            }
        </script>";
        exit();
    }

    // Xóa sản phẩm nếu người dùng xác nhận
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: product_list.php?message=Sản phẩm đã được xóa thành công.");
        exit();
    } else {
        echo "Không thể xóa sản phẩm!";
    }
}
?>