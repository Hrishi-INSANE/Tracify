<?php
include '../../db.php';

// Get distinct days (YYYY-MM-DD) where user has any logs
$result = $conn->query("
    SELECT DISTINCT DATE(recorded_at) AS day
    FROM logs
    ORDER BY day DESC
");

$days = [];
while ($row = $result->fetch_assoc()) {
    $days[] = $row['day'];
}

// Calculate current streak (from today backwards)
$streak = 0;

$today = new DateTime("today");

foreach ($days as $d) {
    $day = new DateTime($d);

    // Difference in days between expected date and this log date
    $diff = $today->diff($day)->days;

    if ($diff === 0) {
        $streak++;
        $today->modify('-1 day');
    } else {
        break;
    }
}

echo json_encode([
    "streak" => $streak
]);