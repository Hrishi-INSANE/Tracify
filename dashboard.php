<!DOCTYPE html>
<html>
<head>
    <title>Focus Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Tracify</h2>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Focus Hub</a>
        <a href="history.php">History</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="dashboard-wrapper">

            <!-- HEADER -->
            <div class="dashboard-header">
                <h1>Focus Hub</h1>
                <p>Create and manage your focus blocks</p>
            </div>

            <!-- ADD BLOCK -->
            <div class="card add-block-card">

                <h3 style="margin-bottom: 15px;">Create Block</h3>

                <form id="form" class="block-form">

                    <input 
                        type="text" 
                        name="title" 
                        placeholder="e.g. Study, Workout, Reading" 
                        required
                    >

                    <select name="type">
                        <option value="timer">Timer</option>
                        <option value="habit">Habit</option>
                    </select>

                    <input type="color" name="color">

                    <button type="submit">Add Block</button>

                </form>

            </div>

            <!-- BLOCKS -->
            <div class="card">

                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h3>Your Blocks</h3>
                    <span style="color:#9ca3af; font-size:14px;">
                        Click a block to activate
                    </span>
                </div>

                <div id="blocks" class="blocks"></div>

                <!-- EMPTY STATE -->
                <div id="empty-state" style="margin-top:20px; color:#6b7280; text-align:center; display:none;">
                    No blocks yet. Start by creating one above.
                </div>

            </div>

        </div>

    </div>

</div>

<script src="assets/js/app.js"></script>
</body>
</html>