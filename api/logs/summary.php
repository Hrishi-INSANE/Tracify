<?php
include '../../db.php';

// TODAY SUMMARY
$today = mysqli_query($conn, "
    SELECT 
        COUNT(*) as sessions,
        SUM(value) as total_time
    FROM logs
    WHERE DATE(recorded_at) = CURDATE()
");

$todayData = mysqli_fetch_assoc($today);

// LAST 7 DAYS
$week = mysqli_query($conn, "
    SELECT 
        DATE(recorded_at) as day,
        SUM(value) as total
    FROM logs
    WHERE recorded_at >= CURDATE() - INTERVAL 6 DAY
    GROUP BY day
");

$weekData = [];

while ($row = mysqli_fetch_assoc($week)) {
    $weekData[$row['day']] = (int)$row['total'];
}

echo json_encode([
    "today" => [
        "sessions" => (int)$todayData['sessions'],
        "time" => (int)$todayData['total_time']
    ],
    "week" => $weekData
]);
?>