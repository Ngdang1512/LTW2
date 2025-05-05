<!-- filepath: d:\xampp\htdocs\LTW2\adminNGDANG\php\delete_user.php -->
<?php
include '../db_admin/connect.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: user_list.php");
    exit();
} else {
    echo "Không thể xóa người dùng!";
}
?>