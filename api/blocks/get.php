<?php
include '../../db.php';

$result = mysqli_query($conn, "SELECT * FROM blocks ORDER BY created_at DESC");

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>