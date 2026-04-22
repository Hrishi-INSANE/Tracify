<!DOCTYPE html>
<html>
<head>
    <title>Tracify - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="layout">

    <div class="sidebar">
        <h2>Tracify</h2>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Focus Hub</a>
        <a href="history.php">History</a>
    </div>

    <div class="main">

        <div class="timer-wrapper">

            <div class="timer-card">

                <h2 id="active-block">No Block Selected</h2>

                <div class="timer-circle">

                    <svg class="progress-ring" width="380" height="380">
                        <circle class="progress-bg" cx="190" cy="190" r="170"></circle>
                        <circle class="progress" cx="190" cy="190" r="170"></circle>
                    </svg>

                    <div id="big-timer">25:00</div>

                </div>

                <div class="timer-controls">
                    <input type="number" id="duration-input" value="25" min="1">
                    <button id="main-btn" onclick="toggleTimer()">Start</button>
                    <button onclick="stopTimer(true)" class="danger">Finish</button>
                </div>

            </div>

        </div>

    </div>

</div>

<div id="complete-popup" class="complete-popup">
    ✅ Session Complete
</div>

<script src="assets/js/app.js"></script>
</body>
</html>