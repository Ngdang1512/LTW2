<?php
include '../db_admin/connect.php';

$id = $_GET['id'];
$sold = $conn->query("SELECT COUNT(*) AS count FROM ad_orders WHERE product_id = $id")->fetch_assoc()['count'];

if ($sold > 0) {
    $stmt = $conn->prepare("UPDATE ad_products SET visible = 0 WHERE id = ?");
} else {
    $stmt = $conn->prepare("DELETE FROM ad_products WHERE id = ?");
}
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: product_list.php");
    exit();
} else {
    echo "Không thể xoá sản phẩm!";
}
?>