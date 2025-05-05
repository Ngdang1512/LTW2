<?php
include 'db.php';

$result = $conn->query("SELECT * FROM orders");
echo "<table class='table'><tr><th>ID</th><th>Khách hàng</th><th>Ngày</th><th>Địa chỉ</th><th>Trạng thái</th><th>Hành động</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['customer_name']}</td>
        <td>{$row['order_date']}</td>
        <td>{$row['address']}</td>
        <td>{$row['status']}</td>
        <td>
            <a href='update_order_form.html?id={$row['id']}'>Sửa</a> |
            <a href='delete_order.php?id={$row['id']}' onclick=\"return confirm('Xóa đơn hàng này?')\">Xóa</a>
        </td>
    </tr>";
}
echo "</table>";

$conn->close();
?>