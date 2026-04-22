<?php
include '../../db.php';

$result = mysqli_query($conn, "SELECT block_id FROM logs WHERE DATE(recorded_at) = CURDATE()");

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = (int)$row['block_id'];
}

echo json_encode($data);
?>