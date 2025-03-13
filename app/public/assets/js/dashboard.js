const dashboardEndpoint = '/api/dashboard/summary';
const subjectsEndpoint = '/api/subjects/overview';

// Timer Variables
let timerInterval;
let timeLeft = 25 * 60; // Default to 25 minutes for focus
let isRunning = false;
let pomodoroState = 'focus'; // 'focus', 'short-break', 'long-break'
let sessionCount = 0;

// DOM Elements for Timer
const timerDisplay = document.getElementById('timer-display');
const timerState = document.getElementById('timer-state');
const sessionCountDisplay = document.getElementById('session-count');
const startBtn = document.getElementById('start-timer');
const stopBtn = document.getElementById('stop-timer');
const resetBtn = document.getElementById('reset-timer');


// Fetch dashboard summary data
async function fetchDashboardData() {
    try {
        const response = await fetch(dashboardEndpoint);
        if (!response.ok) {
            throw new Error('Failed to fetch dashboard data');
        }
        const data = await response.json();

        // Update Task Summary
        document.getElementById('totalTasks').textContent = data.totalTasks;

        // Extract completed and pending tasks from taskStatus array
        const completed = data.taskStatus.find(status => status.is_completed === 1)?.count || 0;
        const pending = data.taskStatus.find(status => status.is_completed === 0)?.count || 0;

        document.getElementById('completedTasks').textContent = completed;
        document.getElementById('pendingTasks').textContent = pending;

        // Update Priority Breakdown
        const lowPriority = data.priorityBreakdown.find(priority => priority.priority === 'Low')?.count || 0;
        const mediumPriority = data.priorityBreakdown.find(priority => priority.priority === 'Medium')?.count || 0;
        const highPriority = data.priorityBreakdown.find(priority => priority.priority === 'High')?.count || 0;

        document.getElementById('lowPriority').textContent = lowPriority;
        document.getElementById('mediumPriority').textContent = mediumPriority;
        document.getElementById('highPriority').textContent = highPriority;

        // Update Upcoming Deadlines
        const deadlineList = document.getElementById('deadlineList');
        deadlineList.innerHTML = '';
        data.upcomingDeadlines.forEach(deadline => {
            const listItem = document.createElement('li');
            listItem.textContent = `${deadline.title} - Due: ${deadline.due_date}`;
            deadlineList.appendChild(listItem);
        });
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
}



async function fetchSubjectsOverview() {
    try {
        const response = await fetch(subjectsEndpoint);
        if (!response.ok) {
            throw new Error('Failed to fetch subjects data');
        }
        const subjects = await response.json();

        const subjectsList = document.getElementById('subjectsList');
        subjectsList.innerHTML = '';
        subjects.forEach(subject => {
            const listItem = document.createElement('li');
            listItem.textContent = `${subject.name}: ${subject.taskCount} tasks`;
            subjectsList.appendChild(listItem);
        });
    } catch (error) {
        console.error('Error fetching subjects:', error);
    }
}

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
}

function updateTimerDisplay() {
    timerDisplay.textContent = formatTime(timeLeft);
    sessionCountDisplay.textContent = `Completed Sessions: ${sessionCount}`;
}

function startTimer() {
    if (isRunning) return;
    isRunning = true;

    timerInterval = setInterval(() => {
        timeLeft--;
        updateTimerDisplay();

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            isRunning = false;
            handleTimerEnd();
        }
    }, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
    isRunning = false;
}

function resetTimer() {
    stopTimer();
    if (pomodoroState === 'focus') {
        timeLeft = 25 * 60;
    } else {
        timeLeft = 5 * 60;
    }
    updateTimerDisplay();
}

function handleTimerEnd() {
    if (pomodoroState === 'focus') {
        sessionCount++;
        if (sessionCount % 4 === 0) {
            timeLeft = 15 * 60; // Long break
            pomodoroState = 'long-break';
            timerState.textContent = 'Long Break';
            alert('Take a 15-minute break!');
        } else {
            timeLeft = 5 * 60; // Short break
            pomodoroState = 'short-break';
            timerState.textContent = 'Short Break';
            alert('Take a 5-minute break!');
        }
    } else {
        timeLeft = 25 * 60; // Focus session
        pomodoroState = 'focus';
        timerState.textContent = 'Focus Session';
        alert('Time to focus for 25 minutes!');
    }
    updateTimerDisplay();
}


function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: async function (fetchInfo, successCallback, failureCallback) {
            try {
                const response = await fetch('/api/tasks');
                if (!response.ok) {
                    throw new Error('Failed to fetch tasks');
                }
                const tasks = await response.json();

                const events = tasks.map(task => ({
                    title: task.title,
                    start: task.due_date,
                    description: task.description || 'No description',
                    backgroundColor: task.is_completed ? 'green' : 'red',
                }));

                successCallback(events);
            } catch (error) {
                console.error('Error fetching tasks for calendar:', error);
                failureCallback(error);
            }
        },
        eventClick: function (info) {
            alert(`Task: ${info.event.title}\nDescription: ${info.event.extendedProps.description}`);
        }
    });

    calendar.render();
}

// Event Listeners for Timer Buttons
startBtn.addEventListener('click', startTimer);
stopBtn.addEventListener('click', stopTimer);
resetBtn.addEventListener('click', resetTimer);

// Initialize Dashboard
document.addEventListener('DOMContentLoaded', () => {
    fetchDashboardData()
    fetchSubjectsOverview();
    initializeCalendar();
    fetchNotifications();
    updateTimerDisplay();

});
async function fetchNotifications() {
    try {
        const response = await fetch('/api/notifications');
        if (!response.ok) {
            throw new Error('Failed to fetch notifications');
        }
        const notifications = await response.json();

        const notificationsList = document.getElementById('notificationsList');
        notificationsList.innerHTML = ''; // Clear existing notifications

        if (notifications.length === 0) {
            const noNotification = document.createElement('li');
            noNotification.textContent = 'No notifications available';
            notificationsList.appendChild(noNotification);
        } else {
            notifications.forEach(notification => {
                const listItem = document.createElement('li');
                listItem.textContent = `Task: ${notification.title} - Due: ${notification.due_date}`;
                notificationsList.appendChild(listItem);
            });
        }

        // Show the notification modal
        const notificationModal = document.getElementById('notificationModal');
        notificationModal.style.display = 'block';

    } catch (error) {
        console.error('Error fetching notifications:', error);
    }
}
document.addEventListener('DOMContentLoaded', function () {
    const notificationModal = document.getElementById('notificationModal');
    const closeNotificationButton = document.querySelector('.modal .close');

    // Check if closeNotificationButton exists
    if (closeNotificationButton) {
        closeNotificationButton.onclick = function () {
            notificationModal.style.display = 'none';
        };
    }

    // Close the modal when the user clicks outside the modal
    window.onclick = function (event) {
        if (event.target === notificationModal) {
            notificationModal.style.display = 'none';
        }
    };
});


