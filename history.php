<!DOCTYPE html>
<html>
<head>
    <title>History</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Tracify</h2>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="history.php">History</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div style="max-width: 700px; width:100%;">

            <h1>History</h1>


            <div class="card" style="margin-bottom:20px;">
            <h3>Current Streak</h3>
            <h1 id="streak-count">0 🔥</h1>
            </div>
            
            <!-- ✅ SUMMARY -->
            <div class="summary-box">
                <h3>Today</h3>
                <p id="today-time">0 min</p>
                <p id="today-sessions">0 sessions</p>
            </div>

            <!-- ✅ WEEK GRID -->
            <div>
                <h3>Last 7 Days</h3>
                <div id="week-grid" class="week-grid"></div>
            </div>

            <!-- ✅ LOGS -->
            <div>
                <h3>Sessions</h3>
                <div id="history"></div>
            </div>

        </div>

    </div>

</div>

<script src="assets/js/app.js"></script>
</body>
</html>