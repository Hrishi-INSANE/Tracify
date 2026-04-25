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

        <!-- THEME TOGGLE -->
        <button onclick="toggleTheme()" style="margin-top:20px;">🌗</button>
    </div>

    <div class="main">

        <div class="timer-wrapper">

            <div class="timer-card">

                <h2 id="active-block">No Block Selected</h2>

                <!-- 🔥 FOCUS STATE -->
                <div class="focus-meta">
                    <p id="focus-status">Ready to focus</p>
                    <p id="focus-quote"></p>
                </div>

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

                <!-- 🔥 EXTRA CONTEXT -->
                <div class="focus-extra">
                    <div class="mini-card">
                        <h4>Today</h4>
                        <p id="today-time">0 min</p>
                    </div>

                    <div class="mini-card">
                        <h4>Streak</h4>
                        <p id="streak-count">0 🔥</p>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- 🔥 COMPLETION POPUP -->
<div id="complete-popup" class="complete-popup">
    ✅ Session Complete
</div>

<script src="assets/js/app.js"></script>

<!-- 🔥 ADD THIS SCRIPT BLOCK (UI polish only) -->
<script>
    // Motivational quotes (light touch, not cringe)
    const quotes = [
        "Start small. Stay consistent.",
        "Discipline beats motivation.",
        "One session at a time.",
        "You showed up. That matters.",
        "Focus is your superpower."
    ];

    function loadQuote() {
        const el = document.getElementById("focus-quote");
        if (!el) return;

        const random = quotes[Math.floor(Math.random() * quotes.length)];
        el.innerText = random;
    }

    // Run on load
    loadQuote();
</script>

</body>
</html>