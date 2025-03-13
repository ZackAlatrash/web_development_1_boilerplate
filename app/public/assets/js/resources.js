document.addEventListener('DOMContentLoaded', () => {
    const uploadForm = document.getElementById('uploadResourceForm');
    const resourceType = document.getElementById('resourceType');
    const fileInput = document.getElementById('fileInput');
    const linkInput = document.getElementById('linkInput');
    const noteInput = document.getElementById('noteInput');
    const uploadResponse = document.getElementById('uploadResponse');
    const subjectDropdown = document.getElementById('subjectDropdown');
    const resourceTable = document.querySelector('#resourceTable tbody');
    const searchResources = document.getElementById('searchResources');
    const filterType = document.getElementById('filterType');
    const subjectDetails = document.getElementById('subjectDetails');
    const selectedSubjectName = document.getElementById('selectedSubjectName');
    const selectedSubjectDescription = document.getElementById('selectedSubjectDescription');
    const uploadButton = uploadForm.querySelector('button[type="submit"]');
    const fileField = document.querySelector('#file');

    // Disable the button initially
    uploadButton.disabled = true;

    // Monitor file input and enable the button only if a file is selected
    function monitorFileField() {
        if (fileField.files.length > 0) {
            uploadButton.disabled = false; // Enable button if a file is selected
        } else {
            uploadButton.disabled = true; // Disable button if no file is selected
        }
    }

    // Add event listener for file field
    fileField.addEventListener('change', monitorFileField);

    // Fetch Subjects for Dropdown
    async function fetchSubjects() {
        try {
            const response = await fetch('/api/subjects'); // Replace with your actual endpoint
            const subjects = await response.json();

            subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                subjectDropdown.appendChild(option);
            });

            subjectDropdown.addEventListener('change', () => {
                const selectedSubject = subjects.find(s => s.id === parseInt(subjectDropdown.value));
                if (selectedSubject) {
                    selectedSubjectName.textContent = selectedSubject.name;
                    selectedSubjectDescription.textContent = selectedSubject.description || 'No description available.';
                    subjectDetails.classList.remove('hidden');
                } else {
                    subjectDetails.classList.add('hidden');
                }
            });
        } catch (error) {
            console.error('Error fetching subjects:', error);
        }
    }

    // Show relevant input fields based on resource type
    resourceType.addEventListener('change', () => {
        fileInput.classList.add('hidden');
        linkInput.classList.add('hidden');
        noteInput.classList.add('hidden');
        uploadButton.disabled = true; // Reset button for other resource types

        if (resourceType.value === 'file') {
            fileInput.classList.remove('hidden');
            monitorFileField(); // Check file input state
        } else if (resourceType.value === 'link') {
            linkInput.classList.remove('hidden');
            uploadButton.disabled = false; // Enable for links
        } else if (resourceType.value === 'note') {
            noteInput.classList.remove('hidden');
            uploadButton.disabled = false; // Enable for notes
        }
    });

    // Upload Resource
    uploadForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(uploadForm);

        try {
            const response = await fetch('/api/resources/upload', { method: 'POST', body: formData });
            const jsonResponse = await response.json();

            if (response.ok) {
                uploadResponse.textContent = jsonResponse.message;
                fetchResources();
                uploadForm.reset();
                uploadButton.disabled = true; // Disable button after upload
            } else {
                uploadResponse.textContent = jsonResponse.error || 'Failed to upload resource.';
            }
        } catch (error) {
            console.error('Failed to upload resource:', error);
            uploadResponse.textContent = 'An unexpected error occurred.';
        }
    });

    // Fetch and Display Resources
    async function fetchResources() {
        if (!resourceTable) {
            console.error('Error: Resource table not found in the DOM.');
            return;
        }

        try {
            const response = await fetch('/api/resources');
            if (!response.ok) {
                throw new Error('Failed to fetch resources');
            }

            const resources = await response.json();
            resourceTable.innerHTML = ''; // Clear the table

            if (resources.length === 0 || resources.message === 'No resources found for this user') {
                const noResourcesRow = document.createElement('tr');
                noResourcesRow.innerHTML = `
                    <td colspan="4" style="text-align: center;">No resources found.</td>
                `;
                resourceTable.appendChild(noResourcesRow);
                return;
            }

            resources.forEach(resource => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${resource.type.toUpperCase()}</td>
                    <td>${resource.subject_name || 'No Subject'}</td>
                    <td>${resource.note || resource.resource_path || 'N/A'}</td>
                    <td>
                        ${resource.type === 'file' ? `<a href="/${resource.resource_path}" target="_blank">Download</a>` : ''}
                        ${resource.type === 'link' ? `<a href="${resource.resource_path}" target="_blank">Open Link</a>` : ''}
                    </td>
                `;
                resourceTable.appendChild(row);
            });
        } catch (error) {
            console.error('Error fetching resources:', error);
        }
    }

    // Filter Resources
    function filterResources() {
        const searchValue = searchResources.value.toLowerCase();
        const typeFilter = filterType.value;

        Array.from(resourceTable.rows).forEach(row => {
            const type = row.cells[0].textContent.toLowerCase();
            const description = row.cells[2].textContent.toLowerCase();

            const matchesType = !typeFilter || type === typeFilter;
            const matchesSearch = !searchValue || description.includes(searchValue);

            row.style.display = matchesType && matchesSearch ? '' : 'none';
        });
    }

    searchResources.addEventListener('input', filterResources);
    filterType.addEventListener('change', filterResources);

    fetchSubjects();
    fetchResources();
});
