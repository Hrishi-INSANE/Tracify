<?php
include '../../db.php';

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM blocks WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["deleted" => true]);
?>