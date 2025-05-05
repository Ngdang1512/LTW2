<?php
include "connect.php";

$id = $_POST["id"];

// 1. Lấy role của user cần xoá
$stmt = $conn->prepare("SELECT role FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// 2. Nếu không tìm thấy user
if (!$user) {
    echo "Người dùng không tồn tại!";
    exit();
}

// 3. Nếu là admin, không cho xoá
if ($user['role'] === 'admin') {
    echo "❌ Không thể xoá tài khoản ADMIN!";
    exit();
}

// 4. Nếu là user bình thường, xoá
$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo "✅ Đã xoá user!";
?>
