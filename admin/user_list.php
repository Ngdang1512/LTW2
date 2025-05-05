<?php
include 'connect.php';
$result = $conn->query("SELECT * FROM ad_users");
$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
?>
