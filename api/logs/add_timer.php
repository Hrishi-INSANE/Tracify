<?php
include '../../db.php';

$block_id = $_POST['block_id'];
$value = $_POST['value'];

$stmt = $conn->prepare("INSERT INTO logs (block_id, value, status) VALUES (?, ?, 'completed')");
$stmt->bind_param("ii", $block_id, $value);
$stmt->execute();

echo json_encode(["ok" => true]);
?>