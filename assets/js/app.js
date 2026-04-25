let activeBlock = null;
let timerInterval = null;

// ---------------- INIT ----------------
document.addEventListener("DOMContentLoaded", () => {
    

    // 🔥 APPLY SAVED THEME
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "light") {
        document.body.classList.add("light");
    }

    if (document.getElementById("blocks")) loadBlocks();

    if (document.getElementById("history")) {
        loadHistory();
        loadSummary();
        loadStreak();
    }

    if (document.getElementById("active-block")) {
        let saved = localStorage.getItem("activeBlock");
        if (saved) {
            activeBlock = JSON.parse(saved);

            document.getElementById("active-block").innerText = activeBlock.title;

            const circle = document.querySelector(".timer-circle");
            if (circle) circle.style.borderColor = activeBlock.color;
        }
    }

    if (document.getElementById("big-timer")) {
        initializeTimerUI();
        runTimer();
    }

    attachFormHandler();
});


// ---------------- ADD BLOCK ----------------
function attachFormHandler() {
    const form = document.getElementById("form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = {
            title: form.title.value,
            type: form.type.value,
            color: form.color.value
        };

        try {
            const res = await fetch("api/blocks/add.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams(data)
            });

            const result = await res.json();

            if (result.success) {
                form.reset();
                loadBlocks();
            } else {
                alert(result.error || "Failed to add block");
            }

        } catch (err) {
            console.error(err);
            alert("Server error");
        }
    });
}


// ---------------- BLOCKS ----------------
function loadBlocks() {
    fetch('api/blocks/get.php')
        .then(r => r.json())
        .then(data => {
            let container = document.getElementById("blocks");
            if (!container) return;

            container.innerHTML = "";

            data.forEach(block => {
                let div = document.createElement("div");
                div.className = "block";
                div.style.background = block.color;
                div.dataset.id = block.id;

                div.innerHTML = `
                    <h3>${block.title}</h3>
                    <button class="delete-btn">✕</button>
                `;

                // SELECT BLOCK
                div.onclick = () => {
                    activeBlock = block;
                    localStorage.setItem("activeBlock", JSON.stringify(block));

                    document.querySelectorAll(".block").forEach(b => b.classList.remove("active"));
                    div.classList.add("active");

                    const circle = document.querySelector(".timer-circle");
                    if (circle) circle.style.borderColor = block.color;

                    const title = document.getElementById("active-block");
                    if (title) title.innerText = block.title;
                };

                // DELETE BLOCK
                div.querySelector(".delete-btn").onclick = (e) => {
                    e.stopPropagation();

                    fetch("api/blocks/delete.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `id=${block.id}`
                    })
                    .then(r => r.json())
                    .then(() => loadBlocks());
                };

                container.appendChild(div);
            });
        });
}


// ---------------- TIMER ----------------
function toggleTimer() {
    if (!localStorage.getItem("timerStart")) startTimer();
    else if (localStorage.getItem("paused")) resumeTimer();
    else pauseTimer();
}

function startTimer() {
    updateFocusState("running");
    if (!activeBlock) {
        alert("Select a block first");
        return;
    }

    let minutes = parseInt(document.getElementById("duration-input")?.value) || 25;
    let duration = minutes * 60;

    localStorage.setItem("timerDuration", duration);
    localStorage.setItem("timerStart", Date.now());
    localStorage.setItem("timerBlock", JSON.stringify(activeBlock));
    localStorage.removeItem("paused");
    localStorage.removeItem("remaining");

    document.getElementById("big-timer").innerText = format(duration);

    runTimer();
}

function runTimer() {
    clearInterval(timerInterval);

    let start = parseInt(localStorage.getItem("timerStart"));
    let duration = parseInt(localStorage.getItem("timerDuration"));
    let block = JSON.parse(localStorage.getItem("timerBlock"));

    if (!start || !duration || !block) return;

    activeBlock = block;

    let blockEl = document.getElementById("active-block");
    if (blockEl) blockEl.innerText = block.title;

    const circle = document.querySelector(".timer-circle");
    if (circle) circle.style.borderColor = block.color;

    timerInterval = setInterval(() => {
        if (localStorage.getItem("paused")) return;

        let elapsed = Math.floor((Date.now() - start) / 1000);
        let remaining = duration - elapsed;
        updateProgress(remaining, duration);

        if (remaining <= 0) {
            stopTimer(true);
            return;
        }

        let timerEl = document.getElementById("big-timer");
        if (timerEl) timerEl.innerText = format(remaining);

    }, 1000);

    updateButton();
}

function pauseTimer() {
    updateFocusState("paused");
    localStorage.setItem("paused", "true");
    localStorage.setItem("remaining", getRemaining());
    updateButton();
}

function resumeTimer() {
    let remaining = parseInt(localStorage.getItem("remaining"));
    let duration = parseInt(localStorage.getItem("timerDuration"));

    let newStart = Date.now() - (duration - remaining) * 1000;

    localStorage.setItem("timerStart", newStart);
    localStorage.removeItem("paused");

    runTimer();
}

