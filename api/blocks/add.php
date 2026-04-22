<?php
include '../../db.php';

// Support BOTH JSON and form-data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $title = $data['title'] ?? '';
    $type  = $data['type'] ?? '';
    $color = $data['color'] ?? '#4e8b6f';
} else {
    $title = $_POST['title'] ?? '';
    $type  = $_POST['type'] ?? '';
    $color = $_POST['color'] ?? '#4e8b6f';
}

// Basic validation
if (!$title || !$type) {
    echo json_encode(["success" => false, "error" => "Missing fields"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO blocks (title, type, color) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $type, $color);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
?>