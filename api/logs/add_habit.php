<?php
include '../../db.php';

$block_id = $_POST['block_id'];

$stmt = $conn->prepare("INSERT INTO logs (block_id, value, status) VALUES (?, 1, 'completed')");
$stmt->bind_param("i", $block_id);
$stmt->execute();

echo json_encode(["ok" => true]);
?>