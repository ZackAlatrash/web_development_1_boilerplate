document.addEventListener('DOMContentLoaded', async function () {
    const calendarEl = document.getElementById('calendar');
    const priorityFilter = document.getElementById('priorityFilter');
    const subjectFilter = document.getElementById('subjectFilter');

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

                // Apply filters
                const filteredTasks = tasks.filter(task => {
                    return (!priorityFilter.value || task.priority === priorityFilter.value) &&
                           (!subjectFilter.value || task.subject_id === parseInt(subjectFilter.value));
                });

                const events = filteredTasks.map(task => ({
                    title: task.title,
                    start: task.due_date,
                    description: task.description || 'No description',
                    backgroundColor: task.is_completed ? 'green' : 'red',
                }));

                successCallback(events);
            } catch (error) {
                console.error('Error fetching tasks:', error);
                failureCallback(error);
            }
        },
        eventClick: function (info) {
            alert(`Task: ${info.event.title}\nDescription: ${info.event.extendedProps.description}`);
        }
    });

    calendar.render();

    // Add event listeners to filters
    priorityFilter.addEventListener('change', () => calendar.refetchEvents());
    subjectFilter.addEventListener('change', () => calendar.refetchEvents());

    // Populate subject filter
    fetch('/api/subjects')
        .then(response => response.json())
        .then(subjects => {
            subjectFilter.innerHTML = '<option value="">All</option>';
            subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                subjectFilter.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching subjects:', error));
});
