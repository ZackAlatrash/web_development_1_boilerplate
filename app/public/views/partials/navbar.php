
<nav class="navbar">
    <div class="container">
        <a href="/dashboard" class="logo">My Study Planner</a>
        <ul class="nav-links">
            <li><a href="/dashboard" class="<?= $activePage === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="/tasks" class="<?= $activePage === 'tasks' ? 'active' : '' ?>">Tasks</a></li>
            <li><a href="/groups" class="<?= ($activePage === 'groups') ? 'active' : '' ?>">Groups</a></li>
            <li><a href="/subjects" class="<?= $activePage === 'subjects' ? 'active' : '' ?>">Subjects</a></li>
            <li><a href="/calender" class="<?= $activePage === 'calendar' ? 'active' : '' ?>">Calendar</a></li>
            <li><a href="/resources" class="<?= $activePage === 'resources' ? 'active' : '' ?>">Resources</a></li>
            <li><a href="/logout" class="logout">Logout</a></li>
        </ul>
        <button class="nav-toggle" aria-label="Toggle Navigation">
            <span class="hamburger"></span>
        </button>
    </div>
</nav>
