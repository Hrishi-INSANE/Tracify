<?php
include '../../db.php';

// Set JSON response header
header("Content-Type: application/json");

// Validate input
if (!isset($_POST['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "ID is required"
    ]);
    exit;
}

$id = intval($_POST['id']); // ensure integer

// Prepare statement
$stmt = $conn->prepare("DELETE FROM blocks WHERE id = ?");

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Prepare failed"
    ]);
    exit;
}

$stmt->bind_param("i", $id);

// Execute
if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "deleted_id" => $id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Delete failed"
    ]);
}

$stmt->close();
$conn->close();
?>