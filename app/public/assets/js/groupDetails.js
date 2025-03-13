const groupId = new URLSearchParams(window.location.search).get('group_id');
const apiEndpoint = `/api/groups/${groupId}`;
const taskApiEndpoint = `/api/groups/${groupId}/tasks`;

// Fetch group details
async function fetchGroupDetails() {
    try {
        const response = await fetch(apiEndpoint);
        if (!response.ok) throw new Error('Failed to fetch group details');

        const data = await response.json();
        document.getElementById('groupName').textContent = data.group.name;
        document.getElementById('groupDescription').textContent = data.group.description;

        renderGroupTasks(data.tasks);
        renderGroupMembers(data.members);
    } catch (error) {
        console.error('Error fetching group details:', error);
    }
}

function renderGroupTasks(tasks) {
    const tasksList = document.getElementById('groupTasksList');
    tasksList.innerHTML = '';

    tasks.forEach(task => {
        // Create the task item with details
        const taskItem = document.createElement('li');
        taskItem.className = `task-item ${task.is_completed ? 'completed' : ''}`;
        taskItem.innerHTML = `
            <div class="task-header">
                <span>${task.title} - ${task.due_date}</span>
                <div>
                    <button class="complete-button" onclick="markTaskComplete(${task.id})">Complete</button>
                    <button class="delete-button" onclick="deleteTask(${task.id})">Delete</button>
                </div>
            </div>
            <div class="task-details" style="display: none;">
                <p><strong>Description:</strong> ${task.description || 'No description available'}</p>
                <p><strong>Priority:</strong> ${task.priority}</p>
                <p><strong>Status:</strong> ${task.is_completed ? 'Completed' : 'Pending'}</p>
            </div>
        `;

        // Add toggle behavior to show task details
        taskItem.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') return; // Avoid toggling when clicking buttons
            const details = taskItem.querySelector('.task-details');
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        });

        tasksList.appendChild(taskItem);
    });
}

async function addTask(event) {
    event.preventDefault();
    const title = document.getElementById('taskTitle').value;
    const description = document.getElementById('taskDescription').value;
    const priority = document.getElementById('taskPriority').value;
    const dueDate = document.getElementById('taskDueDate').value;

    try {
        const response = await fetch(taskApiEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                title: title,
                description: description,
                priority: priority,
                due_date: dueDate,
                group_id: groupId
            }),
        });

        if (!response.ok) throw new Error('Failed to add task');

        fetchGroupDetails();
        taskModal.style.display = 'none';
        document.getElementById('addTaskForm').reset();
    } catch (error) {
        console.error('Error adding task:', error);
    }
}

async function deleteTask(taskId) {
    try {
        const response = await fetch(`/api/groups/tasks/delete/${taskId}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to delete task');
        fetchGroupDetails();
    } catch (error) {
        console.error('Error deleting task:', error);
    }
}

async function markTaskComplete(taskId) {
    try {
        const response = await fetch(`/api/groups/tasks/complete/${taskId}`, { method: 'PUT' });
        if (!response.ok) throw new Error('Failed to complete task');
        fetchGroupDetails();
    } catch (error) {
        console.error('Error completing task:', error);
    }
}

// Group Members Management
function renderGroupMembers(members) {
    const membersList = document.getElementById('groupMembersList');
    membersList.innerHTML = '';
    members.forEach(member => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${member.username}</span>
            <button class="remove-btn" onclick="removeUser(${member.id})">
                <i class="fas fa-user-minus"></i> Remove
            </button>`;
        membersList.appendChild(li);
    });
}

async function addUser(event) {
    event.preventDefault();
    const userIdentifier = document.getElementById('userIdentifier').value;
    try {
        const response = await fetch(`${apiEndpoint}/add-user`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userIdentifier })
        });
        if (!response.ok) throw new Error('Failed to add user');
        fetchGroupDetails();
        document.getElementById('addUserResponse').textContent = 'User added successfully!';
    } catch (error) {
        console.error('Error adding user:', error);
        document.getElementById('addUserResponse').textContent = 'Failed to add user!';
    }
}

async function removeUser(memberId) {
    try {
        const response = await fetch(`/api/groups/remove-member/${memberId}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to remove user');
        fetchGroupDetails();
    } catch (error) {
        console.error('Error removing user:', error);
    }
}

// Modal Logic
const openTaskModal = document.getElementById('openTaskModal');
const taskModal = document.getElementById('taskModal');
const closeTaskModal = document.getElementById('closeTaskModal');

// Open modal
openTaskModal.addEventListener('click', () => {
    taskModal.style.display = 'flex';
});

// Close modal
closeTaskModal.addEventListener('click', () => {
    taskModal.style.display = 'none';
});

// Close modal when clicking outside
window.addEventListener('click', (event) => {
    if (event.target === taskModal) {
        taskModal.style.display = 'none';
    }
});

document.getElementById('addTaskForm').addEventListener('submit', addTask);
document.getElementById('addUserForm').addEventListener('submit', addUser);
document.addEventListener('DOMContentLoaded', fetchGroupDetails);
