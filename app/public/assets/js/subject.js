const apiEndpoint = '/api/subjects';

document.getElementById('addsubjectForm').addEventListener('submit', async (event) => {
    event.preventDefault();

    const name = document.getElementById('subject_name').value;
    const subjectdata = { name: name };

    try {
        const response = await fetch(apiEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(subjectdata)
        });

        if (response.ok) {
            fetchSubjects();
            modal.style.display = "none";
            document.getElementById('addsubjectForm').reset();
        } else {
            console.error('Failed to add subject');
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

// Modal Logic
var modal = document.getElementById('addsubjectModal');
var addsubjectButton = document.getElementById('addsubjectButton');
var span = document.getElementsByClassName("close")[0];

addsubjectButton.onclick = function () {
    modal.style.display = "block";
};
span.onclick = function () {
    modal.style.display = "none";
};
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

// Fetch and Render Subjects
function fetchSubjects() {
    fetch(apiEndpoint)
        .then(response => response.json())
        .then(data => {
            const subjectsGrid = document.getElementById('subjectsGrid');
            const subjectCount = document.getElementById('subjectCount');
            subjectsGrid.innerHTML = '';

            if (data.length === 0) {
                subjectCount.textContent = "You have no subjects.";
                subjectsGrid.innerHTML = '<p class="empty-state">No subjects available. Add a new one!</p>';
                return;
            }

            subjectCount.textContent = `You have ${data.length} subjects.`;

            data.forEach(subject => {
                const card = document.createElement('div');
                card.className = 'subject-card';

                card.innerHTML = `
                    <h2>${subject.name}</h2>
                    <button class="delete-button" data-subject-id="${subject.id}">Delete</button>
                `;

                card.querySelector('.delete-button').addEventListener('click', async () => {
                    if (confirm(`Are you sure you want to delete "${subject.name}"?`)) {
                        await deleteSubject(subject.id);
                    }
                });

                subjectsGrid.appendChild(card);
            });
        })
        .catch(error => console.error('Error fetching subjects:', error));
}

async function deleteSubject(subjectId) {
    try {
        const response = await fetch(`${apiEndpoint}/${subjectId}`, { method: 'DELETE' });

        if (response.ok) {
            fetchSubjects();
        } else {
            console.error('Failed to delete subject');
        }
    } catch (error) {
        console.error('Error deleting subject:', error);
    }
}

document.addEventListener('DOMContentLoaded', fetchSubjects);{
    fetchSubjects();
}
