<?php
include '../../db.php';

header('Content-Type: application/json');

$query = mysqli_query($conn, "
    SELECT logs.*, blocks.title 
    FROM logs 
    JOIN blocks ON logs.block_id = blocks.id 
    ORDER BY recorded_at DESC
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
?>