const apiEndpoint = '/api/tasks';

document.getElementById('addTaskForm').addEventListener('submit', async (event) => {
    event.preventDefault(); 

    // Get form data
    const title = document.getElementById('title').value;
    const subjectId = document.getElementById('subject_id').value;
    const description = document.getElementById('description').value;
    const priority = document.getElementById('priority').value;
    const dueDate = document.getElementById('due_date').value;

    // Construct the JSON payload
    const taskData = {
        title: title,
        subject_id: subjectId,
        description: description,
        priority: priority,
        due_date: dueDate
    };

    try {
        // Send the POST request to the API
        const response = await fetch(apiEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(taskData)
        });

        const responseData = await response.json(); // Parse the JSON response

        if (response.ok) {
            fetchTasks();
            modal.style.display = "none";
            document.getElementById('addTaskForm').reset();

            document.getElementById('responseMessage').textContent = '';
        } else {
            // Display error message
            document.getElementById('responseMessage').textContent = responseData.error || 'Failed to add task';
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('responseMessage').textContent = 'An unexpected error occurred';
    }
});




document.addEventListener("DOMContentLoaded", () => {
    fetchTasks();
    populateSubjectsDropdown();

    // Filter Event Listeners
    document.getElementById('filterByPriority').addEventListener('change', fetchTasks);
});

function fetchTasks() {
    const priorityFilter = document.getElementById('filterByPriority').value;

    fetch(apiEndpoint)
        .then(response => response.json())
        .then(data => {
            const taskslist = document.getElementById('taskList');
            taskslist.innerHTML = '';

            const filteredTasks = data.filter(task => {
                return (!priorityFilter || task.priority === priorityFilter);
            });

            filteredTasks.forEach(task => {
                // Create task item
                const taskitem = document.createElement('li');
                taskitem.className = `task-item ${task.is_completed ? 'completed' : ''}`;
                taskitem.innerHTML = `
                    <div class="task-header">
                        <span>${task.title} - ${task.due_date}</span>
                        <div>
                            <button class="complete-button" data-task-id="${task.id}">Complete</button>
                            <button class="delete-button" data-task-id="${task.id}">Delete</button>
                        </div>
                    </div>
                    <div class="task-details" style="display: none;">
                        <p><strong>Description:</strong> ${task.description || 'No description available'}</p>
                        <p><strong>Priority:</strong> ${task.priority}</p>
                        <p><strong>Due Date:</strong> ${task.due_date}</p>
                        <p><strong>Status:</strong> ${task.is_completed ? 'Completed' : 'Pending'}</p>
                    </div>
                `;

                // Add Event Listeners for Buttons
                taskitem.querySelector('.delete-button').addEventListener('click', () => deleteTask(task.id));
                taskitem.querySelector('.complete-button').addEventListener('click', () => completeTask(task.id));

                // Toggle Task Details on Click
                taskitem.addEventListener('click', (event) => {
                    // Prevent button click events from propagating to this event
                    if (event.target.tagName === 'BUTTON') return;

                    const details = taskitem.querySelector('.task-details');
                    details.style.display = details.style.display === 'none' ? 'block' : 'none';
                });

                taskslist.appendChild(taskitem);
            });
        })
        .catch(error => console.error('Error fetching tasks:', error));
}


async function completeTask(taskId) {
    try {
        const response = await fetch(`/api/tasks/complete/${taskId}`, {
            method: 'PATCH'
        });
        if (response.ok) {
            console.log(`Task ${taskId} marked as completed.`);
            fetchTasks(); // Refresh the task list
        } else {
            console.error(`Failed to complete task: ${response.status}`);
        }
    } catch (error) {
        console.error('Error completing task:', error);
    }
}
async function deleteTask(taskId) {
    try {
        const response = await fetch(`/api/tasks/delete/${taskId}`, {
            method: 'DELETE'
        });
        if (response.ok) {
            console.log(`Task ${taskId} Deleted.`);
            fetchTasks(); // Refresh the task list
        } else {
            console.error(`Failed to delete task: ${response.status}`);
        }
    } catch (error) {
        console.error('Error deleting task:', error);
    }
}


var modal = document.getElementById('addtaskModal');
var addtaskButton = document.getElementById('addTaskButton');
var span = document.getElementsByClassName("close")[0];


addtaskButton.onclick = function(){
    modal.style.display = "block"
}
span.onclick = function() {
    modal.style.display = "none";
  }
  
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  async function populateSubjectsDropdown() {
    try {
        const response = await fetch('/api/subjects'); // Fetch subjects from the API
        if (!response.ok) {
            throw new Error(`Failed to fetch subjects: ${response.statusText}`);
        }

        const subjects = await response.json(); // Parse the response as JSON
        const subjectDropdown = document.getElementById('subject_id'); // Target the dropdown

        // Clear the dropdown before adding new options
        subjectDropdown.innerHTML = '<option value="" disabled selected>Select a Subject</option>';

        // Populate the dropdown with subjects
        subjects.forEach(subject => {
            const option = document.createElement('option');
            option.value = subject.id; // Use the subject ID as the value
            option.textContent = subject.name; // Display the subject name
            subjectDropdown.appendChild(option);
        });
    } catch (error) {
        console.error('Error populating subjects dropdown:', error);
    }
}






 

  