function stopTimer(completed = false) {
    clearInterval(timerInterval);

    let block = JSON.parse(localStorage.getItem("timerBlock"));
    let duration = parseInt(localStorage.getItem("timerDuration"));

    if (completed && block) {

        let remaining = getRemaining();
        let actualTime = duration - remaining;
        showCompletionPopup();
updateFocusState("idle");

        if (actualTime >= 10) {
            fetch("api/logs/add_timer.php", {
                method: "POST",
                body: new URLSearchParams({
                    block_id: block.id,
                    value: actualTime
                })
            });
        }

        markBlockComplete(block.id);
    }

    resetTimerUI();
}

function markBlockComplete(blockId) {
    document.querySelectorAll(".block").forEach(b => {
        if (b.dataset.id == blockId) {
            b.classList.add("completed");
        }
    });
}

function resetTimerUI() {
    localStorage.clear();
    initializeTimerUI();
    updateButton();
}

function initializeTimerUI() {
    let input = document.getElementById("duration-input");
    let timerEl = document.getElementById("big-timer");
    updateFocusState("idle");

    if (input && timerEl) {
        let minutes = parseInt(input.value) || 25;
        timerEl.innerText = format(minutes * 60);
    }
}

function getRemaining() {
    let start = parseInt(localStorage.getItem("timerStart"));
    let duration = parseInt(localStorage.getItem("timerDuration"));
    let elapsed = Math.floor((Date.now() - start) / 1000);
    return duration - elapsed;
}

function updateButton() {
    let btn = document.getElementById("main-btn");
    if (!btn) return;

    if (!localStorage.getItem("timerStart")) btn.innerText = "Start";
    else if (localStorage.getItem("paused")) btn.innerText = "Resume";
    else btn.innerText = "Pause";
}

function format(s) {
    let m = Math.floor(s / 60);
    let sec = s % 60;
    return `${m}:${sec < 10 ? "0" : ""}${sec}`;
}

function updateProgress(remaining, duration) {
    const circle = document.querySelector(".progress");
    if (!circle) return;

    const radius = 170;
    const circumference = 2 * Math.PI * radius;

    const percent = remaining / duration;
    const offset = circumference * (1 - percent);

    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = offset;
}

// Focus state text
function updateFocusState(state) {
    const el = document.getElementById("focus-status");
    if (!el) return;

    if (state === "running") el.innerText = "🔵 In Focus";
    else if (state === "paused") el.innerText = "⏸ Paused";
    else el.innerText = "Ready to focus";
}

// Completion popup
function showCompletionPopup() {
    const popup = document.getElementById("complete-popup");
    if (!popup) return;

    popup.style.opacity = "1";
    setTimeout(() => popup.style.opacity = "0", 2000);
}

// Theme toggle
function toggleTheme() {
    const isLight = document.body.classList.toggle("light");

    // save preference
    localStorage.setItem("theme", isLight ? "light" : "dark");
}


// ---------------- HISTORY ----------------
function loadSummary() {
    fetch("api/logs/summary.php")
        .then(r => r.json())
        .then(data => {

            let timeEl = document.getElementById("today-time");
            let sessionsEl = document.getElementById("today-sessions");
            let grid = document.getElementById("week-grid");

            if (!timeEl || !sessionsEl || !grid) return;

            timeEl.innerText = Math.floor(data.today.time / 60) + " min";
            sessionsEl.innerText = data.today.sessions + " sessions";

            grid.innerHTML = "";

            for (let i = 6; i >= 0; i--) {
                let d = new Date();
                d.setDate(d.getDate() - i);

                let key = d.toISOString().split("T")[0];
                let value = data.week[key] || 0;

                let box = document.createElement("div");
                box.className = "day-box";

                if (value > 1500) box.classList.add("high");
                else if (value > 600) box.classList.add("medium");
                else if (value > 0) box.classList.add("low");

                box.title = `${Math.floor(value / 60)} min`;

                grid.appendChild(box);
            }
        });
}

function loadStreak() {
    fetch("api/logs/streak.php")
        .then(r => r.json())
        .then(data => {
            const el = document.getElementById("streak-count");
            if (el) el.innerText = data.streak + " 🔥";
        });
}

function loadHistory() {
    fetch("api/logs/history.php")
        .then(r => r.json())
        .then(data => {
            let container = document.getElementById("history");
            if (!container) return;

            container.innerHTML = "";

            data.forEach(item => {
                let minutes = Math.floor(item.value / 60);

                let div = document.createElement("div");
                div.className = "history-card";

                div.innerHTML = `
                    <strong>${item.title}</strong>
                    <span>${minutes} min</span>
                    <small>${item.recorded_at}</small>
                `;

                container.appendChild(div);
            });
        });
}